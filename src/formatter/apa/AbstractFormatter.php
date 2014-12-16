<?php
namespace gossi\trixionary\client\formatter\apa;

use gossi\trixionary\client\formatter\ReferenceInterface;

abstract class AbstractFormatter {
	
	protected $labels;
	
	public function __construct(array $labels) {
		$this->labels = $labels;
	}
	
	/**
	 * @param ReferenceInterface $reference
	 * @return string
	 */
	abstract function format($reference);
	
	/**
	 * @param ReferenceInterface $reference
	 * @return string
	 */
	protected function formatUrl($reference) {
		return sprintf('%s %s %s <a href="%s" itemprop="url" target="_blank">%s</a>',
			$this->labels['accessed'], $reference->getLastchecked($this->labels['format']),
			$this->labels['at'], $reference->getUrl(), $reference->getUrl()
		);
	}
	
	/**
	 * 
	 * @param ReferenceInterface $reference
	 * @return string
	 */
	protected function formatAuthors($reference) {
		$authors = ApaPersonFormatter::formatPersons($reference->getAuthor(), 'author');
		
		if ($reference->getYear()) {
			$authors .= sprintf(' (<span itemprop="datePublished">%s</span>)', $reference->getYear());
		}
		
		return $authors;
	}
	
	/**
	 *
	 * @param ReferenceInterface $reference
	 * @return string
	 */
	protected function formatPublisher($reference) {
		$publisher = sprintf('<span itemprop="name">%s</span>', $reference->getPublisher());

		if ($reference->getAddress()) {
			$publisher .= sprintf(': <span itemprop="address">%s</span>', $reference->getAddress());
		}
		
		return sprintf('<span itemprop="publisher" itemscope itemtype="http://schema.org/Organization">%s</span>', $publisher);
	}
}
