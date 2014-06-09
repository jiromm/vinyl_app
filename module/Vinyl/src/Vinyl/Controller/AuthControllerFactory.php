<?php

namespace Vinyl\Controller;

use Vinyl\Form\Login;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class AuthControllerFactory implements FactoryInterface {
	public function createService(ServiceLocatorInterface $serviceLocator) {
		$controller = new AuthController();
		$controller->setLoginForm(new Login());
		$controller->setAuthService(
			$serviceLocator->getServiceLocator()->get('auth')
		);

		return $controller;
	}
}
