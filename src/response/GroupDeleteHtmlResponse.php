<?php
namespace gossi\trixionary\client\response;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use keeko\core\model\Group;

/**
 * HtmlResponse for Deletes a group
 * 
 * @author gossi
 */
class GroupDeleteHtmlResponse extends AbstractGroupResponse {

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
