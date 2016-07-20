<?php
namespace gossi\trixionary\client\action;

use keeko\framework\foundation\AbstractAction;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use gossi\trixionary\model\SportQuery;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Make a sport the default one
 *
 * This code is automatically created. Modifications will probably be overwritten.
 *
 * @author Thomas Gossmann
 */
class ManageDefaultAction extends AbstractAction {

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

		if ($sport !== null) {
			$default = SportQuery::create()->findOneByIsDefault(true);
			$default->setIsDefault(false);
			$default->save();

			if ($sport->getId() != $default->getId()) {
				$sport->setIsDefault(true);
				$sport->save();
			}
		}

		return $this->responder->run($request);
	}
}
