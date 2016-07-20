<?php
namespace gossi\trixionary\client\action;

use keeko\framework\foundation\AbstractAction;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolver;
use gossi\trixionary\model\SportQuery;
use gossi\trixionary\model\Object;
use gossi\trixionary\domain\ObjectDomain;
use keeko\framework\domain\payload\Blank;
use keeko\framework\domain\payload\NotValid;

/**
 * Add an Object
 *
 * This code is automatically created. Modifications will probably be overwritten.
 *
 * @author Thomas Gossmann
 */
class ObjectsAddAction extends AbstractAction {

	protected function configureParams(OptionsResolver $resolver) {
		$resolver->setRequired(['id']);
	}

	/**
	 * Automatically generated run method
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function run(Request $request) {
		$sport = SportQuery::create()->findOneById($this->getParam('id'));
		$object = new Object();
		$object->setSport($sport);
		$data = ['sport' => $sport, 'object' => $object];
		$payload = new Blank($data);
		if ($request->isMethod('POST')) {
			$post = $request->request;

			$domain = new ObjectDomain($this->getServiceContainer());
			$serializer = Object::getSerializer();

			$fields = $serializer->getFields();
			$attribs = [];

			foreach ($fields as $field) {
				if ($post->has($field)) {
					$attribs[$field] = $post->get($field);
				}
			}

			$attribs['fixed'] = $post->has('fixed');

			$payload = $domain->create([
				'attributes' => $attribs,
				'relationships' => [
					'sport' => [
						'data' => [
							'id' => $sport->getId()
						]
					]
				]
			]);
			if ($payload instanceof NotValid) {
				$payload = new NotValid(array_merge($data, $payload->get()));
			}
		}

		return $this->responder->run($request, $payload);
	}
}
