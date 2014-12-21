<?php
namespace gossi\trixionary\client\action;

use keeko\core\action\AbstractAction;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use gossi\trixionary\model\SkillQuery;
use gossi\trixionary\model\PictureQuery;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Delets a picture
 * 
 * @author gossi
 */
class PictureDeleteAction extends AbstractSkillAction {

	/**
	 * Automatically generated run method
	 * 
	 * @param Request $request
	 * @return Response
	 */
	public function run(Request $request) {
		$skill = $this->getSkill();
		$picture = PictureQuery::create()->findOneById($this->params['id']);
		
		$fs = new Filesystem();
		$filename = $picture->getFilename();
		$trickFolder = $this->getTrixionary()->getPicturesPath($skill);
		$thumbsFolder = $trickFolder . '/thumbs';
		$trick = $trickFolder . '/' . $filename;
		$thumb = $thumbsFolder . '/' . $filename;
		
		if ($fs->exists($trick)) {
			$fs->remove($trick);
		}
		
		if ($fs->exists($thumb)) {
			$fs->remove($thumb);
		}
		
		if ($skill->getPictureId() == $picture->getId()) {
			SkillQuery::disableVersioning();
			$skill->setFeaturedPicture(null);
			$skill->save();
			SkillQuery::enableVersioning();
		}
		
		$picture->delete();

		$url = $this->generateUrl('pictures', ['skill' => $skill->getSlug()]);
		return new RedirectResponse($url);
	}

	protected function setDefaultParams(OptionsResolverInterface $resolver) {
		$resolver->setRequired(['sport', 'skill', 'id']);
	}
}
