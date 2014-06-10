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
	        'category' => array(
		        'type' => 'Literal',
		        'options' => array(
			        'route' => '/category',
			        'defaults' => array(
				        'controller' => 'Vinyl\Controller\Category',
				        'action'     => 'index',
			        ),
		        ),
		        'may_terminate' => true,
		        'child_routes' => array(
			        'add' => array(
				        'type' => 'Literal',
				        'options' => array(
					        'route' => '/add',
					        'defaults' => array(
						        'controller' => 'Vinyl\Controller\Category',
						        'action'     => 'add',
					        ),
				        ),
			        ),
			        'edit' => array(
				        'type' => 'Segment',
				        'options' => array(
					        'route' => '/edit/:id',
					        'defaults' => array(
						        'controller' => 'Vinyl\Controller\Category',
						        'action'     => 'edit',
					        ),
				        ),
			        ),
			        'delete' => array(
				        'type' => 'Segment',
				        'options' => array(
					        'route' => '/delete/:id',
					        'defaults' => array(
						        'controller' => 'Vinyl\Controller\Category',
						        'action'     => 'delete',
					        ),
				        ),
			        ),
		        )
	        ),
	        'fence' => array(
		        'type' => 'Literal',
		        'options' => array(
			        'route' => '/fence',
			        'defaults' => array(
				        'controller' => 'Vinyl\Controller\Fence',
				        'action'     => 'index',
			        ),
		        ),
		        'may_terminate' => true,
		        'child_routes' => array(
			        'add' => array(
				        'type' => 'Literal',
				        'options' => array(
					        'route' => '/add',
					        'defaults' => array(
						        'controller' => 'Vinyl\Controller\Fence',
						        'action'     => 'add',
					        ),
				        ),
			        ),
			        'edit' => array(
				        'type' => 'Segment',
				        'options' => array(
					        'route' => '/edit/:id',
					        'defaults' => array(
						        'controller' => 'Vinyl\Controller\Fence',
						        'action'     => 'edit',
					        ),
				        ),
			        ),
			        'delete' => array(
				        'type' => 'Segment',
				        'options' => array(
					        'route' => '/delete/:id',
					        'defaults' => array(
						        'controller' => 'Vinyl\Controller\Fence',
						        'action'     => 'delete',
					        ),
				        ),
			        ),
		        )
	        ),
	        'house' => array(
		        'type' => 'Literal',
		        'options' => array(
			        'route' => '/category',
			        'defaults' => array(
				        'controller' => 'Vinyl\Controller\House',
				        'action'     => 'index',
			        ),
		        ),
		        'may_terminate' => true,
		        'child_routes' => array(
			        'add' => array(
				        'type' => 'Literal',
				        'options' => array(
					        'route' => '/add',
					        'defaults' => array(
						        'controller' => 'Vinyl\Controller\House',
						        'action'     => 'add',
					        ),
				        ),
			        ),
			        'edit' => array(
				        'type' => 'Segment',
				        'options' => array(
					        'route' => '/edit/:id',
					        'defaults' => array(
						        'controller' => 'Vinyl\Controller\House',
						        'action'     => 'edit',
					        ),
				        ),
			        ),
			        'delete' => array(
				        'type' => 'Segment',
				        'options' => array(
					        'route' => '/delete/:id',
					        'defaults' => array(
						        'controller' => 'Vinyl\Controller\House',
						        'action'     => 'delete',
					        ),
				        ),
			        ),
		        )
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
            'CategoryMapper' => 'Vinyl\Mapper\Category',
            'FenceMapper' => 'Vinyl\Mapper\Fence',
            'HouseMapper' => 'Vinyl\Mapper\House',
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
		    'Vinyl\Mapper\Category' => function($sm) {
			    return new \Vinyl\Mapper\Category(
				    $sm->get('adapter'),
				    new \Vinyl\Entity\Category()
			    );
		    },
		    'Vinyl\Mapper\Fence' => function($sm) {
			    return new \Vinyl\Mapper\Fence(
				    $sm->get('adapter'),
				    new \Vinyl\Entity\Fence()
			    );
		    },
		    'Vinyl\Mapper\House' => function($sm) {
			    return new \Vinyl\Mapper\House(
				    $sm->get('adapter'),
				    new \Vinyl\Entity\House()
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
            'Vinyl\Controller\Category' => 'Vinyl\Controller\CategoryController',
            'Vinyl\Controller\Fence' => 'Vinyl\Controller\FenceController',
            'Vinyl\Controller\House' => 'Vinyl\Controller\HouseController',
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
            'routes' => array(),
        ),
    ),
);
