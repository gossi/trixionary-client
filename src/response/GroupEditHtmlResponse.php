<?php
namespace gossi\trixionary\client\response;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use keeko\core\action\AbstractResponse;

/**
 * HtmlResponse for Edits a group
 * 
 * @author gossi
 */
class GroupEditHtmlResponse extends AbstractResponse {

	/**
	 * Automatically generated method, will be overridden
	 * 
	 * @param Request $request
	 * @return Response
	 */
	public function run(Request $request) {
		return $this->render('group-form.twig', $this->data);
	}
}
