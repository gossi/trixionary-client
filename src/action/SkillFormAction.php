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
use Symfony\Component\Filesystem\Filesystem;
use Imagine\Gd\Imagine;

abstract class SkillFormAction extends AbstractSkillAction {
	
	const IMAGE_SIZE = 1600;
	
	/**
	 * Automatically generated run method
	 * 
	 * @param Request $request
	 * @return Response
	 */
	public function run(Request $request) {
		$sport = $this->getSport();
		$skill = $this->getSkill();
		$fs = new Filesystem();
		$sequenceExists = !$skill->isNew() && $fs->exists($this->getTrixionary()->getSequencePath($skill));

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
			
			// file uploaded
			$uploadname = $request->request->get('filename');
			if (!empty($uploadname)) {
				// create folder
				$skillFolder = $this->getTrixionary()->getSkillPath($skill);
				if (!$fs->exists($skillFolder)) {
					$fs->mkdir($skillFolder, 0777);
				}
				
				// load file
				$imagine = new Imagine();
				$image = $imagine->open($this->getTrixionary()->getUploadPath() . '/' . $uploadname);
				
				// resize
				$size = $image->getSize();
				if (max($size->getWidth(), $size->getHeight()) > self::IMAGE_SIZE) {
					if ($size->getWidth() > $size->getHeight()) {
						$size = $size->widen(self::IMAGE_SIZE);
					} else {
						$size = $size->heighten(self::IMAGE_SIZE);
					}
					$image = $image->resize($size);
				}

				// save
				$filename = $this->getTrixionary()->getSequencePath($skill);
				$image->save($filename, ['jpeg_quality' => 100]);
			}
			
			// delete uploaded file
			if ($sequenceExists && $request->request->get('sequence_delete')) {
				$fs->remove($this->getTrixionary()->getSequencePath($skill));
			} 

			$create = $skill->isNew();
			$skill->save();			
			
			$user = $this->getServiceContainer()->getAuthManager()->getUser();
			$user->newActivity([
				'verb' => $create ? ActivityObject::VERB_CREATE : ActivityObject::VERB_EDIT,
				'object' => $skill,
				'target' => $sport
			]);

			$url = $this->generateUrl('skill', ['skill' => $skill->getSlug()]);
			return new RedirectResponse($url);
		}
		
		$skills = SkillQuery::create()->filterBySport($sport)->find();

		$this->addData([
			'skill' => $skill,
			'sequence_url' => $sequenceExists ? $this->getTrixionary()->getSequenceUrl($skill) : '',
			'api_url' => $this->getServiceContainer()->getPreferenceLoader()->getSystemPreferences()->getApiUrl(),
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
	
	protected function getSkill() {
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