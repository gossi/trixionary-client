<?php
namespace gossi\trixionary\client;

use keeko\core\routing\AbstractRouter;
use keeko\core\routing\RouterInterface;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\Generator\UrlGenerator;

class TrixionaryRouter implements RouterInterface {
	
	private $matcher;
	private $generator;
	private $module;
	
	public function __construct(TrixionaryClientModule $module, $basepath) {
		$this->module = $module;

		$context = new RequestContext($basepath);
		$routes = $this->generateRoutes();

		$this->matcher = new UrlMatcher($routes, $context);
		$this->generator = new UrlGenerator($routes, $context);
	}
	
	public function match($request) {
		return $this->matcher->match($request);
	}

	public function generate($name, $data = []) {
		$app = $this->module->getServiceContainer()->getApplication();
		return $app->getRootUrl() . $this->generator->generate($name, $data);
	}

	/**
	 *
	 * @return RouteCollection
	 */
	private function generateRoutes() {
		$routes = new RouteCollection();
		$needsIndex = true;
	
		$sports = $this->module->getBackend()->getSports();
		foreach ($sports as $sport) {
			if ($needsIndex && $sport->getIsDefault()) {
				$needsIndex = false;
			}
			$prefix = str_replace('//', '/', '/' . $sport->getIsDefault() ? '' : '{sport}/');
			$params = $sport->getIsDefault() ? ['sport' => $sport->getSlug()] : [];
				
			$routes->add('sport', new Route($prefix, $params));
			$routes->add('group', new Route($prefix.$sport->getGroupSlug().'/{group}', $params));
			$routes->add('skill', new Route($prefix.$sport->getSkillSlug().'/{skill}', $params));
				
			$objects = ['skill' => $sport->getSkillSlug(), 'group' => $sport->getGroupSlug()];
				
			if ($sport->getCompositional()) {
				$objects['stance'] = 'stance';
			}
				
			foreach ($objects as $object => $label) {
				foreach (['create', 'edit', 'delete'] as $method) {
					$route = $prefix.$method.'/'.$label;
					if ($method !== 'create') {
						$route .= '/{id}';
					}
					$routes->add($object.'-'.$method, new Route($route, $params));
				}
			}
		}
	
		if ($needsIndex) {
			$routes->add('index', new Route('/'));
		}
	
		return $routes;
	}
}