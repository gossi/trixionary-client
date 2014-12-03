<?php
namespace gossi\trixionary\client\action;

use keeko\core\action\AbstractAction;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use gossi\trixionary\model\SkillQuery;

/**
 * Graph
 * 
 * @author gossi
 */
class GraphAction extends AbstractSportAction {

	/**
	 * Automatically generated run method
	 * 
	 * @param Request $request
	 * @return Response
	 */
	public function run(Request $request) {
		$sport = $this->getSport();
		$router = $this->getModule()->getRouter();
		$skills = SkillQuery::create()->filterBySport($sport)->filterByIsMultiple(null)->find();
		
		$transitions = [];
		$nodes = [];
		$edges = [];
		foreach ($skills as $skill) {
			$node = [
				'label' => $skill->getName(),
				'id' => $skill->getId(),
				'slug' => $skill->getSlug(),
				'importance' => $skill->getImportance(),
				'generation' => $skill->getGeneration(),
				'level' => $skill->getGeneration(),
				'description' => $skill->getDescription()
			];
			
			if ($skill->isTransition()) {
				$transitions[] = $node;
			} else {
				$nodes[] = $node;
			}
			
			foreach ($skill->getParents() as $parent) {
				$edges[] = [
					'from' => $parent->getId(),
					'to' => $skill->getId()
				];
			}
			
			if ($skill->getVariationOf() !== null) {
				$edges[] = [
					'from' => $skill->getVariationOfId(),
					'to' => $skill->getId()
				];
			}
		}

		$this->addData([
			'nodes' => json_encode($nodes),
			'edges' => json_encode($edges),
			'transitions' => $transitions,
			'url_pattern' => $router->generate('skill', $sport, ['skill' => '_skill_'])
		]);
		return $this->getResponse($request);
	}
	
	protected function setDefaultParams(OptionsResolverInterface $resolver) {
		$resolver->setRequired(['sport']);
	}
}
