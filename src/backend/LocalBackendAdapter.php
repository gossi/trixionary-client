<?php
namespace gossi\trixionary\client\backend;

use gossi\trixionary\client\backend\BackendInterface;
use gossi\trixionary\model\SportQuery;
use gossi\trixionary\model\Group;
use gossi\trixionary\model\GroupQuery;
use gossi\trixionary\model\Skill;
use gossi\trixionary\model\SkillQuery;

class LocalBackendAdapter implements BackendInterface {
	
	public function getSports() {
		return SportQuery::create()->find();
	}
	
	public function getSport($slug) {
		return SportQuery::create()->findOneBySlug($slug);
	}
	
	public function getGroup($id = null) {
		if ($id === null) {
			return new Group();
		}
		
		return GroupQuery::create()->findOneById($id);
	}
	
	public function getGroups($sportSlug) {
		$sport = $this->getSport($sportSlug);
		return GroupQuery::create()->filterBySport($sport)->find();
	}
	
	public function getSkill($id = null) {
		if ($id === null) {
			return new Skill();
		}
		
		return SkillQuery::create()->findOneById($id);
	}
	
	public function getSkills($groupId) {
		$group = $this->getGroup($groupId);
		return SkillQuery::create()->filterByGroup($group)->find();
	}
}