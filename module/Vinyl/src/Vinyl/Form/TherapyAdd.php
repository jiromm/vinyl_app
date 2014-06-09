<?php

namespace Vinyl\Form;

use Vinyl\Filter\TherapyAddFilter;
use Zend\Authentication\Adapter\DbTable;
use Zend\ServiceManager\ServiceLocatorInterface;

class TherapyAdd extends TherapyEdit {
	/**
	 * @param ServiceLocatorInterface $sm
	 * @param string $action
	 */
	public function __construct($sm, $action) {
		parent::__construct($sm, $action);

		$this->setInputFilter(new TherapyAddFilter());

		$this->add([
			'name' => 'participants',
			'type' => 'Zend\Form\Element\Select',
			'attributes' => [
				'class' => 'form-control selectize-children-list',
				'id' => 'participants',
				'multiple' => 'multiple',
			],
		]);
	}
}
