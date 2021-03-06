<?php

namespace Vinyl\Filter;

use Zend\InputFilter\InputFilter;

class FenceFilter extends InputFilter {
	public function __construct() {
		$this->add([
			'name' => 'name',
			'required' => true,
		]);

		$this->add([
			'name' => 'category_id',
			'required' => true,
		]);

		$this->add([
			'name' => 'image',
			'required' => false,
		]);

		$this->add([
			'name' => 'icon',
			'required' => false,
		]);
	}
}
