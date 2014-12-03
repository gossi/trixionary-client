<?php
namespace gossi\trixionary\client\action;

use keeko\core\action\AbstractAction;
use Symfony\Component\HttpFoundation\Request;
use Cocur\Slugify\Slugify;
use Symfony\Component\HttpFoundation\RedirectResponse;
use gossi\trixionary\model\PositionQuery;
use gossi\trixionary\model\Position;

abstract class PositionFormAction extends AbstractSportAction {
	
	/**
	 * Automatically generated run method
	 * 
	 * @param Request $request
	 * @return Response
	 */
	public function run(Request $request) {
		$sport = $this->getSport();
		$position = $this->getPosition();
		
		$redirect = $request->headers->get('referer');
		$router = $this->getModule()->getRouter();

		if ($request->isMethod('POST')) {
			$redirect = $request->request->get('redirect');
			$slug = $request->request->get('slug'); 
			if (empty($slug)) {
				$slugifier = new Slugify();
				$slug = $slugifier->slugify($request->request->get('title'));
			}
			$position->setSlug($slug);
			$position->setTitle($request->request->get('title'));
			$position->setSport($sport);
			$position->save();
			
			return new RedirectResponse($redirect);
		}
		
		$this->addData([
			'position' => $position,
			'redirect' => $redirect,
			'delete_url' => !empty($this->params['position'])
				? $router->generate('position-delete', $sport, ['position' => $position->getSlug()])
				: ''
		]);
		return $this->getResponse($request);
	}
	
	protected function getPosition() {
		if (isset($this->params['position'])) {
			return PositionQuery::create()->filterBySlug($this->params['position'])->filterBySport($this->getSport())->findOne();
		}
		
		return new Position();
	}
}