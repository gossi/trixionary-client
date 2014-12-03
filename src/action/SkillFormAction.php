<?php
namespace gossi\trixionary\client\action;

use Symfony\Component\HttpFoundation\Request;
use Cocur\Slugify\Slugify;
use Symfony\Component\HttpFoundation\RedirectResponse;
use gossi\trixionary\model\Skill;
use gossi\trixionary\model\SkillQuery;
use gossi\trixionary\model\SkillGroupQuery;
use gossi\trixionary\model\GroupQuery;
use gossi\trixionary\model\SkillGroup;
use gossi\trixionary\model\SkillDependencyQuery;
use gossi\trixionary\model\SkillDependency;
use gossi\trixionary\model\SkillPart;
use gossi\trixionary\model\SkillPartQuery;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Propel;

abstract class SkillFormAction extends AbstractSportAction {
	
	/**
	 * Automatically generated run method
	 * 
	 * @param Request $request
	 * @return Response
	 */
	public function run(Request $request) {
		$sport = $this->getSport();
		$skill = $this->getSkill();
		$router = $this->getModule()->getRouter();

		if ($request->isMethod('POST')) {
			$slug = $request->request->get('slug'); 
			if (empty($slug)) {
				$slugifier = new Slugify();
				$slug = $slugifier->slugify($request->request->get('name'));
			}
			$skill->setSlug($slug);
			$skill->setName($request->request->get('name'));
			$skill->setAlternativeName($request->request->get('alternative_names'));
			$skill->setSport($sport);
			
			// add groups
			$skill->getSkillGroups()->delete();
// 			if ($skill->getGroups()->count() > 0) {
// 				$skill->getGroups()->delete();
// 			}
// 			SkillGroupQuery::create()->filterBySkill($skill)->deleteAll();
			foreach ($request->request->get('groups', [], true) as $groupId) {
				$sg = (new SkillGroup())->setSkill($skill)->setGroupId($groupId);
				$skill->addSkillGroup($sg);
			}
			
			$skill->setDescription($request->request->get('description'));
			$skill->setHistory($request->request->get('history'));
			$skill->setMovementDescription($request->request->get('movement_description'));
			$skill->setStartPositionId($request->request->get('start_position'));
			$skill->setEndPositionId($request->request->get('end_position'));
			$skill->setIsTranslation($request->request->has('is_translation'));
			$skill->setIsRotation($request->request->has('is_rotation'));
			
			if ($request->request->has('cyclic')) {
				$skill->setIsCyclic($request->request->get('cyclic'));
			}
			
			if ($request->request->has('is_rotation')) {
				$skill->setLongitudinalFlags($this->getRotationFlags('longitudinal_flags', $request));
				$skill->setLatitudinalFlags($this->getRotationFlags('latitudinal_flags', $request));
				$skill->setTransversalFlags($this->getRotationFlags('transversal_flags', $request));
			}

			$variationOf = $request->request->get('variation_of');
			if (!empty($variationOf)) {
				$skill->setVariationOfId($variationOf);
			}
			

			// add ancients
			$skill->getSkillDependenciesRelatedBySkillId()->delete();
			foreach ($request->request->get('dependencies', [], true) as $skillId) {
				$skill->addAncient(SkillQuery::create()->findOneById($skillId));
			}
			
			$multiple = $request->request->get('multiple');

			// set multiple
			if ($request->request->get('classification') == 'is_multiple') {
				$skill->setIsMultiple(true);
			}
			
			// set composite
			else if ($request->request->get('classification') == 'is_composite') {
				$skill->setIsComposite(true);
				
				// add parts  ... and also add them as ancients
				$skill->getSkillPartsRelatedByCompositeId()->delete();
				$skill->getSkillDependenciesRelatedBySkillId()->delete();
				foreach ($request->request->get('parts', [], true) as $skillId) {
					$s = SkillQuery::create()->findOneById($skillId);
					$skill->addPart($s);
					$skill->addAncient($s);
				}
			}

			// multiple values
			else if (!empty($multiple)) {
				$skill->setMultipleOfId($request->request->get('multiple'));
				$skill->setMultiplier($request->request->get('multiplier'));
			}
			
			// audit
			if ($request->request->has('change_comment')) {
				$skill->setVersionComment($request->request->get('change_comment'));
			}

			$create = $skill->isNew();
			$skill->save();			
			
			$user = $this->getServiceContainer()->getAuthManager()->getUser();
			$user->newActivity([
				'verb' => $create ? 'create' : 'edit',
				'object' => $skill,
				'target' => $sport
			]);

			$url = $router->generate('skill', $sport, ['skill' => $skill->getSlug()]);
			return new RedirectResponse($url);
		}
		
		$skills = SkillQuery::create()->filterBySport($sport)->find();

		$this->addData([
			'skill' => $skill, 
			'positions' => $this->getPositions(),
			'groups' => $this->getGroups(),
			'skills' => $skills,
			'delete_url' => !empty($this->params['skill'])
				? $router->generate('skill-delete', $sport, ['skill' => $skill->getSlug()])
				: '',
			'edit_url' => !empty($this->params['skill'])
				? $router->generate('skill-edit', $sport, ['skill' => $skill->getSlug()])
				: '',
			'flags' => [
				'movender' => Skill::FLAG_MOVENDER,
				'movendum' => Skill::FLAG_MOVENDUM,
				'simultaneous' => Skill::FLAG_SIMULTANEOUS,
				'isolated' => Skill::FLAG_ISOLATED,
				'same' => Skill::FLAG_SAME,
				'opposite' => Skill::FLAG_OPPOSITE
			]
		]);
		return $this->getResponse($request);
	}
	
	private function getRotationFlags($key, $request) {
		$flags = 0;
		foreach ($request->request->get($key, [], true) as $val) {
			$flags |= $val;
		}
		 
		if (($flags & Skill::FLAG_MOVENDER) == Skill::FLAG_MOVENDER 
				&& ($flags & Skill::FLAG_MOVENDUM) == Skill::FLAG_MOVENDUM) {

			if (($flags & Skill::FLAG_ISOLATED) != Skill::FLAG_ISOLATED) {
				$flags = Skill::FLAG_MOVENDER | Skill::FLAG_MOVENDUM | Skill::FLAG_SIMULTANEOUS;
			}
		} else {
			$flags = $flags & Skill::FLAG_MOVENDER | $flags & Skill::FLAG_MOVENDUM;
		}
		
		return $flags;
	}
	
	private function getSkill() {
		if (isset($this->params['skill'])) {
			return SkillQuery::create()
				->filterBySlug($this->params['skill'])
				->filterBySport($this->getSport())
				->leftJoinSkillGroup()
				->findOne();
		}
	
		return new Skill();
	}
}