<?php
namespace gossi\trixionary\client\formatter\apa;

class ApaPersonFormatter {
	
	public static function parse($persons, $delimiter = ';') {
		$parsed = [];
		$persons = explode($delimiter, $persons);
		
		foreach ($persons as $person) {
			$person = trim($person);
			
			if (strpos($person, ',') !== false) {
				$names = explode(',', $person);
				$parsed[] = [
					'given' => trim($names[1]),
					'family' => trim($names[0])
				];
			} else {
				$parsed[] = ['name' => $person];
			}
		}
		
		return $parsed;
	}
	
	public static function formatPersons($persons, $itemprop = null) {
		$out = '';
		$persons = static::parse($persons);
	
		for ($i = 0, $max = count($persons); $i < $max; $i++) {
			$person = $persons[$i];
			$out .= static::formatPerson($person, $itemprop);
				
			if ($i == ($max - 2)) {
				$out .= ' & ';
			} else if ($i < ($max - 2)) {
				$out .= ', ';
			}
		}
	
		return $out;
	}
	
	public static function formatPerson($person, $itemprop = null) {
		$out = sprintf('<span %sitemscope itemtype="http://schema.org/Person">', $itemprop ? 'itemprop="'.$itemprop.'" ' : '');
		if (isset($person['name'])) {
			$out .= sprintf('<span itemprop="name">%s</span>', $person['name']);
		} else {
			$family = sprintf('<span itemprop="familyName">%s</span>', $person['family']);
			$given = sprintf('<meta itemprop="givenName" content="%s">', $person['given']);
			$name = trim($person['given']);
			$initials = ''; 
			$print = true;
			for ($j = 0, $len = strlen($name); $j < $len; $j++) {
				if ($print) {
					$initials .= strtoupper($name[$j]) . '.';
					$print = false;
				}
		
				if ($name[$j] == ' ' || $name[$j] == '-') {
					$initials .= $name[$j];
					$print = true;
				}
			}
			
			if ($itemprop == 'editor') {
				$out .= $initials . ' ' . $family;
			} else {
				$out .= $family . ', ' . $initials;
			}
			
			$out .= $given;	
		}
		$out .= '</span>';
		
		return $out;
	}
}