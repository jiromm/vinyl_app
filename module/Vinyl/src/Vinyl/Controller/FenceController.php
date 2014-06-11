<?php

namespace Vinyl\Controller;

use Vinyl\Filter\FenceFilter;
use Vinyl\Form\Fence;
use Vinyl\Mapper\Fence as FenceMapper;
use Vinyl\Entity\Fence as FenceEntity;
use Zend\Debug\Debug;
use Zend\File\Transfer\Adapter\Http;
use Zend\Http\Request;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Validator\File\Extension;
use Zend\Validator\File\IsImage;
use Zend\Validator\File\Size;
use Zend\View\Model\ViewModel;

class FenceController extends AbstractActionController {
    public function indexAction() {
	    /**
	     * @var FenceMapper $mapper
	     */
	    $mapper = $this->getServiceLocator()->get('FenceMapper');
	    $result = $mapper->fetchAll();

	    return new ViewModel([
		    'data' => $result,
	    ]);
    }

	public function addAction() {
		/**
		 * @var Request $request
		 * @var FenceMapper $mapper
		 */
		$request = $this->getRequest();

		$fenceForm = new Fence($this->getServiceLocator(), $this->url()->fromRoute('fence/add'));
		$fenceForm->prepare();

		if ($request->isPost()) {
			$post = array_merge_recursive(
				$request->getPost()->toArray(),
				$request->getFiles()->toArray()
			);

			$fenceForm->setData($post);

			if ($fenceForm->isValid()) {
				$fenceEntity = new FenceEntity();
				$fenceEntity->setName($request->getPost('name'));
				$fenceEntity->setCategoryId($request->getPost('category_id'));

				$mapper = $this->getServiceLocator()->get('FenceMapper');
				$mapper->insert($fenceEntity);

				$lastInsertId = $mapper->lastInsertValue;

				$size = new Size([
					'min' => 20,
					'max' => 2000000,
				]);
				$extension = new Extension(['extension' => ['jpg', 'jpeg']]);
				$isImage = new IsImage();

				$adapter = new Http();
				$adapter->setValidators([$size], $post['image']['size']);
				$adapter->setValidators([$extension], $post['image']['name']);
				$adapter->setValidators([$isImage], $post['image']['type']);

				if (!$adapter->isValid()){
					$dataError = $adapter->getMessages();
					$error = [];

					foreach($dataError as $key => $row) {
						$error[] = $row;
					}

					$fenceForm->setMessages(['image' => $error]);
				} else {
					$dir = './public/upload/fence/' . $lastInsertId;
					$filename = 'big.jpeg';

					if (!mkdir($dir, 777, true)) {
						throw new \Exception('Cannot create directory: ' . $dir);
					}

					$adapter->setDestination($dir);
					$adapter->addFilter('Rename', $dir .'/' . $filename, $post['image']['name']);

					if (!$adapter->receive($post['image']['name'])) {
						throw new \Exception('Cannot create big image: ' . $filename);
					}
				}

				$this->redirect()->toRoute('fence');
			} else {
				$error = $fenceForm->getMessages();
				$fenceForm->populateValues($request->getPost());
			}
		}

		return new ViewModel([
			'form' => $fenceForm,
			'available' => $fenceForm->isAvailable(),
			'error' => isset($error) ? $error : false,
		]);
	}

	public function editAction() {
		/**
		 * @var Request $request
		 * @var FenceMapper $mapper
		 */
		$request = $this->getRequest();
		$id = $this->params()->fromRoute('id');

		$fenceForm = new Fence($this->getServiceLocator(), $this->url()->fromRoute('fence/edit', [
			'id' => $id,
		]));
		$fenceForm->prepare();

		if ($request->isPost()) {
			$post = array_merge_recursive(
				$request->getPost()->toArray(),
				$request->getFiles()->toArray()
			);

			$fenceForm->setData($post);

			if ($fenceForm->isValid()) {
				$fenceEntity = new FenceEntity();
				$fenceEntity->setName($request->getPost('name'));

				$mapper = $this->getServiceLocator()->get('FenceMapper');
				$mapper->update($fenceEntity, ['id' => $id]);

				$lastInsertId = $id;

				$size = new Size([
					'min' => 20,
					'max' => 2000000,
				]);
				$extension = new Extension(['extension' => ['jpg', 'jpeg']]);
				$isImage = new IsImage();

				$adapter = new Http();
				$adapter->setValidators([$size], $post['image']['size']);
				$adapter->setValidators([$extension], $post['image']['name']);
				$adapter->setValidators([$isImage], $post['image']['type']);

				if (!$adapter->isValid()){
					$dataError = $adapter->getMessages();
					$error = [];

					foreach($dataError as $key => $row) {
						$error[] = $row;
					}

					$fenceForm->setMessages(['image' => $error]);
				} else {
					$dir = './public/upload/fence/' . $lastInsertId;
					$filename = 'big.jpeg';

					if (!is_dir($dir)) {
						if (!mkdir($dir, 777, true)) {
							throw new \Exception('Cannot create directory: ' . $dir);
						}
					}

					unlink($dir .'/' . $filename);

					$adapter->setDestination($dir);
					$adapter->addFilter('Rename', $dir .'/' . $filename, $post['image']['name']);

					if (!$adapter->receive($post['image']['name'])) {
						throw new \Exception('Cannot create big image: ' . $filename);
					}
				}

				$this->redirect()->toRoute('fence');
			} else {
				$error = $fenceForm->getMessages();
				$fenceForm->populateValues($request->getPost());
			}
		} else {
			$mapper = $this->getServiceLocator()->get('FenceMapper');
			$result = $mapper->fetchOne([
				'id' => $id,
			]);

			$fenceForm->populateValues($result->exchangeArray());
		}

		return new ViewModel([
			'form' => $fenceForm,
			'error' => isset($error) ? $error : false,
			'id' => $id,
		]);
	}

	public function deleteAction() {
		$id = $this->params()->fromRoute('id');

		/**
		 * @var FenceMapper $mapper
		 */
		$mapper = $this->getServiceLocator()->get('FenceMapper');
		$mapper->delete([
			'id' => $id,
		]);

		$this->redirect()->toRoute('fence');

		return new ViewModel([
			'id' => $this->params()->fromRoute('id'),
		]);
	}
}
