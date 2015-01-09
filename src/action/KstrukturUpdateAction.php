<?php
namespace gossi\trixionary\client\action;

use keeko\core\action\AbstractAction;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use gossi\trixionary\model\Kstruktur;
use gossi\trixionary\model\KstrukturQuery;
use keeko\core\model\Activity;
use keeko\core\model\ActivityObject;
use gossi\trixionary\model\SkillQuery;
use gossi\trixionary\model\StructureNodeParentQuery;
use gossi\trixionary\model\StructureNodeParent;
use gossi\trixionary\model\StructureNodeQuery;

/**
 * Batch update of k-Struktur
 * 
 * @author gossi
 */
class KstrukturUpdateAction extends AbstractSkillAction {

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
		$root = $skill->getKstrukturId();
		
		// root deleted? delete all
		if ($root !== null && in_array($root, $deleted)) {
			KstrukturQuery::create()->filterBySkill($skill)->delete();
		} else {
			foreach ($nodes as $node) {
				$isNew = false;
				$canSave = true;
				if (isset($node['isNew'])) {
					$isNew = true;
					$kstruktur = new Kstruktur();
					$kstruktur->setTitle($node['label']);
					$kstruktur->setType($node['group']);
					$kstruktur->setSkill($skill);
				} else {
					$changed = false;
					$kstruktur = KstrukturQuery::create()->findOneById($node['id']);
					
					if ($kstruktur->getTitle() != $node['label']) {
						$kstruktur->setTitle($node['label']);
						$changed = true;
					}
					
					if ($kstruktur->getType() != $node['group']) {
						$kstruktur->setType($node['group']);
						$changed = true;
					}
					
					$canSave = $changed;
				}
				
				if ($canSave) {
					$kstruktur->save();
					
					if ($isNew) {
						$idMap[$node['id']] = $kstruktur->getId();
					}
					
					$user = $this->getServiceContainer()->getAuthManager()->getUser();
					$user->newActivity([
						'verb' => $isNew ? ActivityObject::VERB_ADD : ActivityObject::VERB_UPDATE,
						'object' => $kstruktur,
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
				KstrukturQuery::create()->filterById($id)->delete();
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
