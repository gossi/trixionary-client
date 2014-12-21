<?php
namespace gossi\trixionary\client\action;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use gossi\trixionary\model\SkillQuery;
use gossi\trixionary\model\PictureQuery;

/**
 * Manage Pictures
 * 
 * @author gossi
 */
class PictureManageAction extends AbstractSkillAction {

	/**
	 * Automatically generated run method
	 * 
	 * @param Request $request
	 * @return Response
	 */
	public function run(Request $request) {
		$skill = $this->getSkill();
		$pictures = PictureQuery::create()->filterBySkill($skill)->find();
		
		$this->addData([
			'pictures' => $pictures,
			'edit_url_pattern' => $this->generateUrl('picture-edit', ['skill' => $skill->getSlug(), 'id' => '_id']),
			'delete_url_pattern' => $this->generateUrl('picture-delete', ['skill' => $skill->getSlug(), 'id' => '_id']),
			'feature_url_pattern' => $this->generateUrl('picture-feature', ['skill' => $skill->getSlug(), 'id' => '_id'])
		]);
		return $this->getResponse($request);
	}

	protected function setDefaultParams(OptionsResolverInterface $resolver) {
		$resolver->setRequired(['sport', 'skill']);
	}
}
