<?php

namespace Application;

use Application\Factory\ApplicationControllerFactory;
use Application\Factory\CacheDataListener;
use Application\Factory\CacheDataListenerFactory;
use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;

return array(
    'router' => array(
        'routes' => array(
            'home' => array(
                'type' => Segment::class,
                'options' => array(
                    'route' => '/',
                    'defaults' => array(
                        'controller' => Controller\IndexController::class,
                        'action' => 'index',

                    ),
                ),
            ),
            // The following is a route to simplify getting started creating
            // new controllers and actions without needing to create a new
            // module. Simply drop new controllers in, and you can access them
            // using the path /application/:controller/:action
            'application' => array(
                'type' => Literal::class,
                'options' => array(
                    'route' => '/application',
                    'defaults' => array(
                        'controller' => Controller\IndexController::class,
                        'action' => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type' => Segment::class,
                        'options' => array(
                            'route' => '/[:controller[/:action]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'Zend\Cache' => 'Zend\Cache\Service\StorageCacheFactory',
            CacheDataListener::class => CacheDataListenerFactory::class,
            \Zend\I18n\Translator\TranslatorInterface::class => \Zend\I18n\Translator\TranslatorServiceFactory::class,
        ),

        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        )

    ),
    'translator' => array(
        'locale' => 'fr_FR',
        'translation_file_patterns' => array(
            array(
                'type' => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern' => '%s.mo',
            ),
        ),
    ),
    'cache' => array(
        //filesystem cache
        'adapter' => 'filesystem',
        'options' => array(
            'cache_dir' => 'data/cache/fullpage/',
            'ttl' => 604800,//a week
            'dirPermission' => 0755,
            'filePermission' => 0666
            //'namespaceIsPrefix' => false
            //'namespaceSeparator' => 'namespaceSeparator'
            //'namespace' => 'cache'
        ),
        'plugins' => array('serializer')


    ),
    'controllers' => array(
        'factories' => array(
            Controller\IndexController::class => ApplicationControllerFactory::class
        ),
    ),
    'controller_plugins' => [
        'factories' => [
            'translate' => \Zend\I18n\View\Helper\Translate::class
        ]
    ],
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions' => true,
        'doctype' => 'HTML5',
        'not_found_template' => 'error/404',
        'exception_template' => 'error/index',
        'template_map' => array(
            'sitepublic/layout' => __DIR__ . '/../../Sitepublic/view/sitepublic/layout/layout.phtml',
            'blog/layout' => __DIR__ . '/../../Blog/view/blog/layout/layout.phtml',
            'login/layout' => __DIR__ . '/../../Login/view/login/layout/layout.phtml',
            'layout/layout' => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404' => __DIR__ . '/../../Login/view/login/error/404.phtml',
            'error/index' => __DIR__ . '/../../Login/view/login/error/index.phtml',
            'privatespacelogin/layout' => __DIR__ . '/../../Siteprivate/view/siteprivate/layout/layout.phtml'

        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
        'strategies' => array(
            'ViewJsonStrategy',
        ),
    ),

    'module_layouts' => array(
        'Application' => 'login/layout',
        'Login' => 'login/layout',
        'Rubrique' => 'layout/layout',
        'Sousrubrique' => 'layout/layout',
        'Fichiers' => 'layout/layout',
        'Message' => 'layout/layout',
        'Commentaire' => 'layout/layout',
        'Contenu' => 'layout/layout',
        'Blogcontent' => 'layout/layout',
        'Galerie' => 'layout/layout',
        'Linktocontenu' => 'layout/layout',
        'Loginmgmt' => 'layout/layout',
        'Pagearrangement' => 'layout/layout',
        'Blog' => 'blog/layout',
        'Sitepublic' => 'sitepublic/layout',
        'Privatespace' => 'layout/layout',
        'Privatespaceloginmgmt' => 'layout/layout',
        'Uploadmgmt' => 'layout/layout',
        'Siteprivate' => 'privatespacelogin/layout',
        'Mapcontent' => 'layout/layout'
    )

);
