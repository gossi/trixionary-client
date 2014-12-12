<?php
namespace gossi\trixionary\client\action;

use Symfony\Component\HttpFoundation\Request;
use gossi\trixionary\model\SkillQuery;
use gossi\trixionary\model\PictureQuery;
use gossi\trixionary\model\Picture;

class PictureFormAction extends AbstractSportAction {
	
	public function run(Request $request) {
		$router = $this->getModule()->getRouter();
		$sport = $this->getSport();
		$slug = $this->params['skill'];
		$skill = SkillQuery::create()->filterBySport($sport)->filterBySlug($slug)->findOne();
		$picture = $this->getPicture();
		
		if ($request->isMethod('POST')) {
			$user = $this->getServiceContainer()->getAuthManager()->getUser();
			$picture->setUploaderId($user->getId());
			$picture->setPhotographer($request->request->get('photographer'));
			$picture->setMovender($request->request->get('movender'));
			$picture->setTitle($request->request->get('title'));
			$picture->setDescription($request->request->get('description'));
// 			$picture->save();
			
			
		}
		
		$this->addData([
			'skill' => $skill,
			'picture' => $picture,
			'edit_url' => $router->generate('skill-edit', $sport, ['skill' => $slug]),
			'api_url' => $this->getServiceContainer()->getPreferenceLoader()->getSystemPreferences()->getApiUrl(),
			'manage_pictures_url' => $router->generate('pictures', $sport, ['skill' => $slug]),
			'manage_videos_url' => $router->generate('videos', $sport, ['skill' => $slug]),
			'manage_references_url' => $router->generate('references', $sport, ['skill' => $slug]),
			'create_picture_url' => $router->generate('picture-create', $sport, ['skill' => $slug]),
			'create_video_url' => $router->generate('video-create', $sport, ['skill' => $slug]),
			'create_reference_url' => $router->generate('reference-create', $sport, ['skill' => $slug]),
		]);
		return $this->getResponse($request);
	}
	
	/**
	 * @return Picture
	 */
	protected function getPicture() {
		if (isset($this->params['id'])) {
			return PictureQuery::create()->findOneById($this->params['id']);
		}
		
		return new Picture();
	}
}