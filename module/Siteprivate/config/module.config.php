<?php
namespace Siteprivate;

return array(
    'controllers' => array(
        'factories' => array(
            Controller\SiteprivateController::class => Controller\SiteprivateControllerFactory::class),
    ),
    // The following section is new and should be added to your file
    'router' => array(
        'routes' => array(
            'siteprivate' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/siteprivate[/:action][/:page]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
			'page' => '[a-zA-Z][a-zA-Z0-9_-]*',),
                    'defaults' => array(
                        'controller' => Controller\SiteprivateController::class,
                        'action' => 'index',
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'siteprivate' => __DIR__ . '/../view',),
    ),
);
