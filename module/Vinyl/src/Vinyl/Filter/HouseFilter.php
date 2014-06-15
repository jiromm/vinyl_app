<?php

namespace Vinyl\Filter;

use Zend\InputFilter\InputFilter;

class HouseFilter extends InputFilter {
	public function __construct() {
		$this->add([
			'name' => 'name',
			'required' => true,
		]);

		$this->add([
			'name' => 'image',
			'required' => false,
		]);
	}
}
