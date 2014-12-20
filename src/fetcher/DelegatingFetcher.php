<?php

namespace gossi\trixionary\client\fetcher;

class DelegatingFetcher implements FetcherInterface {
	
	/**
	 * 
	 * @var FetcherInterface[]
	 */
	private $fetcher;
	
	public function __construct($fetchers) {
		$this->fetcher = $fetchers;
	}
	
	public function fetch($url) {
		foreach ($this->fetcher as $fetcher) {
			if ($fetcher->supports($url)) {
				return $fetcher->fetch($url);
			}
		}
		
		return [];
	}
	
	public function supports($url) {
		return true;	
	}
}