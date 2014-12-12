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

abstract class AbstractSportAction extends AbstractAction {
	
	protected $data = [];
	private $sport;
	
	/* (non-PHPdoc)
	 * @see \keeko\core\action\AbstractAction::__construct()
	 */
	public function __construct(Action $model, AbstractModule $module, AbstractResponse $response) {
		parent::__construct($model, $module, $response);
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

	private function getRootPath($sport) {
		$module = $this->getServiceContainer()->getModuleManager()->load('gossi/trixionary');
		return $module->getManagedFilesPath();
	}

	protected function getSkillFolderPath(Sport $sport) {
		$slugifier = new Slugify();
		$path = $this->getRootPath();
		$path .= '/' . $sport->getSlug();
		$path .= '/' . $slugifier->slugify($sport->getSkillPluralLabel());

		return str_replace('//', '/', $path);
	}

	protected function getUploadPath() {
		$path = $this->getRootPath();
		$path .= '/_uploads';

		return str_replace('//', '/', $path);
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
			'locations' => $this->getModule()->getLocations($this->getSport())
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