<?php
namespace gossi\trixionary\client\action;

use keeko\core\action\AbstractAction;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use gossi\trixionary\model\SkillQuery;
use gossi\trixionary\model\VideoQuery;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Manage Videos
 * 
 * @author gossi
 */
class VideoManageAction extends AbstractSkillAction {

	/**
	 * Automatically generated run method
	 * 
	 * @param Request $request
	 * @return Response
	 */
	public function run(Request $request) {
		$skill = $this->getSkill();
		$videos = VideoQuery::create()->filterBySkill($skill)->find();
		
		$this->addData([
			'videos' => $videos,
			'edit_url_pattern' => $this->generateUrl('video-edit', ['skill' => $skill->getSlug(), 'id' => '_id']),
			'delete_url_pattern' => $this->generateUrl('video-delete', ['skill' => $skill->getSlug(), 'id' => '_id'])
		]);
		return $this->getResponse($request);
	}

	protected function setDefaultParams(OptionsResolverInterface $resolver) {
		$resolver->setRequired(['sport', 'skill']);
	}
}
