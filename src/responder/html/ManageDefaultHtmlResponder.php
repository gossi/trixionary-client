<?php
namespace gossi\trixionary\client\responder\html;

use keeko\framework\domain\payload\PayloadInterface;
use keeko\framework\foundation\AbstractResponder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Automatically generated HtmlResponder for Make a sport the default one
 *
 * @author Thomas Gossmann
 */
class ManageDefaultHtmlResponder extends AbstractResponder {

	/**
	 * Automatically generated run method
	 *
	 * @param Request $request
	 * @param PayloadInterface $payload
	 * @return Response
	 */
	public function run(Request $request, PayloadInterface $payload = null) {
		$baseUrl = $this->getServiceContainer()->getKernel()->getApplication()->getBaseUrl();
		return new RedirectResponse($baseUrl . '/manage');
	}
}
