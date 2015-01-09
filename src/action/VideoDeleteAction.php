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
class VideoDeleteAction extends AbstractSkillAction {

	/**
	 * Automatically generated run method
	 * 
	 * @param Request $request
	 * @return Response
	 */
	public function run(Request $request) {
		$skill = $this->getSkill();
		$video = VideoQuery::create()->findOneById($this->params['id']);
		
		$fs = new Filesystem();
		$filename = $this->getTrixionary()->getVideosPath($skill) . '/' . $video->getFilename();
		
		if ($fs->exists($filename)) {
			$fs->remove($filename);
		}
		
		$video->delete();
		
		if ($video->getReference()) {
			$video->getReference()->delete();
		}		

		$url = $this->generateUrl('videos', ['skill' => $skill->getSlug()]);
		return new RedirectResponse($url);
	}

	protected function setDefaultParams(OptionsResolverInterface $resolver) {
		$resolver->setRequired(['sport', 'skill', 'id']);
	}
}
