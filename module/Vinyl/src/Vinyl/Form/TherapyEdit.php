<?php

namespace Vinyl\Form;

use Vinyl\Constant\DBData;
use Vinyl\Filter\TherapyEditFilter;
use Zend\Authentication\Adapter\DbTable;
use Zend\Form\Form;
use Zend\ServiceManager\ServiceLocatorInterface;

class TherapyEdit extends Form {
	/**
	 * @param ServiceLocatorInterface $sm
	 * @param string $action
	 */
	public function __construct($sm, $action) {
		parent::__construct('therapy');

		$this->setAttribute('action', $action);
		$this->setAttribute('method', 'post');
		$this->setAttribute('class', 'form-horizontal therapy-form');
		$this->setInputFilter(new TherapyEditFilter());

		$this->add([
			'name' => 'therapy_id',
			'type' => 'Zend\Form\Element\Select',
			'attributes' => [
				'class' => 'form-control selectize-simple',
				'id' => 'therapy_id',
			],
			'options' => [
				'value_options' => DBData::getTherapies(),
			],
		]);

		$this->add([
			'name' => 'date_from',
			'attributes' => [
				'type' => 'date',
				'class' => 'form-control',
				'id' => 'date_from',
				'autofocus' => true,
				'required' => 'required',
			],
		]);

		$this->add([
			'name' => 'date_to',
			'attributes' => [
				'type' => 'date',
				'class' => 'form-control',
				'id' => 'date_to',
				'autofocus' => true,
				'required' => 'required',
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
