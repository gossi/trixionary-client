<?php
namespace gossi\trixionary\client\action;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use keeko\framework\foundation\AbstractAction;
use gossi\trixionary\model\SportQuery;
use keeko\framework\domain\payload\Blank;

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
		$sports = SportQuery::create()->orderByTitle()->find();
		return $this->responder->run($request, new Blank(['sports' => $sports]));
	}
}
