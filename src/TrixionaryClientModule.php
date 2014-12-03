<?php
namespace gossi\trixionary\client;

use keeko\core\module\AbstractModule;
use Symfony\Component\HttpFoundation\Request;

/**
 * Trixionary Client
 * 
 * @license MIT
 * @author gossi
 */
class TrixionaryClientModule extends AbstractModule {

	private $backend;
	private $router;
	
	/**
	 */
	public function install() {
	}

	/**
	 */
	public function uninstall() {
	}

	/**
	 * @param mixed $from
	 * @param mixed $to
	 */
	public function update($from, $to) {
	}
	
	public function getRouter($basepath = null) {
		if ($this->router === null) {
			if ($basepath === null) {
				$app = $this->getServiceContainer()->getApplication();
				$basepath = $app->getAppPath() . $app->getTargetPath();
			}
			$this->router = new TrixionaryRouter($this, $basepath);
		}
		
		return $this->router;
	}
	
	public function getLocations($sport = null) {
		$locations = [];
		
		if ($sport !== null) {
			$router = $this->getRouter();
			$locations['sport_url'] = $router->generate('sport', $sport);
			$locations['create_skill'] = $router->generate('skill-create', $sport);
			$locations['create_group'] = $router->generate('group-create', $sport);
			$locations['create_position'] = $router->generate('position-create', $sport);
			$locations['transitions'] = $router->generate('transitions', $sport);
			$locations['graph'] = $router->generate('graph', $sport);
		}
		
		return $locations;
	}
}
