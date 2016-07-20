<?php
namespace gossi\trixionary\client\responder\html;

use keeko\framework\domain\payload\PayloadInterface;
use keeko\framework\foundation\AbstractPayloadResponder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use keeko\framework\domain\payload\Created;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Automatically generated HtmlResponder for Adds a Sport
 *
 * @author Thomas Gossmann
 */
class ManageAddHtmlResponder extends AbstractPayloadResponder {

	/**
	 */
	protected function getPayloadMethods() {
		return [
			'keeko\framework\domain\payload\Blank' => 'form',
			'keeko\framework\domain\payload\NotValid' => 'form',
			'keeko\framework\domain\payload\Created' => 'created'
		];
	}

	/**
	 * Automatically generated run method
	 *
	 * @param Request $request
	 * @param PayloadInterface $payload
	 * @return Response
	 */
	protected function form(Request $request, PayloadInterface $payload = null) {
		return new Response($this->render('/gossi/trixionary-client/templates/manage-add.twig', $payload->get()));
	}

	protected function created(Request $request, Created $payload = null) {
		$baseUrl = $this->getServiceContainer()->getKernel()->getApplication()->getBaseUrl();
		return new RedirectResponse($baseUrl . '/manage');
	}
}
