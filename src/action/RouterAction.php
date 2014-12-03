<?php
namespace gossi\trixionary\client\action;

use keeko\core\action\AbstractAction;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\Route;

/**
 * Trixionary Router
 * 
 * @author gossi
 */
class RouterAction extends AbstractAction {

	/**
	 * Automatically generated run method
	 * 
	 * @param Request $request
	 * @return Response
	 */
	public function run(Request $request) {
		$router = $this->getModule()->getRouter();
		
		$app = $this->getServiceContainer()->getApplication();
		
		try {
			$match = $router->match(str_replace('//', '/', '/'. $app->getTailPath()));
			$route = $match['_route'];
			
			unset($match['_route']);

			$route = ($pos = strpos($route, '-')) !== false ? substr($route, $pos + 1) : $route;
			$action = $this->getModule()->loadAction($route, 'html');
			$action->setParams($match);
			
			$runner = $this->getServiceContainer()->getRunner();
			return $runner->run($action, $request);
		} catch (ResourceNotFoundException $e) {
			
		}
		
		return new Response('', 500);
	}
}
