<?php
namespace gossi\trixionary\client\action;

use keeko\core\action\AbstractAction;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Deletes a stance
 * 
 * @author gossi
 */
class PositionDeleteAction extends AbstractAction {

	/**
	 * Automatically generated run method
	 * 
	 * @param Request $request
	 * @return Response
	 */
	public function run(Request $request) {
		$backend = $this->getModule()->getBackend();
		$sport = $backend->getSport($this->params['sport']);
		$position = $backend->getPosition($this->params['position'], $sport);
		$position->delete();
		
		$router = $this->getModule()->getRouter();
		$url = $router->generate('sport', $sport);
		return new RedirectResponse($url);
	}
	
	protected function setDefaultParams(OptionsResolverInterface $resolver) {
		$resolver->setRequired(['sport', 'position']);
	}
}
