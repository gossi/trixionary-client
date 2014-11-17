<?php
namespace gossi\trixionary\client\response;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use keeko\core\model\Group;

/**
 * HtmlResponse for Creates a group
 * 
 * @author gossi
 */
class GroupCreateHtmlResponse extends AbstractGroupResponse {

	/**
	 * Automatically generated method, will be overridden
	 * 
	 * @param Request $request
	 * @return Response
	 */
	public function run(Request $request) {
		$twig = $this->getTwig();
		return new Response($twig->render('group-form.twig', $this->data));
	}
}
