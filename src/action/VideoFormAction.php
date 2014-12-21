<?php
namespace gossi\trixionary\client\action;

use Symfony\Component\HttpFoundation\Request;
use gossi\trixionary\model\SkillQuery;
use gossi\trixionary\model\Video;
use gossi\trixionary\model\VideoQuery;
use keeko\core\model\ActivityObject;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Filesystem\Filesystem;
use gossi\trixionary\model\Reference;
use gossi\trixionary\client\formatter\ReferenceInterface;

class VideoFormAction extends AbstractSkillAction {

	public function run(Request $request) {
		$skill = $this->getSkill();
		$video = $this->getVideo();
		
		if ($request->isMethod('POST')) {
			$create = $video->isNew();
			$user = $this->getServiceContainer()->getAuthManager()->getUser();
			$post = $request->request;
			$video->setUploaderId($user->getId());
			$video->setMovender($post->get('movender'));
			$video->setTitle($post->get('title'));
			$video->setDescription($post->get('description'));
			$video->setProvider($post->get('provider'));
			$video->setProviderId($post->get('provider_id'));
			$video->setPlayerUrl($post->get('player_url'));
			$video->setPosterUrl($post->get('poster_url'));
			$video->setWidth($post->get('width'));
			$video->setHeight($post->get('height'));
			$video->setIsTutorial($post->get('tutorial'));
			$video->setSkill($skill);
			
			if ($post->get('type') == 'upload') {
				$video->save();
				$uploadname = $post->get('filename');
				if (!empty($uploadname)) {
					$fs = new Filesystem();
					$filename = $video->getFilename();
					$videosFolder = $this->getTrixionary()->getVideosPath($skill);
					if (!$fs->exists($videosFolder)) {
						$fs->mkdir($videosFolder, 0777);
					}
				
					$fs->rename($this->getTrixionary()->getUploadPath() . '/' . $uploadname, $videosFolder . '/' . $filename);
				}
			} else {
				$reference = new Reference();
				$reference->setSkill($skill);
				$reference->setType(ReferenceInterface::MULTIMEDIA);
				$reference->setTitle($post->get('title'));
				$reference->setYear($post->get('year'));
				$reference->setAuthor($post->get('author'));
				$reference->setPublisher($post->get('publisher'));
				$reference->setHowpublished('Online-Video');
				$reference->setUrl($post->get('url'));
				$reference->setLastchecked(new \DateTime($post->get('lastchecked')));
				$reference->setManaged(true);

				$video->setReference($reference);
				$video->save();
			}

			// activity
			$user = $this->getServiceContainer()->getAuthManager()->getUser();
			$user->newActivity([
				'verb' => $create ? ActivityObject::VERB_UPLOAD : ActivityObject::VERB_EDIT,
				'object' => $video,
				'target' => $skill
			]);

			$url = $this->generateUrl('videos', ['skill' => $skill->getSlug()]);
			return new RedirectResponse($url);
		}
		
		$this->addData([
			'video' => $video,
			'edit_url' => $this->generateUrl('skill-edit', ['skill' => $skill->getSlug()]),
			'api_url' => $this->getServiceContainer()->getPreferenceLoader()->getSystemPreferences()->getApiUrl(),
			'fetch_url' => $this->generateUrl('_video-fetch-data')
		]);
		return $this->getResponse($request);
	}
	
	/**
	 * @return Video
	 */
	protected function getVideo() {
		if (isset($this->params['id'])) {
			return VideoQuery::create()->findOneById($this->params['id']);
		}
	
		return new Video();
	}
}