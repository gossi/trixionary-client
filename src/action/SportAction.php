<?php
namespace gossi\trixionary\client\action;

use keeko\core\action\AbstractAction;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Sports Listing
 * 
 * @author gossi
 */
class SportAction extends AbstractAction {

	/**
	 * Automatically generated run method
	 * 
	 * @param Request $request
	 * @return Response
	 */
	public function run(Request $request) {
		$backend = $this->getModule()->getBackend();
		$sport = $backend->getSport($this->params['sport']);
		$this->response->setData([
			'sport' => $sport
		]);
		return $this->response->run($request);
	}
	
	
	/* (non-PHPdoc)
	 * @see \keeko\core\action\AbstractAction::setDefaultParams()
	 */
	protected function setDefaultParams(OptionsResolverInterface $resolver) {
		$resolver->setRequired(['sport']);
	}

}
