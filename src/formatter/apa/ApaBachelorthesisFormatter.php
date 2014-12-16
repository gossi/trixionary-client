<?php
namespace gossi\trixionary\client\formatter\apa;

class ApaBachelorthesisFormatter extends ApaSchoolFormatter {
	
	protected function getGenre() {
		return $this->labels['bachelorthesis'];
	}
}