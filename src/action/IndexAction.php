<?php
namespace gossi\trixionary\client\action;

use keeko\core\action\AbstractAction;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Trixionary Index
 * 
 * @author gossi
 */
class IndexAction extends AbstractAction {

	/**
	 * Automatically generated run method
	 * 
	 * @param Request $request
	 * @return Response
	 */
	public function run(Request $request) {
		// uncomment the following to pass data to your response
		// $this->response->setData($data);
		return $this->response->run($request);
	}
}