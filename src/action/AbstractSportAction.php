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
use gossi\trixionary\model\SkillQuery;

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
	
	protected function generateUrl($name, array $params = []) {
		return $this->getModule()->getRouter()->generate($name, $this->getSport(), $params);
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
	
	protected function getGraphData() {
		$sport = $this->getSport();
		$skills = SkillQuery::create()->filterBySport($sport)->filterByIsMultiple(null)->find();
		
		$transitions = [];
		$nodes = [];
		$edges = [];
		foreach ($skills as $skill) {
			$generationIds = $skill->getGenerationIds();
			if ($generationIds !== null) {
				$generationIds = json_decode($generationIds);
			} else{
				$generationIds = [];
			}
			$node = [
				'label' => $skill->getName(),
				'id' => $skill->getId(),
				'slug' => $skill->getSlug(),
				'importance' => $skill->getImportance(),
				'generation' => $skill->getGeneration(),
				'generationIds' => $generationIds,
				'level' => $skill->getGeneration(),
				'description' => $skill->getDescription(),
				'group' => 'unselected'
			];
				
			if ($skill->getFeaturedPicture()) {
				$node['picture'] = $this->getPictureThumbUrl($skill->getFeaturedPicture());
			}
				
			if ($skill->isTransition()) {
				$transitions[] = $node;
			} else {
				$nodes[] = $node;
			}
				
			foreach ($skill->getParents() as $parent) {
				$id = $parent->getId() . '-' . $skill->getId();
				$edges[$id] = [
					'id' => $id,
					'from' => $parent->getId(),
					'to' => $skill->getId()
				];
			}
				
			if ($skill->getVariationOf() !== null) {
				$id = $skill->getVariationOfId() . '-' . $skill->getId();
				$edges[$id] = [
					'id' => $id,
					'from' => $skill->getVariationOfId(),
					'to' => $skill->getId()
				];
			}
		}
		
		return [
			'nodes' => json_encode($nodes),
			'edges' => json_encode(array_values($edges)),
			'transitions' => $transitions,
			'url_pattern' => $this->generateUrl('skill', ['skill' => '_skill_'])
		];
	}
}