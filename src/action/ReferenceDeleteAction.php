<?php
namespace gossi\trixionary\client\action;

use keeko\core\action\AbstractAction;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use gossi\trixionary\model\SkillQuery;
use gossi\trixionary\model\ReferenceQuery;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Deletes a reference
 * 
 * @author gossi
 */
class ReferenceDeleteAction extends AbstractSportAction {

	/**
	 * Automatically generated run method
	 * 
	 * @param Request $request
	 * @return Response
	 */
	public function run(Request $request) {
		$router = $this->getModule()->getRouter();
		$sport = $this->getSport();
		$slug = $this->params['skill'];
		$skill = SkillQuery::create()->filterBySport($sport)->filterBySlug($slug)->findOne();
		$reference = ReferenceQuery::create()->findOneById($this->params['id']);
		$reference->delete();

		$url = $router->generate('references', $sport, ['skill' => $skill->getSlug()]);
		return new RedirectResponse($url);
	}

	protected function setDefaultParams(OptionsResolverInterface $resolver) {
		$resolver->setRequired(['sport', 'skill', 'id']);
	}
}
