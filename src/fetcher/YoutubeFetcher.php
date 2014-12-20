<?php
namespace gossi\trixionary\client\fetcher;

class YoutubeFetcher extends AbstractFetcher {

	public function fetch($url) {
		$doc = file_get_contents(urldecode($url));
		$id = $this->getItemprop('videoId', $this->getMetaTags($doc));
		
		return [
			'provider_id' => $id,
			'width' => $this->getProperty('og:video:width', $this->getMetaTags($doc)),
			'height' => $this->getProperty('og:video:height', $this->getMetaTags($doc)),
			'player_url' => $this->getItemprop('embedURL', $this->getLinkTags($doc), 'href'),
			'poster_url' => 'https://i.ytimg.com/vi/'.$id.'/mqdefault.jpg',
			'provider' => 'youtube',
			'title' => $this->getProperty('og:title', $this->getMetaTags($doc)),
			'description' => $this->getProperty('og:description', $this->getMetaTags($doc)),
			'year' => ''
		];
	}
	
	public function supports($url) {
		return preg_match('/youtu\.?be(\.com)?/i', $url);
	}
}