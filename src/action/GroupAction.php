<?php
namespace gossi\trixionary\client\action;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use gossi\trixionary\model\GroupQuery;
use gossi\trixionary\model\SkillQuery;

/**
 * List skills of a group
 * 
 * @author gossi
 */
class GroupAction extends AbstractSportAction {

	/**
	 * Automatically generated run method
	 * 
	 * @param Request $request
	 * @return Response
	 */
	public function run(Request $request) {
		$router = $this->getModule()->getRouter();
		$sport = $this->getSport();
		$group = GroupQuery::create()->filterBySlug($this->params['group'])->filterBySport($sport)->findOne();
		$skills = SkillQuery::create()->filterByGroup($group)->find();

		$urlPattern = $router->generate('skill', $this->getSport(), ['skill' => '_skill_']);

		$this->addData([
			'group' => $group,
			'groups' => $this->getGroups(),
			'skills' => $skills,
			'url_pattern' => $urlPattern, 
			'edit_url' => !empty($this->params['group'])
				? $router->generate('group-edit', $sport, ['group' => $group->getSlug()])
				: ''
		]);
		return $this->getResponse($request);
	}
	
	protected function setDefaultParams(OptionsResolverInterface $resolver) {
		$resolver->setRequired(['sport', 'group']);
	}
	
	public function getVariations($ids) {
		$skills = SkillQuery::create()->filterByVariationOfId($ids)->find();
	
		if (count($ids) == 1) {
			return $skills;
		}
	
		$variations = [];
		foreach ($skills as $skill) {
			if (!isset($variations[$skill->getVariationOfId()])) {
				$variations[$skill->getVariationOfId()] = [];
			}
				
			$variations[$skill->getVariationOfId()][] = $skill;
		}
	
		return $variations;
	}
}
