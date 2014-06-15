<?php

namespace Vinyl\Form;

use Vinyl\Filter\FenceFilter;
use Vinyl\Mapper\Category;
use Vinyl\Entity\Category as CategoryEntity;
use Zend\Authentication\Adapter\DbTable;
use Zend\Debug\Debug;
use Zend\Form\Form;
use Zend\ServiceManager\ServiceLocatorInterface;

class Fence extends Form {
	protected $categories = [];

	/**
	 * @param ServiceLocatorInterface $sm
	 * @param string $action
	 */
	public function __construct($sm, $action) {
		parent::__construct('fence');

		$this->setAttribute('action', $action);
		$this->setAttribute('method', 'post');
		$this->setAttribute('class', 'form-horizontal fence-form');
		$this->setInputFilter(new FenceFilter());

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
			'name' => 'category_id',
			'type' => 'Zend\Form\Element\Select',
			'attributes' => [
				'class' => 'form-control',
				'id' => 'category_id',
			],
			'options' => [
				'value_options' => $this->getCategories($sm),
			],
		]);

		$this->add(array(
			'name' => 'image',
			'type' => 'Zend\Form\Element\File',
			'attributes' => array(
				'class' => 'form-control',
				'accept' => 'image/png',
			),
		));

		$this->add(array(
			'name' => 'icon',
			'type' => 'Zend\Form\Element\File',
			'attributes' => array(
				'class' => 'form-control',
				'accept' => 'image/png',
			),
		));

		$this->add([
			'name' => 'submit',
			'attributes' => [
				'type' => 'submit',
				'value' => 'Submit',
				'class' => 'btn btn-lg btn-primary btn-block',
			],
		]);
	}

	/**
	 * @return array
	 */
	public function isAvailable() {
		return $this->categories;
	}

	/**
	 * @param ServiceLocatorInterface $sm
	 * @return array
	 */
	protected function getCategories($sm) {
		/**
		 * @var Category $categoryMapper
		 * @var CategoryEntity[]|\ArrayObject $categories
		 */
		$categoryMapper = $sm->get('CategoryMapper');
		$categories = $categoryMapper->fetchAll();
		$this->categories = [];

		if ($categories->count()) {
			foreach ($categories as $category) {
				$this->categories[$category->getId()] = $category->getName();
			}
		}

		return $this->categories;
	}
}
