<?php

namespace Vinyl\Controller;

use Vinyl\Filter\CategoryFilter;
use Vinyl\Form\Category;
use Vinyl\Mapper\Category as CategoryMapper;
use Vinyl\Entity\Category as CategoryEntity;
use Zend\Debug\Debug;
use Zend\Http\Request;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class HouseController extends AbstractActionController {
    public function indexAction() {
	    /**
	     * @var CategoryMapper $mapper
	     */
	    $mapper = $this->getServiceLocator()->get('CategoryMapper');
	    $result = $mapper->fetchAll();

	    return new ViewModel([
		    'data' => $result,
	    ]);
    }

	public function addAction() {
		/**
		 * @var Request $request
		 * @var CategoryMapper $mapper
		 */
		$request = $this->getRequest();

		$categoryForm = new Category($this->getServiceLocator(), $this->url()->fromRoute('category/add'));
		$categoryForm->prepare();

		if ($request->isPost()) {
			$categoryForm->setData($request->getPost());

			if ($categoryForm->isValid()) {
				$categoryEntity = new CategoryEntity();
				$categoryEntity->setName($request->getPost('name'));

				$mapper = $this->getServiceLocator()->get('CategoryMapper');
				$mapper->insert($categoryEntity);

				$this->redirect()->toRoute('category');
			} else {
				$categoryForm->populateValues($request->getPost());
			}
		}

		return new ViewModel([
			'form' => $categoryForm,
		]);
	}

	public function editAction() {
		/**
		 * @var Request $request
		 * @var CategoryMapper $mapper
		 */
		$request = $this->getRequest();
		$id = $this->params()->fromRoute('id');

		$categoryForm = new Category($this->getServiceLocator(), $this->url()->fromRoute('category/edit', [
			'id' => $id,
		]));
		$categoryForm->prepare();

		if ($request->isPost()) {
			$categoryForm->setData($request->getPost());

			if ($categoryForm->isValid()) {
				$categoryEntity = new CategoryEntity();
				$categoryEntity->setName($request->getPost('name'));

				$mapper = $this->getServiceLocator()->get('CategoryMapper');
				$mapper->update($categoryEntity, ['id' => $id]);

				$this->redirect()->toRoute('category');
			} else {
				$categoryForm->populateValues($request->getPost());
			}
		} else {
			$mapper = $this->getServiceLocator()->get('CategoryMapper');
			$result = $mapper->fetchOne([
				'id' => $id,
			]);

			$categoryForm->populateValues($result->exchangeArray());
		}

		return new ViewModel([
			'form' => $categoryForm,
		]);
	}

	public function deleteAction() {
		$id = $this->params()->fromRoute('id');

		/**
		 * @var CategoryMapper $mapper
		 */
		$mapper = $this->getServiceLocator()->get('CategoryMapper');
		$mapper->delete([
			'id' => $id,
		]);

		$this->redirect()->toRoute('category');

		return new ViewModel([
			'id' => $this->params()->fromRoute('id'),
		]);
	}
}
