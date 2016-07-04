<?php
namespace gossi\trixionary\client\formatter\apa;

use gossi\trixionary\client\formatter\CiteFormatterInterface;

class ApaFormatter implements CiteFormatterInterface {

	private $labels;

	public function __construct(array $labels = []) {
		$this->labels = array_replace([
			'p' => 'p.',
			'in' => 'in',
			'ed' => 'Ed.',
			'eds' => 'Eds.',
			'accessed' => 'Last accessed on',
			'at' => 'at',
			'pages' => 'pages',
			'format' => 'd.m.Y',
			'bachelorthesis' => 'Bachelor Thesis',
			'masterthesis' => 'Master Thesis',
			'diplomathesis' => 'Diploma Thesis',
			'phdthesis' => 'Phd Thesis',
			'habilitationthesis' => 'Habilitation Thesis'
		], $labels);
	}

	public function format($reference) {
		$classname = __NAMESPACE__ . '\\Apa'. ucfirst($reference->getType()) . 'Formatter';

		if (class_exists($classname)) {
			$formatter = new $classname($this->labels);
			return $formatter->format($reference);
		}
	}

	public function sort($references) {
		usort($references, function($a, $b) {
			$personsA = ApaPersonFormatter::parse($a->getAuthor());
			$personsB = ApaPersonFormatter::parse($b->getAuthor());
			$personsACount = count($personsA);
			$personsBCount = count($personsB);

			if ($personsACount == $personsBCount) {
				$amountCmp = 0;
			} else {
				$amountCmp = $personsACount > $personsBCount ? 1 : -1;
			}

			$getName = function ($person) {
				if (isset($person['name'])) {
					return $person['name'];
				}
				return $person['family'];
			};

			$getSecondName = function ($person) {
				if (isset($person['name'])) {
					return $person['name'];
				}
				return $person['given'];
			};

			$cmp = 0;
			$i = 0;
			do {
				$nameA = $getName($personsA[$i]);
				$nameB = $getName($personsB[$i]);

				$cmp = strnatcasecmp($nameA, $nameB);

				if ($cmp == 0) {
					$nameA = $getSecondName($personsA[$i]);
					$nameB = $getSecondName($personsB[$i]);

					$cmp = strnatcasecmp($nameA, $nameB);

					if ($cmp == 0) {
						$cmp = $amountCmp;
					}
				}
				$i++;
			} while ($cmp == 0 && $i < $personsACount && $i < $personsBCount);

			return $cmp;
		});
		return $references;
	}

}