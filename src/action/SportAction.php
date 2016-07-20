<?php
namespace gossi\trixionary\client\action;

use gossi\trixionary\model\SportQuery;
use keeko\framework\domain\payload\Blank;
use keeko\framework\foundation\AbstractAction;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolver;
use phootwork\json\Json;
use keeko\framework\page\Meta;

/**
 * Shows the trixionary for a sport
 *
 * This code is automatically created. Modifications will probably be overwritten.
 *
 * @author Thomas Gossmann
 */
class SportAction extends AbstractAction {

	protected function configureParams(OptionsResolver $resolver) {
		$resolver->setDefined(['suffix', 'sport']);
	}

	/**
	 * Automatically generated run method
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function run(Request $request) {
		$url = str_replace($request->getRequestUri(), '', $request->getUri());
		$baseurl = str_replace($url, '', $this->getBaseUrl());
		$sport = SportQuery::create()->findOneById($this->getParam('sport'));
		if (!$sport->getIsDefault()) {
			$baseurl .= '/' . $sport->getSlug();
		}

		// load assets
		$page = $this->getServiceContainer()->getKernel()->getApplication()->getPage();
		$repo = $this->getServiceContainer()->getResourceRepository();

		$page->addStyles($repo->find('/gossi/trixionary-client/public/app/assets/*.css')->getPaths());
		$page->addScripts($repo->find('/gossi/trixionary-client/public/app/assets/vendor-*.js')->getPaths());
		$page->addScripts($repo->find('/gossi/trixionary-client/public/app/assets/trixionary-*.js')->getPaths());

		// set configuration
		$prefs = $this->getServiceContainer()->getPreferenceLoader()->getSystemPreferences();
		$config = [
			'modulePrefix' => 'trixionary',
			'environment' => 'production',
			'rootURL' => $baseurl,
			'locationType' => 'auto',
			'APP' => [
				'name' => 'trixionary',
				'version' => '0.0.0+0d11dfba'
			],
			'keeko' => [
				'api' => $prefs->getApiUrl(),
				'trixionary' => [
					'sportId' => $sport->getId(),
					'slug' => [
						'skill' => $sport->getSkillSlug(),
						'group' => $sport->getGroupSlug(),
						'object' => $sport->getObjectSlug()
					]
				]
			]
		];
		$meta = new Meta();
		$meta->setName('trixionary/config/environment');
		$meta->setContent(rawurlencode(Json::encode($config)));
		$page->addMeta($meta);

		return $this->responder->run($request, new Blank([
			'sport' => $sport
		]));
	}
}
