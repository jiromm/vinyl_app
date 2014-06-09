<?php

namespace Haymayrer\Filter;

class TherapyAddFilter extends TherapyEditFilter {
	public function __construct() {
		parent::__construct();

		$this->add([
			'name' => 'participants',
			'required' => true,
		]);
	}
}
