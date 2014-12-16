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

abstract class ReferenceFormAction extends AbstractSportAction {
	
	/**
	 * Automatically generated run method
	 * 
	 * @param Request $request
	 * @return Response
	 */
	public function run(Request $request) {
		$sport = $this->getSport();
		$skill = $this->getSkill();
		$router = $this->getModule()->getRouter();
		$reference = $this->getReference();

		// ['pages', 'howpublished', 'url', 'lastchecked'];
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

			$url = $router->generate('skill', $sport, ['skill' => $skill->getSlug()]);
			return new RedirectResponse($url);
		}
		
		$this->addData([
			'skill' => $skill,
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
			],
			'delete_url' => $router->generate('skill-delete', $sport, ['skill' => $skill->getSlug()]),
			'edit_url' => $router->generate('skill-edit', $sport, ['skill' => $skill->getSlug()]),
			'manage_pictures_url' => $router->generate('pictures', $sport, ['skill' => $skill->getSlug()]),
			'manage_videos_url' => $router->generate('videos', $sport, ['skill' => $skill->getSlug()]),
			'manage_references_url' => $router->generate('references', $sport, ['skill' => $skill->getSlug()]),
			'create_picture_url' => $router->generate('picture-create', $sport, ['skill' => $skill->getSlug()]),
			'create_video_url' => $router->generate('video-create', $sport, ['skill' => $skill->getSlug()]),
			'create_reference_url' => $router->generate('reference-create', $sport, ['skill' => $skill->getSlug()]),
		]);

		return $this->getResponse($request);
	}
	
	private function getSkill() {
		return SkillQuery::create()
			->filterBySlug($this->params['skill'])
			->filterBySport($this->getSport())
			->findOne();
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