<?php

namespace Linktocontenu;

use Linktocontenu\Controller\LinktocontenuControllerFactory;

return array(
    'controllers' => array(
        'factories' => array(
            Controller\LinktocontenuController::class => LinktocontenuControllerFactory::class),
    ),
    // The following section is new and should be added to your file
    'router' => array(
        'routes' => array(
            'Linktocontenu' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/linktocontenu[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',),
                    'defaults' => array(
                        'controller' => Controller\LinktocontenuController::class,
                        'action' => 'index'),
                    //'cache'      => true),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'Linktocontenu' => __DIR__ . '/../view',),
    ),
);
