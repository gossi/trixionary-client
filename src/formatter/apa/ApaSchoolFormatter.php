<?php
namespace gossi\trixionary\client\formatter\apa;

use gossi\trixionary\client\formatter\ReferenceInterface;

abstract class ApaSchoolFormatter extends AbstractFormatter {
	
	/**
	 * @param ReferenceInterface $reference
	 */
	public function format($reference) {
		$parts = [];
		$parts[] = $this->formatAuthors($reference);
		$parts[] = sprintf('<cite itemprop="name">%s</cite>', $reference->getTitle());
		$school = sprintf('<span itemprop="genre">%s</span>', $this->getGenre());
		$school .= sprintf(', <span itemprop="sourceOrganization" itemscop itemtype="http://schema.org/Organization">%s</span>', $reference->getSchool());
		$parts[] = $school;
		$parts[] = $this->formatPublisher($reference);
		
		return sprintf('<span itemprop="citation" itemscope itemtype="http://schema.org/ScholarlyArticle">%s</span>.', implode('. ', $parts));
	}
	
	abstract protected function getGenre();
}