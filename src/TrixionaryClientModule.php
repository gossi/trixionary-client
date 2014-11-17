<?php
namespace gossi\trixionary\client;

use keeko\core\module\AbstractModule;
use gossi\trixionary\client\backend\TrixionaryBackend;
use gossi\trixionary\client\backend\LocalBackendAdapter;

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
	
	/**
	 * @return TrixionaryBackend
	 */
	public function getBackend() {
		if ($this->backend === null) {
			$this->backend = new TrixionaryBackend(new LocalBackendAdapter());
		}
		
		return $this->backend;
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
}
