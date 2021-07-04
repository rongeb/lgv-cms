<?php

namespace Login;

use Login\Controller\LoginControllerFactory;
use Login\Controller\LoginController;
use Laminas\Router\Http\Segment;

return array(
    'controllers' => array(
        'factories' => array(
            LoginController::class => LoginControllerFactory::class),
    ),

    // The following section is new and should be added to your file
    'router' => array(
        'routes' => array(
            'Login' => array(
                'type' => Segment::class,
                'options' => array(
                    'route' => '/backofficeaccess[/:action]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*'),

                    'defaults' => array(
                        'controller' => LoginController::class,
                        'action' => 'index',
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'Login' => __DIR__ . '/../view',)
    ),
);
	