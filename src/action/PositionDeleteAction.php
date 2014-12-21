<?php
namespace gossi\trixionary\client\action;

use keeko\core\action\AbstractAction;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use gossi\trixionary\model\PositionQuery;
use gossi\trixionary\model\SkillQuery;

/**
 * Deletes a stance
 * 
 * @author gossi
 */
class PositionDeleteAction extends AbstractSportAction {

	/**
	 * Automatically generated run method
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function run(Request $request) {
		$sport = $this->getSport();
		$position = PositionQuery::create()->filterBySport($sport)->filterBySlug($this->params['position'])->findOne();
	
		// check for dependencies
		$skills = SkillQuery::create()->filterByStartPosition($position)->_or()->filterByEndPosition($position);
		if ($skills->count()) {
			$this->addData([
					'position' => $position,
					'skills' => $skills->find(),
					'url_pattern' => $this->generateUrl('skill', ['skill' => '_skill_'])
			]);
				
			return $this->getResponse($request);
		} else {
			$position->delete();
				
			$url = $this->generateUrl('sport');
			return new RedirectResponse($url);
		}
	}
	
	protected function setDefaultParams(OptionsResolverInterface $resolver) {
		$resolver->setRequired(['sport', 'position']);
	}
}
