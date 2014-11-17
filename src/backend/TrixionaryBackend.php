<?php
namespace gossi\trixionary\client\backend;

class TrixionaryBackend implements BackendInterface {
	
	private $adapter;
	
	public function __construct(BackendInterface $adapter) {
		$this->adapter = $adapter;
	}
	
	public function getSports() {
		return $this->adapter->getSports();
	}
	
	public function getSport($slug) {
		return $this->adapter->getSport($slug);
	}
	
	public function getGroup($id = null) {
		return $this->adapter->getGroup($id);
	}
	
	public function getGroups($sportSlug) {
		return $this->adapter->getGroups($sportSlug);
	}
	
	public function getSkill($id = null) {
		return $this->adapter->getSkill($id);
	}
	
	public function getSkills($groupId) {
		return $this->adapter->getSkills($groupId);
	}
}