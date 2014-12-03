<?php
namespace gossi\trixionary\client\action;

use keeko\core\action\AbstractAction;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Cocur\Slugify\Slugify;
use gossi\trixionary\model\GroupQuery;
use gossi\trixionary\model\Group;

abstract class GroupFormAction extends AbstractSportAction {
	
	public function run(Request $request) {
		$sport = $this->getSport();
		$group = $this->getGroup();
		
		$redirect = $request->headers->get('referer');
		$router = $this->getModule()->getRouter();
	
		if ($request->isMethod('POST')) {
			$redirect = $request->request->get('redirect');
			$slug = $request->request->get('slug');
			if (empty($slug)) {
				$slugifier = new Slugify();
				$slug = $slugifier->slugify($request->request->get('title'));
			}
			$group->setSlug($slug);
			$group->setTitle($request->request->get('title'));
			$group->setDescription($request->request->get('description'));
			$group->setSport($sport);
			$group->save();
			
			return new RedirectResponse($redirect);
		}
	
		$this->addData([
			'group' => $group,
			'redirect' => $redirect,
			'delete_url' => !empty($this->params['group'])
				? $router->generate('group-delete', $sport, ['group' => $group->getSlug()])
				: '',
			'edit_url' => !empty($this->params['group'])
				? $router->generate('group-edit', $sport, ['group' => $group->getSlug()])
				: ''
		]);
		return $this->getResponse($request);
	}
	
	protected function getGroup() {
		if (isset($this->params['group'])) {
			return GroupQuery::create()->filterBySlug($this->params['group'])->filterBySport($this->getSport())->findOne();
		}
		
		return new Group();
	}
}