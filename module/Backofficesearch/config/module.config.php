<?php

namespace Backofficesearch;

use Backofficesearch\Controller\BackofficesearchControllerFactory;
use Backofficesearch\Controller\BackofficesearchController;
use Zend\Router\Http\Segment;

return array(
    'controllers' => array(
        'factories' => array(
            BackofficesearchController::class => BackofficesearchControllerFactory::class,
        ),
    ),
    // The following section is new and should be added to your file
    'router' => array(
        'routes' => array(
            'Backofficesearch' => array(
                'type' => Segment::class,
                'options' => array(
                    'route' => '/bosearch[/:action]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*'),
                        // 'id' => '[0-9]+',),
                    'defaults' => array(
                        'controller' => BackofficesearchController::class,
                        'action' => 'search'),
                    //'cache'      => true),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'Backofficesearch' => __DIR__ . '/../view',),
    ),
);
