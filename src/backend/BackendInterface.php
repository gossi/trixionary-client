<?php
namespace gossi\trixionary\client\backend;

use gossi\trixionary\model\Sport;

interface BackendInterface {
	
	/**
	 * @return Sport[]
	 */
	public function getSports();
	
	/**
	 * 
	 * @param string $slug
	 * @return Sport
	 */
	public function getSport($slug);
	
	public function getGroup($id = null);
	
	public function getGroups($sportSlug);
	
	public function getSkill($id = null);
	
	public function getSkills($groupId);

}