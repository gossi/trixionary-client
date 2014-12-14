<?php
namespace gossi\trixionary\client\action;

use keeko\core\action\AbstractAction;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use gossi\trixionary\model\SkillQuery;
use gossi\trixionary\model\Map\SkillTableMap;
use gossi\trixionary\model\PositionQuery;
use gossi\trixionary\model\Skill;

/**
 * Transitions
 * 
 * @author gossi
 */
class TransitionsAction extends AbstractSportAction {

	/**
	 * Automatically generated run method
	 * 
	 * @param Request $request
	 * @return Response
	 */
	public function run(Request $request) {
		$sport = $this->getSport();
		$router = $this->getModule()->getRouter();
		$query = SkillQuery::create();
		
		if (!empty($this->params['from'])) {
			$start = PositionQuery::create()->filterBySport($sport)->filterBySlug($this->params['from'])->findOne();
			$query = $query->filterByStartPosition($start);
		}
		
		if (!empty($this->params['to'])) {
			$end = PositionQuery::create()->filterBySport($sport)->filterBySlug($this->params['to'])->findOne();
			$query = $query->filterByEndPosition($end);
		}
		
		$skills = $query
			->where(SkillTableMap::COL_START_POSITION_ID . ' != ' . SkillTableMap::COL_END_POSITION_ID)
			->find();

		$this->addData([
			'groups' => $this->getGroups(),
			'positions' => $this->getPositions(),
			'skills' => $skills,
			'from' => $this->params['from'],
			'to' => $this->params['to'],
			'url_pattern' => $router->generate('skill', $sport, ['skill' => '_skill_']),
			'from_edit_url' => !empty($this->params['from'])
				? $router->generate('position-edit', $sport, ['position' => $this->params['from']])
				: '',
			'to_edit_url' => !empty($this->params['to'])
				? $router->generate('position-edit', $sport, ['position' => $this->params['to']])
				: '',
		]);
		return $this->getResponse($request);
	}
	
	protected function setDefaultParams(OptionsResolverInterface $resolver) {
		$resolver->setRequired(['sport']);
		$resolver->setOptional(['from', 'to']);
		$resolver->setDefaults(['from' => '', 'to' => '']);
	}
}
