<?php
namespace gossi\trixionary\client;

use keeko\framework\foundation\AbstractModule;

/**
 * Trixionary Client
 *
 * @license MIT
 * @author gossi
 */
class TrixionaryClientModule extends AbstractModule {

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
			'kstruktur_init' => $this->hasPermission('kstruktur-init'),
			'kstruktur_update' => $this->hasPermission('kstruktur-update'),
			'functionphase_init' => $this->hasPermission('functionphase-init'),
			'functionphase_update' => $this->hasPermission('functionphase-update'),
		];
	}
}
