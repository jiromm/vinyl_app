<?php

namespace Vinyl\Controller;

use Vinyl\Mapper\Permission as PermissionMapper;
use Zend\Authentication\AuthenticationService;
use Zend\Debug\Debug;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController {
    public function indexAction() {
        return new ViewModel();
    }
}
