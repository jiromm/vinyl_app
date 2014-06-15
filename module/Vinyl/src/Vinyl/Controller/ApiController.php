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

class ApiController extends AbstractActionController {
    public function indexAction() {
	    return new ViewModel();
    }

	public function fenceAction() {
		return new ViewModel();
	}

	public function houseAction() {
		return new ViewModel();
	}
}
