<?php
namespace gossi\trixionary\client;

use keeko\core\routing\QueryStringTrait;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Cocur\Slugify\Slugify;
use Symfony\Component\HttpFoundation\Request;
use gossi\trixionary\model\SportQuery;

class TrixionaryRouter {
	
	use QueryStringTrait;

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
		if (($pos = strpos($request, '?')) !== false) {
			$request = substr($request, 0, $pos);
		}
		$data = $this->matcher->match($request);
		
		$req = Request::createFromGlobals();
		$data = array_merge($req->query->all(), $data);
// 		if (isset($data['qs'])) {
// 			$qs = $this->unserializeQueryString($data['qs']);
// 			unset($data['qs']);
			
// 			foreach ($qs as $k => $v) {
// 				$data[$k] = $v;
// 			}
// 		}
		
		return $data;
	}

	public function generate($name, $sport, $data = []) {
		if (strpos($name, '_') === false) { 
			$name = $sport->getSlug() . '-' . $name;
			$data['sport'] = $sport->getSlug();
		}
		if (isset($data['qs'])) {
			$data['qs'] = $this->serializeQueryString($data['qs'], true);
		}
		$app = $this->module->getServiceContainer()->getApplication();
		return str_replace('%3F', '?', $app->getRootUrl() .$this->generator->generate($name, $data));
	}

	/**
	 *
	 * @return RouteCollection
	 */
	private function generateRoutes() {
		$routes = new RouteCollection();
		$needsIndex = true;
		$translator = $this->module->getServiceContainer()->getTranslator();
		$slugifier = new Slugify();

		$sports = SportQuery::create()->find();
		foreach ($sports as $sport) {
			if ($needsIndex && $sport->getIsDefault()) {
				$needsIndex = false;
			}
			$subRoutes = new RouteCollection();
			$params = $sport->getIsDefault() ? ['sport' => $sport->getSlug()] : [];

			$subRoutes->add($sport->getSlug() . '-sport', new Route('', $params));
			$subRoutes->add($sport->getSlug() . '-transitions', new Route($sport->getTransitionsSlug(), $params));
			$subRoutes->add($sport->getSlug() . '-graph', new Route('graph', $params));
			$subRoutes->add($sport->getSlug() . '-group', new Route($sport->getGroupSlug().'/{group}', $params));
			$subRoutes->add($sport->getSlug() . '-skill', new Route($sport->getSkillSlug().'/{skill}', $params));
			$subRoutes->add($sport->getSlug() . '-kstruktur-init', new Route($sport->getSkillSlug().'/{skill}/kstruktur/init', $params));
			$subRoutes->add($sport->getSlug() . '-kstruktur-update', new Route($sport->getSkillSlug().'/{skill}/kstruktur/update', $params));
			$subRoutes->add($sport->getSlug() . '-functionphase-init', new Route($sport->getSkillSlug().'/{skill}/functionphase/init', $params));
			$subRoutes->add($sport->getSlug() . '-functionphase-update', new Route($sport->getSkillSlug().'/{skill}/functionphase/update', $params));
			
			// skill prop routes
			foreach (['picture', 'video', 'reference'] as $prop) {
				$slug = $sport->getSkillSlug().'/{skill}/' . $slugifier->slugify($translator->transChoice($prop, 2, [], 'gossi.trixionary-client'));
				$subRoutes->add(sprintf('%s-%ss', $sport->getSlug(), $prop), new Route($slug, $params));
				$methods = ['create', 'edit', 'delete'];
				
				if ($prop == 'picture') {
					$methods[] = 'feature';
				}
				
				foreach ($methods as $method) {
					$route = $slug . '/' . $slugifier->slugify($translator->trans($method, [], 'gossi.trixionary-client'));
					if ($method !== 'create') {
						$route .= '/{id}';
					}
					$subRoutes->add(sprintf('%s-%s-%s', $sport->getSlug(), $prop, $method), new Route($route, $params));
				}
			}
			
			// group & skill crud routes
			$objects = ['skill' => $sport->getSkillSlug(), 'group' => $sport->getGroupSlug()];

			if ($sport->getCompositional()) {
				$objects['position'] = $sport->getPositionSlug();
			}

			foreach ($objects as $object => $label) {
				foreach (['create', 'edit', 'delete'] as $method) {
					if ($method === 'create') {
						$route = $slugifier->slugify($translator->trans($method, [], 'gossi.trixionary-client')).'/'.$label;
					} else {
						$route = sprintf('%s/{%s}/%s', $label, $object, 
							$slugifier->slugify($translator->trans($method, [], 'gossi.trixionary-client')));
					}
					$subRoutes->add(sprintf('%s-%s-%s', $sport->getSlug(), $object, $method), new Route($route, $params));
				}
			}
			
			// add prefix
			if (!$sport->getIsDefault()) {
				$subRoutes->addPrefix($sport->getSlug() .'/');
			}
			
			$routes->addCollection($subRoutes);
		}

		if ($needsIndex) {
			$routes->add('index', new Route('/'));
		}
		
		$routes->add('_video-fetch-data', new Route('/fetch-url'));
		$routes->add('_info', new Route('/info'));
		$routes->add('_help', new Route('/help'));
		
// 		echo '<pre>';
// 		print_r($routes);
	
		return $routes;
	}
}