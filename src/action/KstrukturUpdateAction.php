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
					$kstruktur->setParentId($node['parent']);
					$kstruktur->setSkill($skill);
					
					$parentId = $node['parent'];
					if (isset($report[$parentId])) {
						$parentId = $report[$parentId];
					}
					$kstruktur->setParentId($parentId);
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
					
					if ($kstruktur->getParentId() != $node['parent']) {
						$parentId = $node['parent'];
						if (isset($report[$parentId])) {
							$parentId = $report[$parentId];
						}
						$kstruktur->setParentId($parentId);
						$changed = true;
					}
					
					$canSave = $changed;
				}
				
				if ($canSave) {
					$kstruktur->save();
					
					if ($isNew) {
						$report[$node['id']] = $kstruktur->getId();
					}
					
					$user = $this->getServiceContainer()->getAuthManager()->getUser();
					$user->newActivity([
						'verb' => $isNew ? ActivityObject::VERB_ADD : ActivityObject::VERB_UPDATE,
						'object' => $kstruktur,
						'target' => $skill
					]);
				}
			}
			
			foreach ($deleted as $id) {
				KstrukturQuery::create()->filterById($id)->delete();
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
