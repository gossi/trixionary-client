<?php
namespace gossi\trixionary\client\action;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use gossi\trixionary\model\GroupQuery;
use gossi\trixionary\model\SkillQuery;

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
		$sport = $this->getSport();
		$group = GroupQuery::create()->filterBySport($sport)->filterBySlug($this->params['group'])->findOne();
		
		// check for dependencies
		$skills = SkillQuery::create()->filterByGroup($group);
		if ($skills->count()) {
			$this->addData([
				'group' => $group,
				'skills' => $skills->find(),
				'group_url' => $this->generateUrl('group', ['group' => $group->getSlug()]),
				'url_pattern' => $this->generateUrl('skill', ['skill' => '_skill_'])
			]);
			
			return $this->getResponse($request);
		} else {
			$group->delete();
			
			$url = $this->generateUrl('sport');
			return new RedirectResponse($url);
		}
	}
	
	protected function setDefaultParams(OptionsResolverInterface $resolver) {
		$resolver->setRequired(['sport', 'group']);
	}
}
