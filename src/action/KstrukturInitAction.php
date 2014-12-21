<?php
namespace gossi\trixionary\client\action;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use gossi\trixionary\model\SkillQuery;
use gossi\trixionary\model\Kstruktur;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Initializes the k-Struktur
 * 
 * @author gossi
 */
class KstrukturInitAction extends AbstractSkillAction {

	/**
	 * Automatically generated run method
	 * 
	 * @param Request $request
	 * @return Response
	 */
	public function run(Request $request) {
		$skill = $this->getSkill();
		
		if ($skill->getKstrukturs()->count() == 0) {
			$main = new Kstruktur();
			$main->setSkill($skill);
			$main->setTitle($skill->getName());
			$main->setType(Kstruktur::STRUCTURE);
			$main->save();
		}
		
		$url = $this->generateUrl('skill', ['skill' => $skill->getSlug()]) . '#k-struktur';
		return new RedirectResponse($url);
	}
	
	protected function setDefaultParams(OptionsResolverInterface $resolver) {
		$resolver->setRequired(['sport', 'skill']);
	}
}
