<?php
namespace gossi\trixionary\client\formatter\apa;

use gossi\trixionary\client\formatter\ReferenceInterface;

class ApaArticleFormatter extends AbstractFormatter {

	/**
	 * @param ReferenceInterface $reference
	 */
	public function format($reference) {
		$parts = [];
		
		$parts[] = $this->formatAuthors($reference);
		$parts[] = sprintf('<span itemprop="name">%s</span>', $reference->getTitle());
		
		$volume = $reference->getVolume();
		if (!empty($volume)) {
			$volume = sprintf(', <span itemprop="isPartOf" itemscope
              itemtype="http://schema.org/PublicationVolume"><link
              itemprop="isPartOf" href="#periodical-%u" /><span
              itemprop="volumeNumber">%s</span></span>', $reference->getId(), $volume);
		}
		$magazine = sprintf('<span itemscope itemtype="http://schema.org/Periodical" 
				itemid="#periodical-%u"><cite><span itemprop="name">%s</span>%s</cite></span>', $reference->getId(), $reference->getJournal(), $volume);
		
		$number = $reference->getNumber();
		if (!empty($number)) {
			$number = sprintf(' (<span itemprop="issueNumber">%s</span>)', $number);
		}
		
		$pages = $reference->getPages();
		if (!empty($pages)) {
			$pages = sprintf(', <span itemprop="pagination">%s</span>', $pages);
		}
		
		$issue = $magazine . $number;
		$issue = sprintf('<span itemprop="isPartOf" itemscope itemtype="http://schema.org/PublicationIssue" itemid="#issue">%s</span>%s', $issue, $pages);

		$parts[] = $issue;

		if ($reference->getUrl()) {
			$parts[] = $this->formatUrl($reference);
		}

		return sprintf('<span itemprop="citation" itemscope itemtype="http://schema.org/ScholarlyArticle">%s</span>.', implode('. ', $parts));
	}
}