<?php
namespace gossi\trixionary\client\formatter\apa;

class ApaMastherthesisFormatter extends ApaSchoolFormatter {
	
	protected function getGenre() {
		return $this->labels['masterthesis'];
	}
}