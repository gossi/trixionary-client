<?php
namespace gossi\trixionary\client\action;

use Symfony\Component\HttpFoundation\Request;
use gossi\trixionary\model\SkillQuery;
use gossi\trixionary\model\FunctionPhase;
use keeko\core\model\ActivityObject;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use gossi\trixionary\model\FunctionPhaseQuery;

/**
 * Batch update of Functionphases
 * 
 * @author gossi
 */
class FunctionphaseUpdateAction extends AbstractSportAction {

	/**
	 * Automatically generated run method
	 * 
	 * @param Request $request
	 * @return Response
	 */
	public function run(Request $request) {
		$sport = $this->getSport();
		$slug = $this->params['skill'];
		$skill = SkillQuery::create()->filterBySport($sport)->filterBySlug($slug)->findOne();
		
		$content = json_decode($request->getContent(), true);
		$nodes = $content['nodes'];
		$deleted = $content['deleted'];
		$report = [];
		
		$root = null;
		foreach ($skill->getKstrukturs() as $kstruktur) {
			if (!$kstruktur->getParent()) {
				$root = $kstruktur;
				break;
			}
		}
		
		// root deleted? delete all
		if ($root !== null && in_array($root->getId(), $deleted)) {
			FunctionPhaseQuery::create()->filterBySkill($skill)->delete();
		} else {
			foreach ($nodes as $node) {
				$isNew = false;
				$canSave = true;
				if (isset($node['isNew'])) {
					$isNew = true;
					$fp = new FunctionPhase();
					$fp->setTitle($node['label']);
					$fp->setType($node['group']);
					$fp->setParentId($node['parent']);
					$fp->setSkill($skill);
					
					$parentId = $node['parent'];
					if (isset($report[$parentId])) {
						$parentId = $report[$parentId];
					}
					$fp->setParentId($parentId);
				} else {
					$changed = false;
					$fp = FunctionPhaseQuery::create()->findOneById($node['id']);
					
					if ($fp->getTitle() != $node['label']) {
						$fp->setTitle($node['label']);
						$changed = true;
					}
					
					if ($fp->getType() != $node['group']) {
						$fp->setType($node['group']);
						$changed = true;
					}
					
					if ($fp->getParentId() != $node['parent']) {
						$parentId = $node['parent'];
						if (isset($report[$parentId])) {
							$parentId = $report[$parentId];
						}
						$fp->setParentId($parentId);
						$changed = true;
					}
					
					$canSave = $changed;
				}
				
				if ($canSave) {
					$fp->save();
					
					if ($isNew) {
						$report[$node['id']] = $fp->getId();
					}
					
					$user = $this->getServiceContainer()->getAuthManager()->getUser();
					$user->newActivity([
						'verb' => $isNew ? ActivityObject::VERB_ADD : ActivityObject::VERB_UPDATE,
						'object' => $fp,
						'target' => $skill
					]);
				}
			}

			foreach ($deleted as $id) {
				FunctionPhaseQuery::create()->filterById($id)->delete();
			}
		}
		
		$response = new JsonResponse($report);
		$response->prepare($request);
		$response->send();
		exit;
	}
	
	protected function setDefaultParams(OptionsResolverInterface $resolver) {
		$resolver->setRequired(['sport', 'skill']);
	}
}
