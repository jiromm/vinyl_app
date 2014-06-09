<?php

namespace Vinyl;

use Vinyl\View\Helper\HasRoleHelper;
use Vinyl\View\Helper\IdentityHelper;
use Zend\Authentication\AuthenticationService;
use Zend\Debug\Debug;
use Zend\Http\Request;
use Zend\ModuleManager\ModuleEvent;
use Zend\ModuleManager\ModuleManager;
use Zend\Mvc\Application;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\RouteMatch;
use Zend\Mvc\Service\RouterFactory;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class Module {
	public function init(ModuleManager $moduleManager) {

	}

    public function onBootstrap(MvcEvent $e) {
	    /**
	     * @var Application $app
	     * @var RouteMatch $routeMatch
	     * @var AuthenticationService $authService
	     */
        $eventManager = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

	    $app = $e->getApplication();
	    $authService = $app->getServiceManager()->get('auth');

	    $e->getApplication()->getEventManager()->getSharedManager()->attach('Zend\Mvc\Controller\AbstractActionController', 'dispatch', function (MvcEvent $e) use ($authService) {
		    $controller = $e->getTarget();
		    $routeMatch = $e->getRouteMatch();
		    $routeMatch->getMatchedRouteName();

		    if (!$authService->hasIdentity() && $routeMatch->getMatchedRouteName() != 'login') {
			    $controller->plugin('redirect')->toRoute('login');
		    }
	    }, 100);
    }

    public function getConfig() {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig() {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

	public function getViewHelperConfig() {
		return array(
			'invokables' => array(
				'required' => 'Haymayrer\View\Helper\RequiredHelper',
			),
			'factories' => array(
				'ident' => function($sm) {
					/** @var ServiceLocatorAwareInterface $sm */
					return new IdentityHelper(
						$sm->getServiceLocator()->get('auth')
					);
				},
				'hasRole' => function($sm) {
					/** @var ServiceLocatorAwareInterface $sm */
					return new HasRoleHelper($sm);
				},
			)
		);
	}
}
