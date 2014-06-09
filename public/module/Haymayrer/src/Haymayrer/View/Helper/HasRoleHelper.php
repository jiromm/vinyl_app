<?php

namespace Haymayrer\View\Helper;

use Zend\Authentication\AuthenticationService;
use Zend\Form\View\Helper\AbstractHelper;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Haymayrer\Mapper\Permission as PermissionMapper;

class HasRoleHelper extends AbstractHelper {
	/**
	 * @var AuthenticationService $auth
	 */
	protected $auth;

	/**
	 * @var PermissionMapper $permissionMapper
	 */
	protected $permissionMapper;

	/**
	 * @param ServiceLocatorAwareInterface $sm
	 */
	public function __construct($sm) {
		$this->auth = $sm->getServiceLocator()->get('auth');
		$this->permissionMapper = $sm->getServiceLocator()->get('PermissionMapper');
	}

	public function __invoke($permissionId) {
		return $this->permissionMapper->hasPermission($this->auth->getIdentity(), $permissionId);
	}
}
