<?php

namespace Haymayrer\Form;

use Haymayrer\Constant\DBData;
use Haymayrer\Filter\ChildFilter;
use Haymayrer\Helper\ParentsHelper;
use Zend\Authentication\Adapter\DbTable;
use Zend\Debug\Debug;
use Zend\Form\Form;
use Zend\ServiceManager\ServiceLocatorInterface;
use Haymayrer\Mapper\Parents as ParentsMapper;

class Child extends Form {
	/**
	 * @param ServiceLocatorInterface $sm
	 * @param string $action
	 */
	public function __construct($sm, $action) {
		parent::__construct('child');

		$this->setAttribute('action', $action);
		$this->setAttribute('method', 'post');
		$this->setAttribute('class', 'form-horizontal child-form');
		$this->setInputFilter(new ChildFilter());

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

		/** @var ParentsMapper $childMapper */
		$parentsMapper = $sm->get('ParentsMapper');
		$parents = $parentsMapper->fetchAll();

		$this->add([
			'name' => 'parent_id',
			'type' => 'Zend\Form\Element\Select',
			'attributes' => [
				'class' => 'form-control selectize-simple',
				'id' => 'parent_id',
			],
			'options' => [
				'value_options' => ParentsHelper::reconstructList($parents),
			],
		]);

		$this->add([
			'name' => 'disease',
			'type' => 'Zend\Form\Element\Select',
			'attributes' => [
				'class' => 'form-control selectize-simple',
				'id' => 'disease',
			],
			'options' => [
				'value_options' => DBData::getDiseases(),
			],
		]);

		$this->add([
			'name' => 'birthday',
			'attributes' => [
				'type' => 'date',
				'class' => 'form-control',
				'id' => 'birthday',
			],
		]);

		$this->add([
			'name' => 'description',
			'type' => 'Zend\Form\Element\Textarea',
			'attributes' => [
				'class' => 'form-control',
				'id' => 'description',
				'rows' => '5',
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
