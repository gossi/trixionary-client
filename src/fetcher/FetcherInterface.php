<?php
namespace gossi\trixionary\client\fetcher;

interface FetcherInterface {
	
	/**
	 * Fetches data for the given url
	 * 
	 * @param string $url
	 * @return array
	 */
	public function fetch($url);
	
	/**
	 * Returns whether the fetcher understands this url or not
	 * 
	 * @param string $url
	 * @return boolean
	 */
	public function supports($url);
}