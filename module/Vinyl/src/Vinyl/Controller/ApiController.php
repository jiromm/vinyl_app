<?php

namespace Vinyl\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Vinyl\Mapper\Fence as FenceMapper;
use Vinyl\Mapper\House as HouseMapper;
use Vinyl\Entity\House as HouseEntity;

class ApiController extends AbstractActionController {
    public function indexAction() {
	    die(json_encode(['fuck off']));
    }

	public function fenceAction() {
		/**
		 * @var FenceMapper $mapper
		 */
		header('Content-Type: application/json');

		$mapper = $this->getServiceLocator()->get('FenceMapper');
		$result = $mapper->fetchAllWithCategory();

		$output = [];

		if ($result->count()) {
			foreach ($result as $item) {
				if (!isset($output[$item->getCategoryId()])) {
					$output[$item->getCategoryId()] = [
						'name' => $item->getCategory(),
						'icon' => [],
						'original' => [],
						'order' => $item->getCategoryOrder(),
					];
				}

				list($width, $height) = getimagesize("./public/upload/fence/{$item->getId()}/big.png");

				$output[$item->getCategoryId()]['fences'][$item->getId()] = [
					'name' => $item->getName(),
					'icon' => HOST . BASE_DIR . "upload/fence/{$item->getId()}/icon.png",
					'original' => HOST . BASE_DIR . "upload/fence/{$item->getId()}/big.png",
					'width' => $width,
					'height' => $height,
				];
			}
		} asort($output, SORT_ASC);

		die(json_encode($output));
	}

	public function houseAction() {
		/**
		 * @var HouseMapper $mapper
		 * @var HouseEntity[]|\ArrayObject $result
		 */
		header('Content-Type: application/json');

		$mapper = $this->getServiceLocator()->get('HouseMapper');
		$result = $mapper->fetchAll();

		$output = [];

		if ($result->count()) {
			foreach ($result as $item) {
				list($width, $height) = getimagesize("./public/upload/house/{$item->getId()}/big.jpeg");

				$output[$item->getId()] = [
					'name' => $item->getName(),
					'icon' => HOST . BASE_DIR . "upload/house/{$item->getId()}/icon.jpeg",
					'original' => HOST . BASE_DIR . "upload/house/{$item->getId()}/big.jpeg",
					'width' => $width,
					'height' => $height,
				];
			}
		}

		die(json_encode($output));
	}
}
