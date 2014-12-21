<?php
namespace gossi\trixionary\client\action;

use Symfony\Component\HttpFoundation\Request;

/**
 * Displays info
 * 
 * @author gossi
 */
class InfoAction extends AbstractSportAction {

	/**
	 * Automatically generated run method
	 * 
	 * @param Request $request
	 * @return Response
	 */
	public function run(Request $request) {
		return $this->getResponse($request);
	}
}
