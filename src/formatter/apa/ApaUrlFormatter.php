<?php
namespace gossi\trixionary\client\formatter\apa;

use gossi\trixionary\client\formatter\ReferenceInterface;

class ApaUrlFormatter extends AbstractFormatter {
	
	/**
	 * @param ReferenceInterface $reference
	 */
	public function format($reference) {
		$parts = [];
		
		$parts[] = $this->formatAuthors($reference);

		if ($reference->getTitle()) {
			$parts[] = sprintf('<cite itemprop="name">%s</cite>', $reference->getTitle());
		}
		
		$parts[] = $this->formatUrl($reference);
		
		return sprintf('<span itemprop="citation" itemscope itemtype="http://schema.org/Article">%s</span>.', implode('. ', $parts));
	}
}