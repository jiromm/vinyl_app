<?php

namespace Vinyl\Filter;

use Zend\InputFilter\InputFilter;

class TherapyEditFilter extends InputFilter {
	public function __construct() {
		$this->add([
			'name' => 'id',
			'required' => false,
		]);

		$this->add([
			'name' => 'therapy_id',
			'required' => true,
		]);

		$this->add([
			'name' => 'date_from',
			'required' => true,
		]);

		$this->add([
			'name' => 'date_to',
			'required' => true,
		]);

		$this->add([
			'name' => 'participants',
			'required' => false,
		]);

		$this->add([
			'name' => 'description',
			'required' => false,
		]);
	}
}
