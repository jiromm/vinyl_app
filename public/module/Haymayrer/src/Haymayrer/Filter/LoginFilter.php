<?php

namespace Haymayrer\Filter;

use Zend\InputFilter\InputFilter;

class LoginFilter extends InputFilter {
	public function __construct() {
		$this->add([
			'name' => 'username',
			'required' => true
		]);

		$this->add([
			'name' => 'password',
			'required' => true
		]);
	}
}
