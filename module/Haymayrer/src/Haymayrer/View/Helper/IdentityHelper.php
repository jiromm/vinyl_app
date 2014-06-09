<?php

namespace Haymayrer\View\Helper;

use Zend\Form\View\Helper\AbstractHelper;

class IdentityHelper extends AbstractHelper {
	protected $identity;

	public function __construct($has) {
		$this->identity = $has->hasIdentity();
	}

	public function __invoke() {
		return $this->identity;
	}
}
