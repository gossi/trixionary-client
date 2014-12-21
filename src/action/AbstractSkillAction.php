<?php
namespace gossi\trixionary\client\action;

use gossi\trixionary\model\SkillQuery;
use gossi\trixionary\model\Skill;
use keeko\core\model\Action;
use keeko\core\module\AbstractModule;
use keeko\core\action\AbstractResponse;

abstract class AbstractSkillAction extends AbstractSportAction {

	private $skill;
	
	public function __construct(Action $model, AbstractModule $module, AbstractResponse $response) {
		parent::__construct($model, $module, $response);
	}
	
	public function beforeRun() {
		parent::beforeRun();

		$skill = $this->getSkill();
		if ($skill !== null) {
			$this->addData([
				'skill' => $skill,
			]);
			
			if ($skill->getSlug() != '') {
				$this->addData([
					'skill_url' => $this->generateUrl('skill', ['skill' => $skill->getSlug()]),
					'edit_url' => $this->generateUrl('skill-edit', ['skill' => $skill->getSlug()]),
					'delete_url' => $this->generateUrl('skill-delete', ['skill' => $skill->getSlug()]),
					'manage_pictures_url' => $this->generateUrl('pictures', ['skill' => $skill->getSlug()]),
					'manage_videos_url' => $this->generateUrl('videos', ['skill' => $skill->getSlug()]),
					'manage_references_url' => $this->generateUrl('references', ['skill' => $skill->getSlug()]),
					'init_kstruktur_url' => $this->generateUrl('kstruktur-init', ['skill' => $skill->getSlug()]),
					'init_functionphase_url' => $this->generateUrl('functionphase-init', ['skill' => $skill->getSlug()]),
					'create_picture_url' => $this->generateUrl('picture-create', ['skill' => $skill->getSlug()]),
					'create_video_url' => $this->generateUrl('video-create', ['skill' => $skill->getSlug()]),
					'create_reference_url' => $this->generateUrl('reference-create', ['skill' => $skill->getSlug()]),
				]);
			}
		}
	}

	/**
	 * @return Skill
	 */
	protected function getSkill() {
		if ($this->skill === null && isset($this->params['skill'])) {
			$this->skill = SkillQuery::create()->filterBySport($this->getSport())->findOneBySlug($this->params['skill']);
		}
		
		return $this->skill;
	}
}