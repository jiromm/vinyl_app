<?php

namespace Haymayrer\Filter;

use Zend\InputFilter\InputFilter;

class ChildFilter extends InputFilter {
	public function __construct() {
		$this->add([
			'name' => 'id',
			'required' => false,
		]);

		$this->add([
			'name' => 'name',
			'required' => true,
		]);

		$this->add([
			'name' => 'parent_id',
			'required' => true,
		]);

		$this->add([
			'name' => 'disease',
			'required' => true,
		]);

		$this->add([
			'name' => 'birthday',
			'required' => false,
		]);

		$this->add([
			'name' => 'description',
			'required' => false,
		]);
	}
}
