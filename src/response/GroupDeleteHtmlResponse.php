<?php
namespace gossi\trixionary\client\response;

use keeko\core\action\AbstractResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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
		return $this->render('group-delete.twig', $this->data);
	}
}
