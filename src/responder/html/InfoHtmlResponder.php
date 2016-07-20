<?php
namespace gossi\trixionary\client\responder\html;

use keeko\framework\domain\payload\PayloadInterface;
use keeko\framework\foundation\AbstractResponder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Automatically generated HtmlResponder for Displays info
 *
 * @author Thomas Gossmann
 */
class InfoHtmlResponder extends AbstractResponder {

	/**
	 * Automatically generated run method
	 *
	 * @param Request $request
	 * @param PayloadInterface $payload
	 * @return Response
	 */
	public function run(Request $request, PayloadInterface $payload = null) {
		return new Response($this->render('/gossi/trixionary-client/templates/info.twig'));
	}
}
