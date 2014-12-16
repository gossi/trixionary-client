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
	
	public function getPermissions() {
		return [
			'skill_create' => $this->hasPermission('skill-create'),
			'skill_edit' => $this->hasPermission('skill-edit'),
			'skill_delete' => $this->hasPermission('skill-delete'),
			'group_create' => $this->hasPermission('group-create'),
			'group_edit' => $this->hasPermission('group-edit'),
			'group_delete' => $this->hasPermission('group-delete'),
			'position_create' => $this->hasPermission('position-create'),
			'position_edit' => $this->hasPermission('position-edit'),
			'position_delete' => $this->hasPermission('position-delete'),
			'pictures' => $this->hasPermission('pictures'),
			'picture_create' => $this->hasPermission('picture-create'),
			'picture_edit' => $this->hasPermission('picture-edit'),
			'picture_delete' => $this->hasPermission('picture-delete'),
			'videos' => $this->hasPermission('videos'),
			'video_create' => $this->hasPermission('video-create'),
			'video_edit' => $this->hasPermission('video-edit'),
			'video_delete' => $this->hasPermission('video-delete'),
			'references' => $this->hasPermission('references'),
			'reference_create' => $this->hasPermission('reference-create'),
			'reference_edit' => $this->hasPermission('reference-edit'),
			'reference_delete' => $this->hasPermission('reference-delete'),
		];
	}
}
