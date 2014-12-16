<?php
namespace gossi\trixionary\client\formatter\apa;

class ApaHabilitationthesisFormatter extends ApaSchoolFormatter {
	
	protected function getGenre() {
		return $this->labels['habilitationthesis'];
	}
}