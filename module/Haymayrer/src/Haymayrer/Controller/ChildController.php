<?php

namespace Haymayrer\Controller;

use Haymayrer\Filter\ChildFilter;
use Haymayrer\Filter\ParentsFilter;
use Haymayrer\Form\Child;
use Haymayrer\Entity\Child as ChildEntity;
use Haymayrer\Mapper\Child as ChildMapper;
use Haymayrer\Mapper\Parents as ParentsMapper;
use Zend\Debug\Debug;
use Zend\Http\Request;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ChildController extends AbstractActionController {
    public function indexAction() {
	    /**
	     * @var ChildMapper $mapper
	     */
	    $mapper = $this->getServiceLocator()->get('ChildMapper');
	    $result = $mapper->fetchAllWithParent();

	    return new ViewModel([
		    'data' => $result,
	    ]);
    }

	public function viewAction() {
		$id = $this->params()->fromRoute('id');

		/**
		 * @var ChildMapper $mapper
		 */
		$mapper = $this->getServiceLocator()->get('ChildMapper');
		$result = $mapper->fetchOneWithParent([
			'child.id' => $id,
		]);

		return new ViewModel([
			'data' => $result,
		]);
	}

	public function addAction() {
		/**
		 * @var Request $request
		 * @var ChildMapper $mapper
		 */
		$request = $this->getRequest();

		$childForm = new Child($this->getServiceLocator(), $this->url()->fromRoute('child-add'));
		$childForm->prepare();

		if ($request->isPost()) {
			$childForm->setData($request->getPost());

			if ($childForm->isValid()) {
				$childEntity = new ChildEntity();
				$childEntity->setName($request->getPost('name'));
				$childEntity->setParentId($request->getPost('parent_id'));
				$childEntity->setDisease($request->getPost('disease'));
				$childEntity->setBirthday($request->getPost('birthday'));
				$childEntity->setDescription($request->getPost('description'));
				$childEntity->setTimestamp(date('Y-m-d H:i:s'));

				$mapper = $this->getServiceLocator()->get('ChildMapper');
				$mapper->insert($childEntity);

				$this->redirect()->toRoute('child');
			} else {
				$childForm->populateValues($request->getPost());
			}
		}

		return new ViewModel([
			'form' => $childForm,
		]);
	}

	public function editAction() {
		/**
		 * @var Request $request
		 * @var ChildMapper $mapper
		 */
		$request = $this->getRequest();
		$id = $this->params()->fromRoute('id');

		$childForm = new Child($this->getServiceLocator(), $this->url()->fromRoute('child-edit', [
			'id' => $id,
		]));
		$childForm->prepare();

		if ($request->isPost()) {
			$childForm->setData($request->getPost());

			if ($childForm->isValid()) {
				$childEntity = new ChildEntity();
				$childEntity->setName($request->getPost('name'));
				$childEntity->setParentId($request->getPost('parent_id'));
				$childEntity->setBirthday($request->getPost('birthday'));
				$childEntity->setDisease($request->getPost('disease'));
				$childEntity->setDescription($request->getPost('description'));

				$mapper = $this->getServiceLocator()->get('ChildMapper');
				$mapper->update($childEntity, ['id' => $id]);

				$this->redirect()->toRoute('child');
			} else {
				$childForm->populateValues($request->getPost());
			}
		} else {
			$mapper = $this->getServiceLocator()->get('ChildMapper');
			$result = $mapper->fetchOne([
				'id' => $id,
			]);

			$childForm->populateValues($result->exchangeArray());
		}

		return new ViewModel([
			'form' => $childForm,
		]);
	}

	public function deleteAction() {
		$id = $this->params()->fromRoute('id');

		/**
		 * @var $mapper ChildMapper
		 */
		$mapper = $this->getServiceLocator()->get('ChildMapper');
		$mapper->delete([
			'id' => $id,
		]);

		$this->redirect()->toRoute('child');

		return new ViewModel([
			'id' => $this->params()->fromRoute('id'),
		]);
	}
}
