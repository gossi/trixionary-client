<?php
namespace gossi\trixionary\client\response;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use keeko\core\action\AbstractResponse;

/**
 * HtmlResponse for Deletes a group
 * 
 * @author gossi
 */
class GroupDeleteHtmlResponse extends AbstractResponse {

	/**
	 * Automatically generated method, will be overridden
	 * 
	 * @param Request $request
	 * @return Response
	 */
	public function run(Request $request) {
		return new Response();
	}
}
