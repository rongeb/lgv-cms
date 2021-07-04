<?php

namespace Searchws;

use Searchws\Controller\SearchwsController;
use Searchws\Controller\SearchwsControllerFactory;
use Laminas\Router\Http\Segment;

return array(
    'controllers' => array(
        'factories' => array(
            SearchwsController::class => SearchwsControllerFactory::class,
        ),
    ),
    // The following section is new and should be added to your file
    'router' => array(
        'routes' => array(
            'searchws' => array(
                'type' => Segment::class,
                'options' => array(
                    'route' => '/searchws[/:action]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        //'id' => '[0-9]+',
                        'id' => '[a-zA-Z0-9_-]*[.]{0,1}[a-zA-Z]*',),
                    'defaults' => array(
                        'controller' => SearchwsController::class,
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
