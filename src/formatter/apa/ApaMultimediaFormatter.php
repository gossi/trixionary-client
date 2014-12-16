<?php
namespace gossi\trixionary\client\formatter\apa;

use gossi\trixionary\client\formatter\ReferenceInterface;

class ApaMultimediaFormatter extends AbstractFormatter {
	
	/**
	 * @param ReferenceInterface $reference
	 */
	public function format($reference) {
		$parts = [];
		$parts[] = $this->formatAuthors($reference);
		$parts[] = sprintf('<cite itemprop="name">%s</cite>', $reference->getTitle());
		$parts[] = sprintf('<span itemprop="genre">%s</span>', $reference->getHowpublished());
		$parts[] = $this->formatPublisher($reference);
		$parts[] = $this->formatUrl($reference);
	
		return sprintf('<span itemprop="citation" itemscope itemtype="http://schema.org/MediaObject">%s</span>.', implode('. ', $parts));
	}

}