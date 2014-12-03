<?php
namespace gossi\trixionary\client\action;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Creates a group
 * 
 * @author gossi
 */
class GroupCreateAction extends GroupFormAction {

	protected function setDefaultParams(OptionsResolverInterface $resolver) {
		$resolver->setRequired(['sport']);
	}
}
