<?php
namespace gossi\trixionary\client\formatter\apa;

class ApaDiplomathesisFormatter extends ApaSchoolFormatter {
	
	protected function getGenre() {
		return $this->labels['diplomathesis'];
	}
}