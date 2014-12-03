<?php
namespace gossi\trixionary\client\action;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Creates a stance
 * 
 * @author gossi
 */
class PositionCreateAction extends PositionFormAction {

	protected function setDefaultParams(OptionsResolverInterface $resolver) {
		$resolver->setRequired(['sport']);
	}
}
