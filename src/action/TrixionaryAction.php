<?php
namespace gossi\trixionary\client\action;

use keeko\framework\foundation\AbstractAction;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Route;
use gossi\trixionary\model\SportQuery;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use phootwork\lang\Text;

/**
 * Trixionary Router
 *
 * @author gossi
 */
class TrixionaryAction extends AbstractAction {

	/**
	 * Automatically generated run method
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function run(Request $request) {
		$routes = $this->generateRoutes();
		$context = new RequestContext($this->getBaseUrl());
		$matcher = new UrlMatcher($routes, $context);

		$match = $matcher->match($this->getDestination());
		$route = $match['_route'];
		unset($match['_route']);

		if (Text::create($route)->startsWith('sport-')) {
			$route = 'sport';
		}

		$action = $this->getModule()->loadAction($route, 'html');
		$action->setParams($match);

		if ($route == 'sport') {
			$action->setBaseUrl($this->getBaseUrl());
		}

		$kernel = $this->getServiceContainer()->getKernel();
		return $kernel->handle($action, $request);
	}

	/**
	 *
	 * @return RouteCollection
	 */
	private function generateRoutes() {
		$routes = new RouteCollection();

		$routes->add('info', new Route('/info'));
		$routes->add('help', new Route('/help'));
		$routes->add('manage', new Route('/manage'));
		$routes->add('manage-add', new Route('/manage/add'));
		$routes->add('manage-edit', new Route('/manage/{id}'));
		$routes->add('manage-delete', new Route('/manage/{id}/delete'));
		$routes->add('manage-default', new Route('/manage/{id}/default'));
		$routes->add('objects', new Route('/manage/{id}/objects'));
		$routes->add('objects-add', new Route('/manage/{id}/objects/add'));
		$routes->add('objects-edit', new Route('/manage/{id}/objects/{objectId}'));
		$routes->add('objects-delete', new Route('/manage/{id}/objects/{objectId}/delete'));

		$default = null;
		foreach (SportQuery::create()->find() as $sport) {
			$default = $sport->getIsDefault() ? $sport : $default;

			if (!$sport->getIsDefault()) {
				$routes->add('sport-' . $sport->getSlug(), new Route('/' . $sport->getSlug() . '{suffix}',
					['suffix' => '', 'sport' => $sport->getId()],
					['suffix' => '.*'])
				);
			}
		}

		if ($default !== null) {
			$routes->add('sport', new Route('/{suffix}',
				['suffix' => '', 'sport' => $default->getId()],
				['suffix' => '.*'])
			);
		} else {
			$routes->add('index', new Route('/'));
		}

		return $routes;
	}
}
