<?php
namespace gossi\trixionary\client\action;

use keeko\framework\foundation\AbstractAction;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use gossi\trixionary\model\ObjectQuery;
use Symfony\Component\OptionsResolver\OptionsResolver;
use keeko\framework\domain\payload\Blank;
use gossi\trixionary\domain\ObjectDomain;
use gossi\trixionary\model\Object;
use keeko\framework\domain\payload\NotValid;

/**
 * Edit an Object
 *
 * This code is automatically created. Modifications will probably be overwritten.
 *
 * @author Thomas Gossmann
 */
class ObjectsEditAction extends AbstractAction {

	protected function configureParams(OptionsResolver $resolver) {
		$resolver->setRequired(['id', 'objectId']);
	}

	/**
	 * Automatically generated run method
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function run(Request $request) {
		$object = ObjectQuery::create()->findOneById($this->getParam('objectId'));
		$data = ['sport' => $object->getSport(), 'object' => $object];
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

			$payload = $domain->update($object->getId(), ['attributes' => $attribs]);
			if ($payload instanceof NotValid) {
				$payload = new NotValid(array_merge($data, $payload->get()));
			}
		}

		return $this->responder->run($request, $payload);
	}
}
