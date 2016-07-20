<?php
namespace gossi\trixionary\client\action;

use keeko\framework\foundation\AbstractAction;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use gossi\trixionary\model\SportQuery;
use gossi\trixionary\domain\SportDomain;
use keeko\framework\domain\payload\Blank;
use gossi\trixionary\model\Sport;
use keeko\framework\domain\payload\NotValid;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Edits a Sport
 *
 * This code is automatically created. Modifications will probably be overwritten.
 *
 * @author Thomas Gossmann
 */
class ManageEditAction extends AbstractAction {

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
		$payload = new Blank($data);
		if ($request->isMethod('POST')) {
			$post = $request->request;

			$domain = new SportDomain($this->getServiceContainer());
			$serializer = Sport::getSerializer();

			$fields = $serializer->getFields();
			$attribs = [];

			foreach ($fields as $field) {
				if ($post->has($field)) {
					$attribs[$field] = $post->get($field);
				}
			}

			$attribs['feature_composition'] = $post->has('feature_composition');
			$attribs['feature_tester'] = $post->has('feature_tester');

			$payload = $domain->update($id, [
				'meta' => $post->get('meta', []),
				'attributes' => $attribs
			]);
			if ($payload instanceof NotValid) {
				$payload = new NotValid(array_merge($data, $payload->get()));
			}
		}

		return $this->responder->run($request, $payload);
	}
}
