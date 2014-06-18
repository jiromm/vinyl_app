<?php

namespace Vinyl\Filter;

use Zend\InputFilter\InputFilter;

class CategoryFilter extends InputFilter {
	public function __construct() {
		$this->add([
			'name' => 'name',
			'required' => true,
		]);

		$this->add([
			'name' => 'order',
			'required' => true,
		]);
	}
}
