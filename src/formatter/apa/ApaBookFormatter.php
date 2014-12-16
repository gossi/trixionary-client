<?php
namespace gossi\trixionary\client\formatter\apa;

use gossi\trixionary\client\formatter\ReferenceInterface;

class ApaBookFormatter extends AbstractFormatter {
	
	/**
	 * @param ReferenceInterface $reference
	 */
	public function format($reference) {
		$parts = [];
		$parts[] = $this->formatAuthors($reference);
		
		$title = sprintf('<cite itemprop="name">%s</cite>', $reference->getTitle());
		
		if ($reference->getEdition()) {
			$title .= sprintf('<span itemprop="bookEdition">%s</span>', $reference->getEdition());
		}
		
		$parts[] = $title;
		$parts[] = $this->formatPublisher($reference);
		
		return sprintf('<span itemprop="citation" itemscope itemtype="http://schema.org/Book">%s</span>.', implode('. ', $parts));
	}

}