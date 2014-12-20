<?php
namespace gossi\trixionary\client\fetcher;

class VimeoFetcher extends AbstractFetcher {

	public function fetch($url) {
		$doc = file_get_contents(urldecode($url));
		$url = $this->getItemprop('url', $this->getLinkTags($doc), 'href');

		$matches = [];
		preg_match('/vimeo\.com\/(\d+)\/?/', $url, $matches);
		$id = $matches[1];
		
		$data = file_get_contents("http://vimeo.com/api/v2/video/$id.json");
		$data = json_decode($data, true);
		
		return [
			'provider_id' => $id,
			'width' => $this->getItemprop('width', $this->getMetaTags($doc)),
			'height' => $this->getItemprop('height', $this->getMetaTags($doc)),
			'player_url' => $this->getItemprop('embedUrl', $this->getLinkTags($doc), 'href'),
			'poster_url' => $data[0]['thumbnail_large'],
			'provider' => 'vimeo',
			'title' => $this->getItemprop('name', $this->getMetaTags($doc)),
			'description' => strip_tags($data[0]['description']),
			'year' => substr($data[0]['upload_date'], 0, 4),
		];
	}
	
	public function supports($url) {
		return preg_match('/vimeo\.com/i', $url);
	}
}