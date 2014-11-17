<?php
namespace gossi\trixionary\client\action;

use keeko\core\action\AbstractAction;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Creates a group
 * 
 * @author gossi
 */
class GroupCreateAction extends AbstractAction {

	/**
	 * Automatically generated run method
	 * 
	 * @param Request $request
	 * @return Response
	 */
	public function run(Request $request) {
		$backend = $this->getModule()->getBackend();
		$sport = $backend->getSport($this->params['sport']);
		$group = $backend->getGroup();
		
		if ($request->isMethod('POST')) {
			$group->setSlug($request->request->get('slug'));
			$group->setTitle($request->request->get('title'));
			$group->setDescription($request->request->get('description'));
			
			$router = $this->getModule()->getRouter();
			$url = $router->generate('group', ['group' => $group->getSlug(), 'sport' => $this->params['sport']]);
			echo $url;
		}
		
		$this->response->setData([
			'sport' => $sport, 
			'group' => $group, 
			'action' => $request->getUri()
		]);
		return $this->response->run($request);
	}

	/* (non-PHPdoc)
	 * @see \keeko\core\action\AbstractAction::setDefaultParams()
	 */
	protected function setDefaultParams(OptionsResolverInterface $resolver) {
		$resolver->setRequired(['sport']);
	}
}
