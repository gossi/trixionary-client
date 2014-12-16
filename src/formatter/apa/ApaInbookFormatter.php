<?php
namespace gossi\trixionary\client\formatter\apa;

use gossi\trixionary\client\formatter\ReferenceInterface;

class ApaInbookFormatter extends AbstractFormatter {
	
	/**
	 * @param ReferenceInterface $reference
	 */
	public function format($reference) {
		$parts = [];
		$parts[] = $this->formatAuthors($reference);
		$parts[] = sprintf('<span itemprop="name">%s</span>', $reference->getTitle());
	
		$pages = sprintf('(%s <span itemprop="pagination">%s</span>)', $this->labels['p'], $reference->getPages());
		$eds = ApaPersonFormatter::parse($reference->getEditor());
		$ed = $eds > 1 ? $this->labels['eds'] : $this->labels['ed'];
		$book = sprintf('%s %s (%s)', ucwords($this->labels['in']), ApaPersonFormatter::formatPersons($reference->getEditor(), 'editor'), $ed);
		$book .= sprintf(', <cite itemprop="name">%s</cite>', $reference->getBooktitle());
		$parts[] = sprintf('<span itemprop="isPartOf" itemscope itemtype="http://schema.org/Book">%s</span> %s', $book, $pages);
		$parts[] = $this->formatPublisher($reference);
	
		return sprintf('<span itemprop="citation" itemscope itemtype="http://schema.org/Article">%s</span>.', implode('. ', $parts));
	}
	
}