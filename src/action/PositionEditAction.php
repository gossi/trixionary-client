<?php
namespace gossi\trixionary\client\action;

use keeko\core\action\AbstractAction;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Edits a stance
 * 
 * @author gossi
 */
class PositionEditAction extends PositionFormAction {

	protected function setDefaultParams(OptionsResolverInterface $resolver) {
		$resolver->setRequired(['sport', 'position']);
	}
}
