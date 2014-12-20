<?php
namespace gossi\trixionary\client\action;

use keeko\core\action\AbstractAction;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Filesystem\Filesystem;
use gossi\trixionary\model\SkillQuery;
use gossi\trixionary\model\VideoQuery;

/**
 * Deletes a video
 * 
 * @author gossi
 */
class VideoDeleteAction extends AbstractSportAction {

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
		$video = VideoQuery::create()->findOneById($this->params['id']);
		
		$fs = new Filesystem();
		$filename = $this->getTrixionary()->getVideosPath($skill) . '/' . $video->getFilename();
		
		if ($fs->exists($filename)) {
			$fs->remove($filename);
		}
		
		$video->delete();

		$url = $router->generate('videos', $sport, ['skill' => $skill->getSlug()]);
		return new RedirectResponse($url);
	}

	protected function setDefaultParams(OptionsResolverInterface $resolver) {
		$resolver->setRequired(['sport', 'skill', 'id']);
	}
}
