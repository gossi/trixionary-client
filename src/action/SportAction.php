<?php
namespace gossi\trixionary\client\action;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use gossi\trixionary\model\GroupQuery;
use gossi\trixionary\model\SkillQuery;

/**
 * Sports Listing
 * 
 * @author gossi
 */
class SportAction extends AbstractSportAction {

	/**
	 * Automatically generated run method
	 * 
	 * @param Request $request
	 * @return Response
	 */
	public function run(Request $request) {
		$this->addData([
			'groups' => $this->getGroups(),
			'groupCount' => GroupQuery::create()->filterBySport($this->getSport())->count(),
			'skillCount' => SkillQuery::create()->filterBySport($this->getSport())->count()
		]);
		return $this->getResponse($request);
	}
	
	
	/* (non-PHPdoc)
	 * @see \keeko\core\action\AbstractAction::setDefaultParams()
	 */
	protected function setDefaultParams(OptionsResolverInterface $resolver) {
		$resolver->setRequired(['sport']);
	}

}
