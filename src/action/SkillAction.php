<?php
namespace gossi\trixionary\client\action;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use gossi\trixionary\model\SkillQuery;
use gossi\trixionary\model\Skill;
use gossi\trixionary\model\Map\SkillTableMap;

/**
 * Displays a skill
 * 
 * @author gossi
 */
class SkillAction extends AbstractSportAction {

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
		$this->addData([
			'skill' => $skill,
			'url_pattern' => $router->generate('skill', $sport, ['skill' => '_skill_']),
			'group_url_pattern' => $router->generate('group', $sport, ['group' => '_group_']),
			'transitions_in_url' => $router->generate('transitions', $sport, ['qs' => ['from' => $skill->getStartPosition()->getSlug()]]),
			'transitions_in_count' => SkillQuery::create()->filterByEndPosition($skill->getStartPosition())->where(SkillTableMap::COL_START_POSITION_ID . ' != ' . SkillTableMap::COL_END_POSITION_ID)->count(),
			'transitions_out_url' => $router->generate('transitions', $sport, ['qs' => ['to' => $skill->getStartPosition()->getSlug()]]),
			'transitions_out_count' => SkillQuery::create()->filterByStartPosition($skill->getEndPosition())->where(SkillTableMap::COL_START_POSITION_ID . ' != ' . SkillTableMap::COL_END_POSITION_ID)->count(),
			'edit_url' => $router->generate('skill-edit', $sport, ['skill' => $slug]),
			'flags' => [
				'movender' => Skill::FLAG_MOVENDER,
				'movendum' => Skill::FLAG_MOVENDUM,
				'simultaneous' => Skill::FLAG_SIMULTANEOUS,
				'isolated' => Skill::FLAG_ISOLATED,
				'same' => Skill::FLAG_SAME,
				'opposite' => Skill::FLAG_OPPOSITE
			]
		]);
		return $this->getResponse($request);
	}
	
	protected function setDefaultParams(OptionsResolverInterface $resolver) {
		$resolver->setRequired(['sport', 'skill']);
	}
}
