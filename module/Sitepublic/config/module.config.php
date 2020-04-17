<?php

namespace Sitepublic;

use Sitepublic\Controller\SitepublicControllerFactory;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;

return array(
    'controllers' => array(
        'factories' => array(
            Controller\SitepublicController::class => SitepublicControllerFactory::class),
    ),
    // The following section is new and should be added to your file
    'router' => array(
        'routes' => array(
            'Sitepublic' => array(
                'type' => Segment::class,
                'options' => array(
                    'route' => '/sitepublic[/:action][/:page]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'page' => '[a-zA-Z][a-zA-Z0-9_-]*',),
                    'defaults' => array(
                        'controller' => Controller\SitepublicController::class,
                        'action' => 'displaypublicpage'),
                    //'cache'      => true),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'Sitepublic' => __DIR__ . '/../view',),
        /*
             'template_map' => array(
                    'Sitepublic' => __DIR__ . '/../view/sitepublic/layout/layout.phtml')
        */
    ),
);
	