<?php
namespace gossi\trixionary\client\action;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Creates a new video
 * 
 * @author gossi
 */
class VideoCreateAction extends VideoFormAction {

	protected function setDefaultParams(OptionsResolverInterface $resolver) {
		$resolver->setRequired(['sport', 'skill']);
	}
}
