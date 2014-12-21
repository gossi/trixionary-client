<?php
namespace gossi\trixionary\client\action;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use gossi\trixionary\model\SkillQuery;
use gossi\trixionary\model\ReferenceQuery;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use gossi\trixionary\model\Reference;

/**
 * Manage references
 * 
 * @author gossi
 */
class ReferenceManageAction extends AbstractSkillAction {

	/**
	 * Automatically generated run method
	 * 
	 * @param Request $request
	 * @return Response
	 */
	public function run(Request $request) {
		$skill = $this->getSkill();
		$references = ReferenceQuery::create()->filterBySkill($skill)->find();
		
		$this->addData([
			'references' => $references,
			'edit_url_pattern' => $this->generateUrl('reference-edit', ['skill' => $skill->getSlug(), 'id' => '_id']),
			'delete_url_pattern' => $this->generateUrl('reference-delete', ['skill' => $skill->getSlug(), 'id' => '_id'])
		]);
		return $this->getResponse($request);
	}
	
	protected function setDefaultParams(OptionsResolverInterface $resolver) {
		$resolver->setRequired(['sport', 'skill']);
	}
}
