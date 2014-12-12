<?php
namespace gossi\trixionary\client\response;

use keeko\core\action\AbstractResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * HtmlResponse for Deletes a reference
 * 
 * @author gossi
 */
class ReferenceDeleteHtmlResponse extends AbstractResponse {

	/**
	 * Automatically generated method, will be overridden
	 * 
	 * @param Request $request
	 * @return Response
	 */
	public function run(Request $request) {
		return $this->render('reference-delete.twig', $this->data);
	}
}
