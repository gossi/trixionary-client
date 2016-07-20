<?php
namespace gossi\trixionary\client\action;

use keeko\framework\foundation\AbstractAction;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use gossi\trixionary\model\SportQuery;
use Symfony\Component\OptionsResolver\OptionsResolver;
use keeko\framework\domain\payload\Blank;
use keeko\framework\domain\payload\Success;

/**
 * Deletes a Sport
 *
 * This code is automatically created. Modifications will probably be overwritten.
 *
 * @author Thomas Gossmann
 */
class ManageDeleteAction extends AbstractAction {

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
		$id = $this->getParam('id');
		$sport = SportQuery::create()->findOneById($id);
		$data = ['sport' => $sport];
		$payload = null;

		if ($request->isMethod('POST')) {
			if ($request->request->get('name') == $sport->getTitle()) {
				$sport->delete();
				$payload = new Success();
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
