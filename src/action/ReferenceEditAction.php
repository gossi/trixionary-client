<?php
namespace gossi\trixionary\client\action;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Edits a reference
 * 
 * @author gossi
 */
class ReferenceEditAction extends ReferenceFormAction {

	protected function setDefaultParams(OptionsResolverInterface $resolver) {
		$resolver->setRequired(['sport', 'skill', 'id']);
	}
}
