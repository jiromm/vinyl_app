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
	    $result = $mapper->fetchAllWithCategory();

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
				$dir = './public/upload/fence/' . $lastInsertId;

				if (!is_dir($dir)) {
					if (!mkdir($dir, 777, true)) {
						throw new \Exception('Cannot create directory: ' . $dir);
					}
				}

				if ($_FILES['image']['name']) {
					if (!$_FILES['image']['error']) {
						$newFileName = $dir . '/big.png';

						if ($_FILES['image']['size'] > (1024000)) {
							$error = 'Oops! Your file\'s size is to large.';
						} else {
							if (in_array(strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION)), ['png'])) {
								move_uploaded_file($_FILES['image']['tmp_name'], $newFileName);
							} else {
								$error = 'Ooops! PNG please.';
							}
						}
					} else {
						$error = 'Ooops! Your upload triggered the following error: ' . $_FILES['image']['error'];
					}
				}

				if ($_FILES['icon']['name']) {
					if (!$_FILES['icon']['error']) {
						$newFileName = $dir . '/icon.png';

						if ($_FILES['icon']['size'] > (1024000)) {
							$error = 'Oops! Your file\'s size is to large.';
						} else {
							if (in_array(strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION)), ['png'])) {
								move_uploaded_file($_FILES['icon']['tmp_name'], $newFileName);
							} else {
								$error = 'Ooops! PNG please.';
							}
						}
					} else {
						$error = 'Ooops! Your upload triggered the following error: ' . $_FILES['icon']['error'];
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
				$dir = './public/upload/fence/' . $lastInsertId;

				if (!is_dir($dir)) {
					if (!mkdir($dir, 777, true)) {
						throw new \Exception('Cannot create directory: ' . $dir);
					}
				}

				if ($_FILES['image']['name']) {
					if (!$_FILES['image']['error']) {
						$newFileName = $dir . '/big.png';

						if ($_FILES['image']['size'] > (1024000)) {
							$error = 'Oops! Your file\'s size is to large.';
						} else {
							if (in_array(strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION)), ['png'])) {
								move_uploaded_file($_FILES['image']['tmp_name'], $newFileName);
							} else {
								$error = 'Ooops! PNG please.';
							}
						}
					} else {
						$error = 'Ooops! Your upload triggered the following error: ' . $_FILES['image']['error'];
					}
				}

				if ($_FILES['icon']['name']) {
					if (!$_FILES['icon']['error']) {
						$newFileName = $dir . '/icon.png';

						if ($_FILES['icon']['size'] > (1024000)) {
							$error = 'Oops! Your file\'s size is to large.';
						} else {
							if (in_array(strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION)), ['png'])) {
								move_uploaded_file($_FILES['icon']['tmp_name'], $newFileName);
							} else {
								$error = 'Ooops! PNG please.';
							}
						}
					} else {
						$error = 'Ooops! Your upload triggered the following error: ' . $_FILES['icon']['error'];
					}
				}
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
