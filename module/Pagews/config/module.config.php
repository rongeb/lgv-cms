<?php

namespace Pagews;

use Pagews\Controller\PagewsController;
use Laminas\Router\Http\Segment;
use Laminas\ServiceManager\Factory\InvokableFactory;

return array(
    'controllers' => array(
        'factories' => array(
            PagewsController::class => InvokableFactory::class,
        ),
    ),
    // The following section is new and should be added to your file
    'router' => array(
        'routes' => array(
            'pagews' => array(
                'type' => Segment::class,
                'options' => array(
                    'route' => '/pagews[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        //'id' => '[0-9]+',
                        'id' => '[a-zA-Z0-9_-]*[.]{0,1}[a-zA-Z]*',),
                    'defaults' => array(
                        'controller' => PagewsController::class,
                    ),
                    //'cache'      => true),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'strategies' => array(
            'ViewJsonStrategy',
        ),
    ),
);
