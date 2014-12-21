<?php
namespace gossi\trixionary\client\action;

use Symfony\Component\HttpFoundation\Request;
use Cocur\Slugify\Slugify;
use Symfony\Component\HttpFoundation\RedirectResponse;
use gossi\trixionary\model\Skill;
use gossi\trixionary\model\SkillQuery;
use gossi\trixionary\model\SkillGroupQuery;
use gossi\trixionary\model\GroupQuery;
use gossi\trixionary\model\SkillGroup;
use gossi\trixionary\model\SkillDependencyQuery;
use gossi\trixionary\model\SkillDependency;
use gossi\trixionary\model\SkillPart;
use gossi\trixionary\model\SkillPartQuery;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Propel;
use keeko\core\model\ActivityObject;
use gossi\trixionary\model\Reference;
use gossi\trixionary\model\ReferenceQuery;
use gossi\trixionary\client\formatter\ReferenceInterface;

abstract class ReferenceFormAction extends AbstractSkillAction {
	
	/**
	 * Automatically generated run method
	 * 
	 * @param Request $request
	 * @return Response
	 */
	public function run(Request $request) {
		$skill = $this->getSkill();
		$reference = $this->getReference();
		
		if ($reference->getManaged()) {
			$url = $this->generateUrl('references', ['skill' => $skill->getSlug()]);
			return new RedirectResponse($url);
		}

		if ($request->isMethod('POST')) {
			$post = $request->request;
			$reference->setSkill($skill);
			$reference->setType($post->get('type'));
			$reference->setTitle($post->get('title'));
			$reference->setBooktitle($post->get('booktitle'));
			$reference->setYear($post->get('year'));
			$reference->setAuthor($post->get('author'));
			$reference->setPublisher($post->get('publisher'));
			$reference->setAddress($post->get('address'));
			$reference->setEditor($post->get('editor'));
			$reference->setJournal($post->get('journal'));
			$reference->setNumber($post->get('number'));
			$reference->setSchool($post->get('school'));
			$reference->setVolume($post->get('volume'));
			$reference->setEdition($post->get('edition'));
			$reference->setPages($post->get('pages'));
			$reference->setHowpublished($post->get('howpublished'));
			$reference->setNote($post->get('note'));
			$reference->setUrl($post->get('url'));
			$reference->setLastchecked(new \DateTime($post->get('lastchecked')));

			$create = $reference->isNew();
			$reference->save();			

			$user = $this->getServiceContainer()->getAuthManager()->getUser();
			$user->newActivity([
				'verb' => $create ? ActivityObject::VERB_ADD : ActivityObject::VERB_EDIT,
				'object' => $reference,
				'target' => $skill
			]);

			$url = $this->generateUrl('skill', ['skill' => $skill->getSlug()]);
			return new RedirectResponse($url);
		}
		
		$this->addData([
			'reference' => $reference,
			'types' => [
				ReferenceInterface::BOOK,
				ReferenceInterface::ARTICLE,
				ReferenceInterface::INBOOK,
				ReferenceInterface::URL,
				ReferenceInterface::UNPUBLISHED,
				ReferenceInterface::BACHELORTHESIS,
				ReferenceInterface::MASTERTHESIS,
				ReferenceInterface::DIPLOMATHESIS,
				ReferenceInterface::PHDTHESIS,
				ReferenceInterface::HABILITATIONTHESIS,
				ReferenceInterface::MULTIMEDIA
			]
		]);

		return $this->getResponse($request);
	}
	
	/**
	 * @return Reference
	 */
	protected function getReference() {
		if (isset($this->params['id'])) {
			return ReferenceQuery::create()->findOneById($this->params['id']);
		}
	
		return new Reference();
	}
}