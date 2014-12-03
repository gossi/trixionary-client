<?php
namespace gossi\trixionary\client\action;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Edits a skill
 * 
 * @author gossi
 */
class SkillEditAction extends SkillFormAction {

	protected function setDefaultParams(OptionsResolverInterface $resolver) {
		$resolver->setRequired(['sport', 'skill']);
	}
}
