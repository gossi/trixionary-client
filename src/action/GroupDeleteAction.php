<?php
namespace gossi\trixionary\client\action;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use gossi\trixionary\model\GroupQuery;

/**
 * Deletes a group
 * 
 * @author gossi
 */
class GroupDeleteAction extends AbstractSportAction {

	/**
	 * Automatically generated run method
	 * 
	 * @param Request $request
	 * @return Response
	 */
	public function run(Request $request) {
		$group = GroupQuery::create()->filterBySport($this->getSport())->filterBySlug($this->params['group'])->findOne();
		$group->delete();
		
		$router = $this->getModule()->getRouter();
		$url = $router->generate('sport', $this->getSport());
		return new RedirectResponse($url);
	}
	
	protected function setDefaultParams(OptionsResolverInterface $resolver) {
		$resolver->setRequired(['sport', 'group']);
	}
}
