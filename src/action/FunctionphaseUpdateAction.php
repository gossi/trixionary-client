<?php
namespace gossi\trixionary\client\action;

use Symfony\Component\HttpFoundation\Request;
use gossi\trixionary\model\SkillQuery;
use gossi\trixionary\model\FunctionPhase;
use keeko\core\model\ActivityObject;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use gossi\trixionary\model\FunctionPhaseQuery;
use gossi\trixionary\model\StructureNodeParentQuery;
use gossi\trixionary\model\StructureNodeQuery;
use gossi\trixionary\model\StructureNodeParent;

/**
 * Batch update of Functionphases
 * 
 * @author gossi
 */
class FunctionphaseUpdateAction extends AbstractSkillAction {

	/**
	 * Automatically generated run method
	 * 
	 * @param Request $request
	 * @return Response
	 */
	public function run(Request $request) {
		$skill = $this->getSkill();
		
		$content = json_decode($request->getContent(), true);
		$nodes = $content['nodes'];
		$deleted = $content['deleted'];
		$idMap = [];
		$root = $skill->getFunctionPhaseId();
		
		// root deleted? delete all
		if ($root !== null && in_array($root, $deleted)) {
			FunctionPhaseQuery::create()->filterBySkill($skill)->delete();
		} else {
			foreach ($nodes as $node) {
				$isNew = false;
				$canSave = true;
				if (isset($node['isNew'])) {
					$isNew = true;
					$FunctionPhase = new FunctionPhase();
					$FunctionPhase->setTitle($node['label']);
					$FunctionPhase->setType($node['group']);
					$FunctionPhase->setSkill($skill);
				} else {
					$changed = false;
					$FunctionPhase = FunctionPhaseQuery::create()->findOneById($node['id']);
					
					if ($FunctionPhase->getTitle() != $node['label']) {
						$FunctionPhase->setTitle($node['label']);
						$changed = true;
					}
					
					if ($FunctionPhase->getType() != $node['group']) {
						$FunctionPhase->setType($node['group']);
						$changed = true;
					}
					
					$canSave = $changed;
				}
				
				if ($canSave) {
					$FunctionPhase->save();
					
					if ($isNew) {
						$idMap[$node['id']] = $FunctionPhase->getId();
					}
					
					$user = $this->getServiceContainer()->getAuthManager()->getUser();
					$user->newActivity([
						'verb' => $isNew ? ActivityObject::VERB_ADD : ActivityObject::VERB_UPDATE,
						'object' => $FunctionPhase,
						'target' => $skill
					]);
				}
			}
			
			// set parents
			foreach ($nodes as $node) {
				$id = $node['id'];
				if (isset($idMap[$id])) {
					$id = $idMap[$id];
				}
				
				StructureNodeParentQuery::create()->filterById($id)->delete();
				foreach ($node['parents'] as $parentId) {
					if (isset($idMap[$parentId])) {
						$parentId = $idMap[$parentId];
					}

					if (!in_array($parentId, $deleted)) {
						$parent = new StructureNodeParent();
						$parent->setId($id);
						$parent->setParentId($parentId);
						$parent->save();
					}
				}
			}
			
			foreach ($deleted as $id) {
				StructureNodeParentQuery::create()->filterbyId($id)->delete();
				StructureNodeParentQuery::create()->filterByParentId($id)->delete();
				StructureNodeQuery::create()->filterById($id)->delete();
				FunctionPhaseQuery::create()->filterById($id)->delete();
			}
		}
		
		$response = new JsonResponse($idMap);
		$response->prepare($request);
		$response->send();
		exit;
	}
	
	protected function setDefaultParams(OptionsResolverInterface $resolver) {
		$resolver->setRequired(['sport', 'skill']);
	}
}
