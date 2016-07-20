<?php
namespace gossi\trixionary\client\responder\html;

use keeko\framework\domain\payload\Created;
use keeko\framework\domain\payload\PayloadInterface;
use keeko\framework\foundation\AbstractPayloadResponder;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Automatically generated HtmlResponder for Add an Object
 *
 * @author Thomas Gossmann
 */
class ObjectsAddHtmlResponder extends AbstractPayloadResponder {

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
		return new Response($this->render('/gossi/trixionary-client/templates/objects-add.twig', $payload->get()));
	}

	protected function created(Request $request, Created $payload = null) {
		$sport = $payload->getModel()->getSport();
		$baseUrl = $this->getServiceContainer()->getKernel()->getApplication()->getBaseUrl();
		return new RedirectResponse($baseUrl . '/manage/' . $sport->getId() . '/objects');
	}
}
