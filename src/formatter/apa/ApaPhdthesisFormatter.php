<?php
namespace gossi\trixionary\client\formatter\apa;

class ApaPhdthesisFormatter extends ApaSchoolFormatter {
	
	protected function getGenre() {
		return $this->labels['phdthesis'];
	}
}