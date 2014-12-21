<?php
namespace gossi\trixionary\client\action;

use keeko\core\action\AbstractAction;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Deletes a skill
 * 
 * @author gossi
 */
class SkillDeleteAction extends AbstractSkillAction {

	/**
	 * Automatically generated run method
	 * 
	 * @param Request $request
	 * @return Response
	 */
	public function run(Request $request) {
		$skill = $this->getSkill();
		
		// check for dependencies
		$skills = [];
		
		foreach ($skill->getChildren() as $children) {
			$skills[$children->getId()] = $children;
		}
		
		foreach ($skill->getComposites() as $composite) {
			$skills[$composite->getId()] = $composite;
		}
		
		foreach ($skill->getMultiples() as $multiple) {
			$skills[$multiple->getId()] = $multiple;
		}
		
		foreach ($skill->getVariations() as $variation) {
			$skills[$variation->getId()] = $variation;
		}
		
		if (count($skills)) {
			$this->addData([
				'skills' => $skills,
				'url_pattern' => $this->generateUrl('skill', ['skill' => '_skill_'])
			]);
			
			return $this->getResponse($request);
		} else {
			$filesFolder = $this->getTrixionary()->getSkillPath($skill);
			$fs = new Filesystem();
			if ($fs->exists($filesFolder)) {
				$fs->remove($filesFolder);
			}
			
			$skill->delete();
			
			$url = $this->generateUrl('sport');
			return new RedirectResponse($url);
		}
	}
	
	protected function setDefaultParams(OptionsResolverInterface $resolver) {
		$resolver->setRequired(['sport', 'skill']);
	}
}
