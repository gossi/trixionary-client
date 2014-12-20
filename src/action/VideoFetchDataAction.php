<?php
namespace gossi\trixionary\client\action;

use keeko\core\action\AbstractAction;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use gossi\trixionary\client\fetcher\DelegatingFetcher;
use gossi\trixionary\client\fetcher\YoutubeFetcher;
use gossi\trixionary\client\fetcher\VimeoFetcher;

/**
 * Fetch video data from remote source
 * 
 * @author gossi
 */
class VideoFetchDataAction extends AbstractAction {

	/**
	 * Automatically generated run method
	 * 
	 * @param Request $request
	 * @return Response
	 */
	public function run(Request $request) {
		$fetcher = new DelegatingFetcher([
			new YoutubeFetcher(),
			new VimeoFetcher()
		]);
		
		$response = new JsonResponse($fetcher->fetch($this->params['url']));
		$response->prepare($request);
		$response->send();
		exit;
	}

	protected function setDefaultParams(OptionsResolverInterface $resolver) {
		$resolver->setRequired(['url']);
	}

}
