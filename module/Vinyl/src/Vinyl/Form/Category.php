<?php

namespace Vinyl\Form;

use Vinyl\Constant\DBData;
use Vinyl\Filter\CategoryFilter;
use Zend\Authentication\Adapter\DbTable;
use Zend\Debug\Debug;
use Zend\Form\Form;
use Zend\ServiceManager\ServiceLocatorInterface;
use Vinyl\Mapper\Category as CategoryMapper;

class Category extends Form {
	/**
	 * @param ServiceLocatorInterface $sm
	 * @param string $action
	 */
	public function __construct($sm, $action) {
		parent::__construct('child');

		$this->setAttribute('action', $action);
		$this->setAttribute('method', 'post');
		$this->setAttribute('class', 'form-horizontal child-form');
		$this->setInputFilter(new CategoryFilter());

		$this->add([
			'name' => 'name',
			'attributes' => [
				'type' => 'text',
				'class' => 'form-control',
				'id' => 'name',
				'autofocus' => true,
				'required' => 'required',
			],
		]);

		$this->add([
			'name' => 'submit',
			'attributes' => [
				'type' => 'submit',
				'value' => 'Submit',
				'class' => 'btn btn-lg btn-primary btn-block',
			],
		]);
	}
}
