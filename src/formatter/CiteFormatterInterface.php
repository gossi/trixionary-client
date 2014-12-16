<?php
namespace gossi\trixionary\client\formatter;

interface CiteFormatterInterface {
	
	/**
	 * @param ReferenceInterface $reference
	 */
	public function format($reference);
	
	/**
	 * @param ReferenceInterface[] $references
	 */
	public function sort($references);
}