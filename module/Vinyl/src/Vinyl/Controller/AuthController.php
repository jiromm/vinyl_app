<?php

namespace Vinyl\Controller;

use Zend\Debug\Debug;
use Zend\Form\View\Helper\Captcha\Dumb;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class AuthController extends AbstractActionController {
	private $loginForm;
	private $authService;

	public function loginAction() {
		if ($this->authService->hasIdentity()) {
			return $this->redirect()->toUrl('/');
		}

		if (!$this->loginForm) {
			throw new \BadMethodCallException('Login form not yet set');
		}

		if (!$this->authService) {
			throw new \BadMethodCallException('Auth service not yet set');
		}

		if ($this->getRequest()->isPost()) {
			$this->loginForm->setData($this->getRequest()->getPost());

			if ($this->loginForm->isValid()) {
				$data = $this->loginForm->getData();

				$this->authService->getAdapter()->setIdentity($data['username']);
				$this->authService->getAdapter()->setCredential($data['password']);

				$authResult = $this->authService->authenticate();

				if (!$authResult->isValid()) {
					return new ViewModel([
						'form' => $this->loginForm,
						'loginError' => true,
					]);
				} else {
					return $this->redirect()->toUrl('/');
				}
			}
		}

		return new ViewModel([
			'form' => $this->loginForm,
		]);
	}

	public function logoutAction() {
		if ($this->authService->hasIdentity()) {
			$this->authService->clearIdentity();
		}

		return $this->redirect()->toUrl('/');
	}

	public function setLoginForm($loginForm) {
		$this->loginForm = $loginForm;
	}

	public function getLoginForm() {
		return $this->loginForm;
	}

	public function setAuthService($authService) {
		$this->authService = $authService;
	}

	public function getAuthService() {
		return $this->authService;
	}
}
