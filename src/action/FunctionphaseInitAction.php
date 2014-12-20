<?php
namespace gossi\trixionary\client\action;

use keeko\core\action\AbstractAction;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use gossi\trixionary\model\SkillQuery;
use gossi\trixionary\model\FunctionPhase;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Initializes the Function Phases
 * 
 * @author gossi
 */
class FunctionphaseInitAction extends AbstractSportAction {

	/**
	 * Automatically generated run method
	 * 
	 * @param Request $request
	 * @return Response
	 */
	public function run(Request $request) {
		$sport = $this->getSport();
		$slug = $this->params['skill'];
		$skill = SkillQuery::create()->filterBySport($sport)->filterBySlug($slug)->findOne();
		$router = $this->getModule()->getRouter();
		
		if ($skill->getFunctionphases()->count() == 0) {
			$main = new FunctionPhase();
			$main->setSkill($skill);
			$main->setTitle($skill->getName());
			$main->setType(FunctionPhase::MAIN);
			$main->save();
		}
		
		$url = $router->generate('skill', $sport, ['skill' => $slug]) . '#k-struktur';
		return new RedirectResponse($url);
	}
	
	protected function setDefaultParams(OptionsResolverInterface $resolver) {
		$resolver->setRequired(['sport', 'skill']);
	}
}
