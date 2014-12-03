<?php
namespace gossi\trixionary\client\action;

use keeko\core\action\AbstractAction;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Cocur\Slugify\Slugify;

/**
 * Edits a group
 * 
 * @author gossi
 */
class GroupEditAction extends GroupFormAction {
	
	protected function setDefaultParams(OptionsResolverInterface $resolver) {
		$resolver->setRequired(['sport', 'group']);
	}
}
