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
class FunctionphaseInitAction extends AbstractSkillAction {

	/**
	 * Automatically generated run method
	 * 
	 * @param Request $request
	 * @return Response
	 */
	public function run(Request $request) {
		$skill = $this->getSkill();

		if ($skill->getFunctionPhaseRoot() == null) {
			$main = new FunctionPhase();
			$main->setSkill($skill);
			$main->setTitle($skill->getName());
			$main->setType(FunctionPhase::MAIN);
			$main->save();
		
			$skill->setFunctionPhaseRoot($main);
			$skill->save();
		}
		
		$url = $this->generateUrl('skill', ['skill' => $skill->getSlug()]) . '#functionphase';
		return new RedirectResponse($url);
	}
	
	protected function setDefaultParams(OptionsResolverInterface $resolver) {
		$resolver->setRequired(['sport', 'skill']);
	}
}
