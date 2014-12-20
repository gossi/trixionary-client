<?php
namespace gossi\trixionary\client\action;

use keeko\core\action\AbstractAction;
use keeko\core\model\Action;
use keeko\core\module\AbstractModule;
use keeko\core\action\AbstractResponse;
use Symfony\Component\HttpFoundation\Request;
use gossi\trixionary\model\Sport;
use gossi\trixionary\model\SportQuery;
use gossi\trixionary\model\PositionQuery;
use gossi\trixionary\model\GroupQuery;
use Propel\Runtime\ActiveQuery\Criteria;
use Cocur\Slugify\Slugify;
use Symfony\Component\Filesystem\Filesystem;
use gossi\trixionary\model\Skill;
use gossi\trixionary\TrixionaryModule;
use gossi\trixionary\model\Picture;
use gossi\trixionary\model\Video;

abstract class AbstractSportAction extends AbstractAction {
	
	protected $data = [];
	private $sport;
	
	/* (non-PHPdoc)
	 * @see \keeko\core\action\AbstractAction::__construct()
	 */
	public function __construct(Action $model, AbstractModule $module, AbstractResponse $response) {
		parent::__construct($model, $module, $response);

		$twig = $this->getTwig();
		$twig->addFunction(new \Twig_SimpleFunction('getSkillThumbUrl', function (Skill $skill) {
			if ($skill->getFeaturedPicture() !== null) {
				return $this->getPictureThumbUrl($skill->getFeaturedPicture());
			}
			
			$fs = new Filesystem();
			if ($fs->exists($this->getTrixionary()->getSkillPreviewPath($this->getSport()))) {
				return $this->getTrixionary()->getSkillPreviewUrl($this->getSport());
			}
			return null;
		}));

		$twig->addFunction(new \Twig_SimpleFunction('getPictureUrl', function (Picture $picture) {
			return $this->getPictureUrl($picture);
		}));
		$twig->addFunction(new \Twig_SimpleFunction('getPictureThumbUrl', function (Picture $picture) {
			return $this->getPictureThumbUrl($picture);
		}));
		
		$twig->addFunction(new \Twig_SimpleFunction('getVideoUrl', function (Video $video) {
			return $this->getVideoUrl($video);
		}));
	}
	
	protected function getPictureUrl(Picture $picture) {
		$slugifier = new Slugify();
		$url = $this->getTrixionary()->getPicturesUrl($picture->getSkill()) . '/';
		$url .= $slugifier->slugify($picture->getMovender()) . '-' . $picture->getId() . '.jpg';
		
		return $url;
	}
	
	protected function getPictureThumbUrl(Picture $picture) {
		$slugifier = new Slugify();
		$url = $this->getTrixionary()->getPicturesUrl($picture->getSkill()) . '/thumbs/';
		$url .= $slugifier->slugify($picture->getMovender()) . '-' . $picture->getId() . '.jpg';
			
		return $url;
	}
	
	protected function getVideoUrl(Video $video) {
		$url = $this->getTrixionary()->getVideosUrl($video->getSkill()) . '/';
		$url .= $video->getFilename();
	
		return $url;
	}
	
	/**
	 * Returns the trixionary module
	 * 
	 * @return TrixionaryModule
	 */
	protected function getTrixionary() {
		return $this->getServiceContainer()->getModuleManager()->load('gossi/trixionary');
	}

	/**
	 * @return Sport
	 */
	protected function getSport() {
		if ($this->sport === null && isset($this->params['sport'])) {
			$this->sport = SportQuery::create()->findOneBySlug($this->params['sport']);
		}

		return $this->sport;
	}

	protected function addData($data) {
		if (is_array($data)) {
			foreach ($data as $k => $v) {
				$this->data[$k] = $v;
			}
		}

		if (func_num_args() == 2) {
			$this->data[func_get_arg(0)] = func_get_arg(1);
		}
	}
	
	protected function getResponse(Request $request) {
		$this->addData([
			'sport' => $this->getSport(),
			'locations' => $this->getModule()->getLocations($this->getSport()),
			'permissions' => $this->getModule()->getPermissions()
		]);
		$this->response->setData($this->data);
		return $this->response->run($request);
	}
	
	protected function getPositions() {
		return PositionQuery::create()->filterBySport($this->getSport())->orderByTitle(Criteria::ASC)->find();
	}
	
	protected function getGroups() {
		return GroupQuery::create()->filterBySport($this->getSport())->orderByTitle(Criteria::ASC)->find();
	}
}