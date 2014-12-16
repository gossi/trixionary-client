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
use keeko\core\model\ActivityObject;

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
			$skill->deleteGroups();
			foreach ($request->request->get('groups', [], true) as $groupId) {
				$skill->addGroup(GroupQuery::create()->findOneById($groupId));
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
			

			// add parents
			$skill->deleteParents();
			foreach ($request->request->get('dependencies', [], true) as $skillId) {
				$skill->addParent(SkillQuery::create()->findOneById($skillId));
			}
			
			$multiple = $request->request->get('multiple');

			// set multiple
			if ($request->request->get('classification') == 'is_multiple') {
				$skill->setIsMultiple(true);
			}
			
			// set composite
			else if ($request->request->get('classification') == 'is_composite') {
				$skill->setIsComposite(true);
				
				// add parts  ... and also add them as parents
				$skill->deleteParents();
				$skill->deleteParts();
				foreach ($request->request->get('parts', [], true) as $skillId) {
					$s = SkillQuery::create()->findOneById($skillId);
					$skill->addPart($s);
					$skill->addParent($s);
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
				'verb' => $create ? ActivityObject::VERB_CREATE : ActivityObject::VERB_EDIT,
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
			'flags' => [
				'movender' => Skill::FLAG_MOVENDER,
				'movendum' => Skill::FLAG_MOVENDUM,
				'simultaneous' => Skill::FLAG_SIMULTANEOUS,
				'isolated' => Skill::FLAG_ISOLATED,
				'same' => Skill::FLAG_SAME,
				'opposite' => Skill::FLAG_OPPOSITE
			]
		]);
		
		if (!empty($this->params['skill'])) {
			$this->addData([
				'delete_url' => $router->generate('skill-delete', $sport, ['skill' => $skill->getSlug()]),
				'edit_url' => $router->generate('skill-edit', $sport, ['skill' => $skill->getSlug()]),
				'manage_pictures_url' => $router->generate('pictures', $sport, ['skill' => $skill->getSlug()]),
				'manage_videos_url' => $router->generate('videos', $sport, ['skill' => $skill->getSlug()]),
				'manage_references_url' => $router->generate('references', $sport, ['skill' => $skill->getSlug()]),
				'create_picture_url' => $router->generate('picture-create', $sport, ['skill' => $skill->getSlug()]),
				'create_video_url' => $router->generate('video-create', $sport, ['skill' => $skill->getSlug()]),
				'create_reference_url' => $router->generate('reference-create', $sport, ['skill' => $skill->getSlug()]),
			]);
		}
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