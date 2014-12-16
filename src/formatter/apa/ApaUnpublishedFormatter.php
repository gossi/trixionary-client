<?php
namespace gossi\trixionary\client\formatter\apa;

use gossi\trixionary\client\formatter\ReferenceInterface;

class ApaUnpublishedFormatter extends AbstractFormatter {
	
	/**
	 * @param ReferenceInterface $reference
	 */
	public function format($reference) {
		$parts = [];
		$parts[] = $this->formatAuthors($reference);
		$parts[] = sprintf('<cite itemprop="name">%s</cite>', $reference->getTitle());
		
		$note = $reference->getNote();
		
		if ($reference->getSchool()) {
			$school = sprintf('<span itemprop="name">%s</span>', $reference->getSchool());
			if ($reference->getAddress()) {
				$school = sprintf(', <span itemprop="address">%s</span>', $reference->getAddress());
			}
			$note .= sprintf(', <span itemprop="sourceOrganization" itemscope itemtype="http://schema.org/Organization">%s</span>', $school);
		}
		
		$parts[] = $note;
		
		return sprintf('<span itemprop="citation" itemscope itemtype="http://schema.org/CreativeWork">%s</span>.', implode('. ', $parts));
	}

}