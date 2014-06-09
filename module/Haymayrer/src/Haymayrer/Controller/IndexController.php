<?php

namespace Haymayrer\Controller;

use Haymayrer\Mapper\Permission as PermissionMapper;
use Zend\Authentication\AuthenticationService;
use Zend\Debug\Debug;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController {
    public function indexAction() {
	    /**
	     * @var PermissionMapper $permissionMapper
	     * @var AuthenticationService $auth
	     */
	    $permissionMapper = $this->getServiceLocator()->get('PermissionMapper');
	    $auth = $this->getServiceLocator()->get('auth');
	    $permissionMapper->hasPermission($auth->getIdentity(), \Haymayrer\Constant\Permission::CHILD_VIEW);

        return new ViewModel();
    }
}
