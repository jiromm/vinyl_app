<?php

namespace Haymayrer\Form;

use Haymayrer\Constant\DBData;
use Haymayrer\Filter\ParentsFilter;
use Zend\Form\Form;
use Zend\ServiceManager\ServiceLocatorInterface;

class Parents extends Form {
	/**
	 * @param ServiceLocatorInterface $sm
	 * @param string $action
	 */
	public function __construct($sm, $action) {
		parent::__construct('parents');

		$this->setAttribute('action', $action);
		$this->setAttribute('method', 'post');
		$this->setAttribute('class', 'form-horizontal parents-form');
		$this->setInputFilter(new ParentsFilter());

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
			'name' => 'birthday',
			'attributes' => [
				'type' => 'date',
				'class' => 'form-control',
				'id' => 'birthday',
			],
		]);

		$this->add([
			'name' => 'region',
			'type' => 'Zend\Form\Element\Select',
			'attributes' => [
				'class' => 'form-control selectize-simple',
				'id' => 'region',
			],
			'options' => [
				'value_options' => DBData::getRegions(),
			],
		]);

		$this->add([
			'name' => 'district',
			'type' => 'Zend\Form\Element\Select',
			'attributes' => [
				'class' => 'form-control selectize-simple',
				'id' => 'district',
			],
			'options' => [
				'value_options' => DBData::getDistricts(),
			],
		]);

		$this->add([
			'name' => 'address',
			'attributes' => [
				'class' => 'form-control',
				'id' => 'address',
			],
		]);

		$this->add([
			'name' => 'address_residence',
			'attributes' => [
				'class' => 'form-control',
				'id' => 'address_residence',
			],
		]);

		$this->add([
			'name' => 'phone',
			'attributes' => [
				'class' => 'form-control',
				'id' => 'phone',
				'required' => 'required',
			],
		]);

		$this->add([
			'name' => 'phone_alternative',
			'attributes' => [
				'class' => 'form-control',
				'id' => 'phone_alternative',
			],
		]);

		$this->add([
			'name' => 'single_mother',
			'type' => 'Zend\Form\Element\Checkbox',
			'attributes' => [
				'class' => 'form-control',
				'id' => 'single_mother',
			],
			'options' => [
				'use_hidden_element' => true,
				'checked_value' => '1',
				'unchecked_value' => '0',
			],
		]);

		$this->add([
			'name' => 'in_need',
			'type' => 'Zend\Form\Element\Checkbox',
			'attributes' => [
				'class' => 'form-control',
				'id' => 'in_need',
			],
			'options' => [
				'use_hidden_element' => true,
				'checked_value' => '1',
				'unchecked_value' => '0',
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
