<?php
namespace gossi\trixionary\client\action;

use keeko\framework\foundation\AbstractAction;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use gossi\trixionary\model\ObjectQuery;
use keeko\framework\domain\payload\Success;
use keeko\framework\domain\payload\Blank;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Delete an Object
 *
 * This code is automatically created. Modifications will probably be overwritten.
 *
 * @author Thomas Gossmann
 */
class ObjectsDeleteAction extends AbstractAction {

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
		$payload = null;

		if ($request->isMethod('POST')) {
			if ($request->request->get('name') == $object->getTitle()) {
				$object->delete();
				$payload = new Success(['sport' => $object->getSport()]);
			} else {
				$data['error'] = 'Name is wrong';
			}
		}

		if ($payload === null) {
			$payload = new Blank($data);
		}

		return $this->responder->run($request, $payload);
	}
}
