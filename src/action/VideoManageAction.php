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
class VideoManageAction extends AbstractSportAction {

	/**
	 * Automatically generated run method
	 * 
	 * @param Request $request
	 * @return Response
	 */
	public function run(Request $request) {
		$router = $this->getModule()->getRouter();
		$sport = $this->getSport();
		$slug = $this->params['skill'];
		$skill = SkillQuery::create()->filterBySport($sport)->filterBySlug($slug)->findOne();
		$videos = VideoQuery::create()->filterBySkill($skill)->find();
		$this->addData([
			'skill' => $skill,
			'skill_url' => $router->generate('skill', $sport, ['skill' => $slug]),
			'videos' => $videos,
			'edit_url_pattern' => $router->generate('video-edit', $sport, ['skill' => $slug, 'id' => '_id']),
			'delete_url_pattern' => $router->generate('video-delete', $sport, ['skill' => $slug, 'id' => '_id']),
			'edit_url' => $router->generate('skill-edit', $sport, ['skill' => $slug]),
			'manage_pictures_url' => $router->generate('pictures', $sport, ['skill' => $slug]),
			'manage_videos_url' => $router->generate('videos', $sport, ['skill' => $slug]),
			'manage_references_url' => $router->generate('references', $sport, ['skill' => $slug]),
			'create_picture_url' => $router->generate('picture-create', $sport, ['skill' => $slug]),
			'create_video_url' => $router->generate('video-create', $sport, ['skill' => $slug]),
			'create_reference_url' => $router->generate('reference-create', $sport, ['skill' => $slug]),
		]);
		return $this->getResponse($request);
	}

	protected function setDefaultParams(OptionsResolverInterface $resolver) {
		$resolver->setRequired(['sport', 'skill']);
	}
}
