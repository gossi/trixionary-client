<?php
namespace gossi\trixionary\client\action;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Edits a picture
 * 
 * @author gossi
 */
class PictureEditAction extends PictureFormAction {

	protected function setDefaultParams(OptionsResolverInterface $resolver) {
		$resolver->setRequired(['sport', 'skill', 'id']);
	}
}
