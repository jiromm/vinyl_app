<?php

namespace Vinyl\Filter;

use Zend\InputFilter\InputFilter;

class ParentsFilter extends InputFilter {
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
			'name' => 'birthday',
			'required' => false,
		]);

		$this->add([
			'name' => 'region',
			'required' => false,
		]);

		$this->add([
			'name' => 'district',
			'required' => false,
		]);

		$this->add([
			'name' => 'address',
			'required' => false,
		]);

		$this->add([
			'name' => 'address_residence',
			'required' => false,
		]);

		$this->add([
			'name' => 'phone',
			'required' => true,
		]);

		$this->add([
			'name' => 'phone_alternative',
			'required' => false,
		]);

		$this->add([
			'name' => 'single_mother',
			'required' => false,
		]);

		$this->add([
			'name' => 'in_need',
			'required' => false,
		]);

		$this->add([
			'name' => 'description',
			'required' => false,
		]);
	}
}
