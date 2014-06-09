<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

use Zend\Mvc\Router\Http\Literal;
use Zend\Mvc\Router\Http\Segment;

return array(
    'router' => array(
        'routes' => array(
            'home' => array(
                'type' => 'Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        'controller' => 'Haymayrer\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
            ),
	        'login' => array(
		        'type' => 'Segment',
		        'options' => array(
			        'route'    => '/login',
			        'defaults' => array(
				        'controller' => 'Haymayrer\Controller\Auth',
				        'action'     => 'login',
			        ),
		        ),
	        ),
	        'parent' => array(
		        'type' => 'Segment',
		        'options' => array(
			        'route' => '/parent[/]',
			        'defaults' => array(
				        'controller' => 'Haymayrer\Controller\Parent',
				        'action'     => 'index',
			        ),
		        ),
	        ),
	        'parent-add' => array(
		        'type' => 'Segment',
		        'options' => array(
			        'route' => '/parent/add[/]',
			        'defaults' => array(
				        'controller' => 'Haymayrer\Controller\Parent',
				        'action'     => 'add',
			        ),
		        ),
	        ),
	        'parent-edit' => array(
		        'type' => 'Segment',
		        'options' => array(
			        'route' => '/parent/edit/[:id]',
			        'defaults' => array(
				        'controller' => 'Haymayrer\Controller\Parent',
				        'action'     => 'edit',
			        ),
		        ),
	        ),
	        'parent-view' => array(
		        'type' => 'Segment',
		        'options' => array(
			        'route' => '/parent/view/[:id]',
			        'defaults' => array(
				        'controller' => 'Haymayrer\Controller\Parent',
				        'action'     => 'view',
			        ),
		        ),
	        ),
	        'parent-delete' => array(
		        'type' => 'Segment',
		        'options' => array(
			        'route' => '/parent/delete/[:id]',
			        'defaults' => array(
				        'controller' => 'Haymayrer\Controller\Parent',
				        'action'     => 'delete',
			        ),
		        ),
	        ),
	        'child' => array(
		        'type' => 'Segment',
		        'options' => array(
			        'route' => '/child[/]',
			        'defaults' => array(
				        'controller' => 'Haymayrer\Controller\Child',
				        'action'     => 'index',
			        ),
		        ),
	        ),
	        'child-add' => array(
		        'type' => 'Segment',
		        'options' => array(
			        'route' => '/child/add[/]',
			        'defaults' => array(
				        'controller' => 'Haymayrer\Controller\Child',
				        'action'     => 'add',
			        ),
		        ),
	        ),
	        'child-edit' => array(
		        'type' => 'Segment',
		        'options' => array(
			        'route' => '/child/edit/[:id]',
			        'defaults' => array(
				        'controller' => 'Haymayrer\Controller\Child',
				        'action'     => 'edit',
			        ),
		        ),
	        ),
	        'child-view' => array(
		        'type' => 'Segment',
		        'options' => array(
			        'route' => '/child/view/[:id]',
			        'defaults' => array(
				        'controller' => 'Haymayrer\Controller\Child',
				        'action'     => 'view',
			        ),
		        ),
	        ),
	        'child-delete' => array(
		        'type' => 'Segment',
		        'options' => array(
			        'route' => '/child/delete/:id',
			        'defaults' => array(
				        'controller' => 'Haymayrer\Controller\Child',
				        'action'     => 'delete',
			        ),
		        ),
	        ),
	        'therapy' => array(
		        'type' => 'Literal',
		        'options' => array(
			        'route' => '/therapy',
			        'defaults' => array(
				        'controller' => 'Haymayrer\Controller\Therapy',
				        'action'     => 'index',
			        ),
		        ),
	        ),
	        'therapy-add' => array(
		        'type' => 'Segment',
		        'options' => array(
			        'route' => '/therapy/add[/]',
			        'defaults' => array(
				        'controller' => 'Haymayrer\Controller\Therapy',
				        'action'     => 'add',
			        ),
		        ),
	        ),
	        'therapy-delete' => array(
		        'type' => 'Segment',
		        'options' => array(
			        'route' => '/therapy/delete/:id',
			        'defaults' => array(
				        'controller' => 'Haymayrer\Controller\Therapy',
				        'action'     => 'delete',
			        ),
		        ),
	        ),
	        'therapy-view' => array(
		        'type' => 'Segment',
		        'options' => array(
			        'route' => '/therapy/view/:id',
			        'defaults' => array(
				        'controller' => 'Haymayrer\Controller\Therapy',
				        'action'     => 'view',
			        ),
		        ),
	        ),
	        'therapy-edit' => array(
		        'type' => 'Segment',
		        'options' => array(
			        'route' => '/therapy/edit/:id',
			        'defaults' => array(
				        'controller' => 'Haymayrer\Controller\Therapy',
				        'action'     => 'edit',
			        ),
		        ),
	        ),
	        'therapy-status' => array(
		        'type' => 'Segment',
		        'options' => array(
			        'route' => '/therapy/status/:id/:status',
			        'defaults' => array(
				        'controller' => 'Haymayrer\Controller\Therapy',
				        'action'     => 'status',
			        ),
		        ),
	        ),
	        'therapy-add-participant' => array(
		        'type' => 'Segment',
		        'options' => array(
			        'route' => '/therapy/add/:id/:child_id',
			        'defaults' => array(
				        'controller' => 'Haymayrer\Controller\Therapy',
				        'action'     => 'add-participant',
			        ),
		        ),
	        ),
	        'therapy-delete-participant' => array(
		        'type' => 'Segment',
		        'options' => array(
			        'route' => '/therapy/delete/:id/:child_id',
			        'defaults' => array(
				        'controller' => 'Haymayrer\Controller\Therapy',
				        'action'     => 'delete-participant',
			        ),
		        ),
	        ),
	        'logout' => array(
		        'type' => 'Segment',
		        'options' => array(
			        'route'    => '/logout[/]',
			        'defaults' => array(
				        'controller' => 'Haymayrer\Controller\Auth',
				        'action'     => 'logout',
			        ),
		        ),
	        ),
            // The following is a route to simplify getting started creating
            // new controllers and actions without needing to create a new
            // module. Simply drop new controllers in, and you can access them
            // using the path /application/:controller/:action
            'application' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/hm', /** application */
                    'defaults' => array(
                        '__NAMESPACE__' => 'Haymayrer\Controller',
                        'controller'    => 'Index',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:controller[/:action]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'service_manager' => array(
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ),
        'aliases' => array(
            'translator' => 'MvcTranslator',
            'adapter' => 'Zend\Db\Adapter\Adapter',
	        'auth' => 'Haymayrer\Service\AuthService',

	        // Mappers
            'UserMapper' => 'Haymayrer\Mapper\User',
            'ParentsMapper' => 'Haymayrer\Mapper\Parents',
            'ChildMapper' => 'Haymayrer\Mapper\Child',
            'AttendanceMapper' => 'Haymayrer\Mapper\Attendance',
            'ParticipationMapper' => 'Haymayrer\Mapper\Participation',
            'PermissionMapper' => 'Haymayrer\Mapper\Permission',
            'RelUserPermissionMapper' => 'Haymayrer\Mapper\RelUserPermission',
        ),
	    'factories' => array(
		    'Zend\Db\Adapter\Adapter' => function($sm) {
			    $config = $sm->get('Config');
			    $dbParams = $config['dbParams'];

			    return new Zend\Db\Adapter\Adapter([
				    'driver' => 'pdo',
				    'dsn' => 'mysql:dbname=' . $dbParams['database'] . ';host=' . $dbParams['hostname'],
				    'database' => $dbParams['database'],
				    'username' => $dbParams['username'],
				    'password' => $dbParams['password'],
				    'hostname' => $dbParams['hostname'],
				]);
		    },
		    'Haymayrer\Mapper\User' => function($sm) {
			    return new \Haymayrer\Mapper\User(
				    $sm->get('adapter'),
				    new \Haymayrer\Entity\User()
			    );
		    },
		    'Haymayrer\Mapper\Parents' => function($sm) {
			    return new \Haymayrer\Mapper\Parents(
				    $sm->get('adapter'),
				    new \Haymayrer\Entity\Parents()
			    );
		    },
		    'Haymayrer\Mapper\Child' => function($sm) {
			    return new \Haymayrer\Mapper\Child(
				    $sm->get('adapter'),
				    new \Haymayrer\Entity\Child()
			    );
		    },
		    'Haymayrer\Mapper\Attendance' => function($sm) {
			    return new \Haymayrer\Mapper\Attendance(
				    $sm->get('adapter'),
				    new \Haymayrer\Entity\Attendance()
			    );
		    },
		    'Haymayrer\Mapper\Participation' => function($sm) {
			    return new \Haymayrer\Mapper\Participation(
				    $sm->get('adapter'),
				    new \Haymayrer\Entity\Participation()
			    );
		    },
		    'Haymayrer\Mapper\Permission' => function($sm) {
			    return new \Haymayrer\Mapper\Permission(
				    $sm->get('adapter'),
				    new \Haymayrer\Entity\Permission()
			    );
		    },
		    'Haymayrer\Mapper\RelUserPermission' => function($sm) {
			    return new \Haymayrer\Mapper\RelUserPermission(
				    $sm->get('adapter'),
				    new \Haymayrer\Entity\RelUserPermission()
			    );
		    },
		    'Haymayrer\Service\AuthService' => 'Haymayrer\Service\AuthServiceFactory',
	    ),
    ),
    'translator' => array(
        'locale' => 'en_US',
        'translation_file_patterns' => array(
            array(
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Haymayrer\Controller\Index' => 'Haymayrer\Controller\IndexController',
            'Haymayrer\Controller\Parent' => 'Haymayrer\Controller\ParentController',
            'Haymayrer\Controller\Child' => 'Haymayrer\Controller\ChildController',
            'Haymayrer\Controller\Therapy' => 'Haymayrer\Controller\TherapyController',
        ),
	    'factories' => array(
		    'Haymayrer\Controller\Auth' => 'Haymayrer\Controller\AuthControllerFactory',
	    ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
	    'strategies' => array(
		    'ViewJsonStrategy',
	    ),
    ),
    // Placeholder for console routes
    'console' => array(
        'router' => array(
            'routes' => array(
            ),
        ),
    ),
);
