<?php
namespace gossi\trixionary\client\responder\html;

use keeko\framework\domain\payload\PayloadInterface;
use keeko\framework\domain\payload\Success;
use keeko\framework\foundation\AbstractPayloadResponder;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Automatically generated HtmlResponder for Delete an Object
 *
 * @author Thomas Gossmann
 */
class ObjectsDeleteHtmlResponder extends AbstractPayloadResponder {

	protected function getPayloadMethods() {
		return [
			'keeko\framework\domain\payload\Blank' => 'question',
			'keeko\framework\domain\payload\Success' => 'success'
		];
	}

	/**
	 * Automatically generated run method
	 *
	 * @param Request $request
	 * @param PayloadInterface $payload
	 * @return Response
	 */
	protected function question(Request $request, PayloadInterface $payload = null) {
		return new Response($this->render('/gossi/trixionary-client/templates/objects-delete.twig', $payload->get()));
	}

	protected function success(Request $request, Success $payload = null) {
		$sport = $payload->get('sport');
		$baseUrl = $this->getServiceContainer()->getKernel()->getApplication()->getBaseUrl();
		return new RedirectResponse($baseUrl . '/manage/' . $sport->getId() . '/objects');
	}
}
