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

class VideoFormAction extends AbstractSportAction {

	public function run(Request $request) {
		$router = $this->getModule()->getRouter();
		$sport = $this->getSport();
		$slug = $this->params['skill'];
		$skill = SkillQuery::create()->filterBySport($sport)->filterBySlug($slug)->findOne();
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

			$url = $router->generate('videos', $sport, ['skill' => $skill->getSlug()]);
			return new RedirectResponse($url);
		}
		
		$this->addData([
			'skill' => $skill,
			'skill_url' => $router->generate('skill', $sport, ['skill' => $slug]),
			'video' => $video,
			'edit_url' => $router->generate('skill-edit', $sport, ['skill' => $slug]),
			'api_url' => $this->getServiceContainer()->getPreferenceLoader()->getSystemPreferences()->getApiUrl(),
			'fetch_url' => $router->generate('_video-fetch-data', null),
			'manage_pictures_url' => $router->generate('pictures', $sport, ['skill' => $slug]),
			'manage_videos_url' => $router->generate('videos', $sport, ['skill' => $slug]),
			'manage_references_url' => $router->generate('references', $sport, ['skill' => $slug]),
			'create_picture_url' => $router->generate('picture-create', $sport, ['skill' => $slug]),
			'create_video_url' => $router->generate('video-create', $sport, ['skill' => $slug]),
			'create_reference_url' => $router->generate('reference-create', $sport, ['skill' => $slug]),
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