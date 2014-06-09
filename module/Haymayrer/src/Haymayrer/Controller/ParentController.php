<?php

namespace Haymayrer\Controller;

use Haymayrer\Filter\ParentsFilter;
use Haymayrer\Form\Parents;
use Haymayrer\Entity\Parents as ParentsEntity;
use Haymayrer\Mapper\Parents as ParentsMapper;
use Haymayrer\Mapper\Child as ChildMapper;
use Zend\Debug\Debug;
use Zend\Http\Request;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ParentController extends AbstractActionController {
    public function indexAction() {
	    /**
	     * @var $mapper ParentsMapper
	     */
	    $mapper = $this->getServiceLocator()->get('ParentsMapper');
	    $result = $mapper->fetchAll();

	    return new ViewModel([
		    'data' => $result,
	    ]);
    }

	public function viewAction() {
		$id = $this->params()->fromRoute('id');

		/**
		 * @var $parentMapper ParentsMapper
		 * @var $childMapper ChildMapper
		 */
		$parentMapper = $this->getServiceLocator()->get('ParentsMapper');
		$childMapper = $this->getServiceLocator()->get('ChildMapper');
		$parentResult = $parentMapper->fetchOne([
			'id' => $id,
		]);
		$childrenResult = $childMapper->fetchAll([
			'parent_id' => $id,
		]);

		return new ViewModel([
			'data' => $parentResult,
			'children' => $childrenResult,
		]);
	}

	public function addAction() {
		/**
		 * @var Request $request
		 * @var ParentsMapper $mapper
		 */
		$request = $this->getRequest();

		$parentsForm = new Parents($this->getServiceLocator(), $this->url()->fromRoute('parent-add'));
		$parentsForm->prepare();

		if ($request->isPost()) {
			$parentsForm->setData($request->getPost());

			if ($parentsForm->isValid()) {
				$parentsEntity = new ParentsEntity();
				$parentsEntity->setName($request->getPost('name'));
				$parentsEntity->setBirthday($request->getPost('birthday'));
				$parentsEntity->setRegion($request->getPost('region'));
				$parentsEntity->setDistrict($request->getPost('district'));
				$parentsEntity->setAddress($request->getPost('address'));
				$parentsEntity->setAddressResidence($request->getPost('address_residence'));
				$parentsEntity->setPhone($request->getPost('phone'));
				$parentsEntity->setPhoneAlternative($request->getPost('phone_alternative'));
				$parentsEntity->setDescription($request->getPost('description'));
				$parentsEntity->setSingleMother($request->getPost('single_mother'));
				$parentsEntity->setInNeed($request->getPost('in_need'));
				$parentsEntity->setTimestamp(date('Y-m-d H:i:s'));

				$mapper = $this->getServiceLocator()->get('ParentsMapper');
				$mapper->insert($parentsEntity);

				$this->redirect()->toRoute('parent');
			} else {
				$parentsForm->populateValues($request->getPost());
			}
		}

		return new ViewModel([
			'form' => $parentsForm,
		]);
	}

	public function editAction() {
		/**
		 * @var Request $request
		 * @var ParentsMapper $mapper
		 */
		$request = $this->getRequest();
		$id = $this->params()->fromRoute('id');

		$parentsForm = new Parents($this->getServiceLocator(), $this->url()->fromRoute('parent-edit', [
			'id' => $id,
		]));
		$parentsForm->prepare();

		if ($request->isPost()) {
			$parentsForm->setData($request->getPost());

			if ($parentsForm->isValid()) {
				$parentsEntity = new ParentsEntity();
				$parentsEntity->setName($request->getPost('name'));
				$parentsEntity->setBirthday($request->getPost('birthday'));
				$parentsEntity->setRegion($request->getPost('region'));
				$parentsEntity->setDistrict($request->getPost('district'));
				$parentsEntity->setAddress($request->getPost('address'));
				$parentsEntity->setAddressResidence($request->getPost('address_residence'));
				$parentsEntity->setPhone($request->getPost('phone'));
				$parentsEntity->setPhoneAlternative($request->getPost('phone_alternative'));
				$parentsEntity->setSingleMother($request->getPost('single_mother'));
				$parentsEntity->setInNeed($request->getPost('in_need'));
				$parentsEntity->setDescription($request->getPost('description'));

				$mapper = $this->getServiceLocator()->get('ParentsMapper');
				$mapper->update($parentsEntity, ['id' => $id]);

				$this->redirect()->toRoute('parent');
			} else {
				$parentsForm->populateValues($request->getPost());
			}
		} else {
			$mapper = $this->getServiceLocator()->get('ParentsMapper');
			$result = $mapper->fetchOne([
				'id' => $id,
			]);

			$parentsForm->populateValues($result->exchangeArray());
		}

		return new ViewModel([
			'form' => $parentsForm,
		]);
	}

	public function deleteAction() {
		/** @todo: parent cannot be deleted if one has a child  */

		$id = $this->params()->fromRoute('id');

		/**
		 * @var $mapper ParentsMapper
		 */
		$mapper = $this->getServiceLocator()->get('ParentsMapper');
		$mapper->delete([
			'id' => $id,
		]);

		$this->redirect()->toRoute('parent');

		return new ViewModel([
			'id' => $this->params()->fromRoute('id'),
		]);
	}
}
