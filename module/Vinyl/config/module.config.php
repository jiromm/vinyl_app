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
                        'controller' => 'Vinyl\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
            ),
	        'login' => array(
		        'type' => 'Segment',
		        'options' => array(
			        'route'    => '/login',
			        'defaults' => array(
				        'controller' => 'Vinyl\Controller\Auth',
				        'action'     => 'login',
			        ),
		        ),
	        ),
	        'parent' => array(
		        'type' => 'Segment',
		        'options' => array(
			        'route' => '/parent[/]',
			        'defaults' => array(
				        'controller' => 'Vinyl\Controller\Parent',
				        'action'     => 'index',
			        ),
		        ),
	        ),
	        'parent-add' => array(
		        'type' => 'Segment',
		        'options' => array(
			        'route' => '/parent/add[/]',
			        'defaults' => array(
				        'controller' => 'Vinyl\Controller\Parent',
				        'action'     => 'add',
			        ),
		        ),
	        ),
	        'parent-edit' => array(
		        'type' => 'Segment',
		        'options' => array(
			        'route' => '/parent/edit/[:id]',
			        'defaults' => array(
				        'controller' => 'Vinyl\Controller\Parent',
				        'action'     => 'edit',
			        ),
		        ),
	        ),
	        'parent-view' => array(
		        'type' => 'Segment',
		        'options' => array(
			        'route' => '/parent/view/[:id]',
			        'defaults' => array(
				        'controller' => 'Vinyl\Controller\Parent',
				        'action'     => 'view',
			        ),
		        ),
	        ),
	        'parent-delete' => array(
		        'type' => 'Segment',
		        'options' => array(
			        'route' => '/parent/delete/[:id]',
			        'defaults' => array(
				        'controller' => 'Vinyl\Controller\Parent',
				        'action'     => 'delete',
			        ),
		        ),
	        ),
	        'child' => array(
		        'type' => 'Segment',
		        'options' => array(
			        'route' => '/child[/]',
			        'defaults' => array(
				        'controller' => 'Vinyl\Controller\Child',
				        'action'     => 'index',
			        ),
		        ),
	        ),
	        'child-add' => array(
		        'type' => 'Segment',
		        'options' => array(
			        'route' => '/child/add[/]',
			        'defaults' => array(
				        'controller' => 'Vinyl\Controller\Child',
				        'action'     => 'add',
			        ),
		        ),
	        ),
	        'child-edit' => array(
		        'type' => 'Segment',
		        'options' => array(
			        'route' => '/child/edit/[:id]',
			        'defaults' => array(
				        'controller' => 'Vinyl\Controller\Child',
				        'action'     => 'edit',
			        ),
		        ),
	        ),
	        'child-view' => array(
		        'type' => 'Segment',
		        'options' => array(
			        'route' => '/child/view/[:id]',
			        'defaults' => array(
				        'controller' => 'Vinyl\Controller\Child',
				        'action'     => 'view',
			        ),
		        ),
	        ),
	        'child-delete' => array(
		        'type' => 'Segment',
		        'options' => array(
			        'route' => '/child/delete/:id',
			        'defaults' => array(
				        'controller' => 'Vinyl\Controller\Child',
				        'action'     => 'delete',
			        ),
		        ),
	        ),
	        'therapy' => array(
		        'type' => 'Literal',
		        'options' => array(
			        'route' => '/therapy',
			        'defaults' => array(
				        'controller' => 'Vinyl\Controller\Therapy',
				        'action'     => 'index',
			        ),
		        ),
	        ),
	        'therapy-add' => array(
		        'type' => 'Segment',
		        'options' => array(
			        'route' => '/therapy/add[/]',
			        'defaults' => array(
				        'controller' => 'Vinyl\Controller\Therapy',
				        'action'     => 'add',
			        ),
		        ),
	        ),
	        'therapy-delete' => array(
		        'type' => 'Segment',
		        'options' => array(
			        'route' => '/therapy/delete/:id',
			        'defaults' => array(
				        'controller' => 'Vinyl\Controller\Therapy',
				        'action'     => 'delete',
			        ),
		        ),
	        ),
	        'therapy-view' => array(
		        'type' => 'Segment',
		        'options' => array(
			        'route' => '/therapy/view/:id',
			        'defaults' => array(
				        'controller' => 'Vinyl\Controller\Therapy',
				        'action'     => 'view',
			        ),
		        ),
	        ),
	        'therapy-edit' => array(
		        'type' => 'Segment',
		        'options' => array(
			        'route' => '/therapy/edit/:id',
			        'defaults' => array(
				        'controller' => 'Vinyl\Controller\Therapy',
				        'action'     => 'edit',
			        ),
		        ),
	        ),
	        'therapy-status' => array(
		        'type' => 'Segment',
		        'options' => array(
			        'route' => '/therapy/status/:id/:status',
			        'defaults' => array(
				        'controller' => 'Vinyl\Controller\Therapy',
				        'action'     => 'status',
			        ),
		        ),
	        ),
	        'therapy-add-participant' => array(
		        'type' => 'Segment',
		        'options' => array(
			        'route' => '/therapy/add/:id/:child_id',
			        'defaults' => array(
				        'controller' => 'Vinyl\Controller\Therapy',
				        'action'     => 'add-participant',
			        ),
		        ),
	        ),
	        'therapy-delete-participant' => array(
		        'type' => 'Segment',
		        'options' => array(
			        'route' => '/therapy/delete/:id/:child_id',
			        'defaults' => array(
				        'controller' => 'Vinyl\Controller\Therapy',
				        'action'     => 'delete-participant',
			        ),
		        ),
	        ),
	        'logout' => array(
		        'type' => 'Segment',
		        'options' => array(
			        'route'    => '/logout[/]',
			        'defaults' => array(
				        'controller' => 'Vinyl\Controller\Auth',
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
                    'route'    => '/vinyl', /** application */
                    'defaults' => array(
                        '__NAMESPACE__' => 'Vinyl\Controller',
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
	        'auth' => 'Vinyl\Service\AuthService',

	        // Mappers
            'UserMapper' => 'Vinyl\Mapper\User',
            'ParentsMapper' => 'Vinyl\Mapper\Parents',
            'ChildMapper' => 'Vinyl\Mapper\Child',
            'AttendanceMapper' => 'Vinyl\Mapper\Attendance',
            'ParticipationMapper' => 'Vinyl\Mapper\Participation',
            'PermissionMapper' => 'Vinyl\Mapper\Permission',
            'RelUserPermissionMapper' => 'Vinyl\Mapper\RelUserPermission',
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
		    'Vinyl\Mapper\User' => function($sm) {
			    return new \Vinyl\Mapper\User(
				    $sm->get('adapter'),
				    new \Vinyl\Entity\User()
			    );
		    },
		    'Vinyl\Mapper\Parents' => function($sm) {
			    return new \Vinyl\Mapper\Parents(
				    $sm->get('adapter'),
				    new \Vinyl\Entity\Parents()
			    );
		    },
		    'Vinyl\Mapper\Child' => function($sm) {
			    return new \Vinyl\Mapper\Child(
				    $sm->get('adapter'),
				    new \Vinyl\Entity\Child()
			    );
		    },
		    'Vinyl\Mapper\Attendance' => function($sm) {
			    return new \Vinyl\Mapper\Attendance(
				    $sm->get('adapter'),
				    new \Vinyl\Entity\Attendance()
			    );
		    },
		    'Vinyl\Mapper\Participation' => function($sm) {
			    return new \Vinyl\Mapper\Participation(
				    $sm->get('adapter'),
				    new \Vinyl\Entity\Participation()
			    );
		    },
		    'Vinyl\Mapper\Permission' => function($sm) {
			    return new \Vinyl\Mapper\Permission(
				    $sm->get('adapter'),
				    new \Vinyl\Entity\Permission()
			    );
		    },
		    'Vinyl\Mapper\RelUserPermission' => function($sm) {
			    return new \Vinyl\Mapper\RelUserPermission(
				    $sm->get('adapter'),
				    new \Vinyl\Entity\RelUserPermission()
			    );
		    },
		    'Vinyl\Service\AuthService' => 'Vinyl\Service\AuthServiceFactory',
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
            'Vinyl\Controller\Index' => 'Vinyl\Controller\IndexController',
            'Vinyl\Controller\Parent' => 'Vinyl\Controller\ParentController',
            'Vinyl\Controller\Child' => 'Vinyl\Controller\ChildController',
            'Vinyl\Controller\Therapy' => 'Vinyl\Controller\TherapyController',
        ),
	    'factories' => array(
		    'Vinyl\Controller\Auth' => 'Vinyl\Controller\AuthControllerFactory',
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
