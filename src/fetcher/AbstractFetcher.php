<?php
namespace gossi\trixionary\client\fetcher;

use gossi\trixionary\client\fetcher\FetcherInterface;

abstract class AbstractFetcher implements FetcherInterface {

	private $metaTags = [];
	private $linkTags = [];
	
	protected function getMetaTags($doc) {
		$hash = md5($doc);
		
		if (!isset($this->metaTags[$hash])) {
			$matches = [];
			preg_match_all('/<meta([^>]+)>/i', $doc, $matches);
			$this->metaTags[$hash] = $matches[1];
		}
		
		return $this->metaTags[$hash];
	}
	
	protected function getLinkTags($doc) {
		$hash = md5($doc);
	
		if (!isset($this->linkTags[$hash])) {
			$matches = [];
			preg_match_all('/<link([^>]+)>/i', $doc, $matches);
			$this->linkTags[$hash] = $matches[1];
		}
	
		return $this->linkTags[$hash];
	}
	
	protected function getProperty($name, $tags) {
		$matches = [];
		foreach ($tags as $tag) {
			if (preg_match('/property="'.$name.'"/i', $tag) && preg_match('/content="(.*)"/i', $tag, $matches)) {
				return $matches[1];
			}
		}
	}
	
	protected function getItemprop($name, $tags, $attr = 'content') {
		$matches = [];
		foreach ($tags as $tag) {
			if (preg_match('/itemprop="'.$name.'"/i', $tag) && preg_match('/'.$attr.'="(.*)"/i', $tag, $matches)) {
				return $matches[1];
			}
		}
	}
}