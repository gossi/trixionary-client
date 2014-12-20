<?php
namespace gossi\trixionary\client\action;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Creates a new video
 * 
 * @author gossi
 */
class VideoEditAction extends VideoFormAction {

	protected function setDefaultParams(OptionsResolverInterface $resolver) {
		$resolver->setRequired(['sport', 'skill', 'id']);
	}
}