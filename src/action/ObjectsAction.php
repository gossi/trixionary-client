<?php
namespace gossi\trixionary\client\action;

use keeko\framework\foundation\AbstractAction;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use gossi\trixionary\model\SportQuery;
use Symfony\Component\OptionsResolver\OptionsResolver;
use keeko\framework\domain\payload\Blank;

/**
 * Manage Objects
 *
 * This code is automatically created. Modifications will probably be overwritten.
 *
 * @author Thomas Gossmann
 */
class ObjectsAction extends AbstractAction {

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
		$sport = SportQuery::create()
			->leftJoinObject()
			->findOneById($this->getParam('id'));

		return $this->responder->run($request, new Blank(['sport' => $sport]));
	}
}
