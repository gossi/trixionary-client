<?php
namespace gossi\trixionary\client\action;

use Symfony\Component\HttpFoundation\Request;
use gossi\trixionary\model\SkillQuery;
use gossi\trixionary\model\PictureQuery;
use gossi\trixionary\model\Picture;
use Imagine\Gd\Imagine;
use Imagine\Image\Box;
use Symfony\Component\Filesystem\Filesystem;
use Cocur\Slugify\Slugify;
use Imagine\Image\ImageInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use keeko\core\model\ActivityObject;

class PictureFormAction extends AbstractSkillAction {
	const IMAGE_SIZE = 1600;
	const THUMB_SIZE = 200;
	
	public function run(Request $request) {
		$skill = $this->getSkill();
		$picture = $this->getPicture();
		
		if ($request->isMethod('POST')) {
			$create = $picture->isNew();
			$user = $this->getServiceContainer()->getAuthManager()->getUser();
			$picture->setUploaderId($user->getId());
			$picture->setPhotographer($request->request->get('photographer'));
			$picture->setMovender($request->request->get('movender'));
			$picture->setTitle($request->request->get('title'));
			$picture->setDescription($request->request->get('description'));
			$picture->setSkill($skill);
			$picture->save();

			$uploadname = $request->request->get('filename');
			if (!empty($uploadname)) {
				$slugifier = new Slugify();
				$fs = new Filesystem();
				$filename = $slugifier->slugify($request->request->get('movender')) . '-' . $picture->getId() . '.jpg';
				$skillFolder = $this->getTrixionary()->getPicturesPath($skill);
				$thumbsFolder = $skillFolder . '/thumbs';
				if (!$fs->exists($thumbsFolder)) {
					$fs->mkdir($thumbsFolder, 0777);
				}
				
				$imagine = new Imagine();
				$image = $imagine->open($this->getTrixionary()->getUploadPath() . '/' . $uploadname);
				// resize
				$size = $image->getSize();
				if (max($size->getWidth(), $size->getHeight()) > self::IMAGE_SIZE) {
					if ($size->getWidth() > $size->getHeight()) {
						$size = $size->widen(self::IMAGE_SIZE);
					} else {
						$size = $size->heighten(self::IMAGE_SIZE);
					}
					$image = $image->resize($size);
				}
				
				if ($size->getWidth() > $size->getHeight()) {
					$thumb = $size->widen(self::THUMB_SIZE);
				} else {
					$thumb = $size->heighten(self::THUMB_SIZE);
				}

				$image->save($skillFolder . '/' . $filename, ['jpeg_quality' => 100])
					->thumbnail($thumb)
					->save($thumbsFolder . '/' . $filename, [
						'resolution-units' => ImageInterface::RESOLUTION_PIXELSPERINCH,
						'resolution-x' => 150,
						'resolution-y' => 150,
						'jpeg_quality' => 100
					]);
			}
			
			if ($skill->getFeaturedPicture() === null) {
				SkillQuery::disableVersioning();
				$skill->setFeaturedPicture($picture);
				$skill->save();
				SkillQuery::enableVersioning();
			}
			
			// activity
			$user = $this->getServiceContainer()->getAuthManager()->getUser();
			$user->newActivity([
				'verb' => $create ? ActivityObject::VERB_UPLOAD : ActivityObject::VERB_EDIT,
				'object' => $picture,
				'target' => $skill
			]);
			
			$url = $this->generateUrl('pictures', ['skill' => $skill->getSlug()]);
			return new RedirectResponse($url);
		}
		
		$this->addData([
			'picture' => $picture,
			'api_url' => $this->getServiceContainer()->getPreferenceLoader()->getSystemPreferences()->getApiUrl()
		]);
		return $this->getResponse($request);
	}
	
	/**
	 * @return Picture
	 */
	protected function getPicture() {
		if (isset($this->params['id'])) {
			return PictureQuery::create()->findOneById($this->params['id']);
		}
		
		return new Picture();
	}
}