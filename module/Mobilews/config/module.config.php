<?php
namespace Mobilews;

use Mobilews\Controller\MobilewsController;
use Mobilews\Controller\MobilewsControllerFactory;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;

return array(
    'controllers' => array(
        'factories' => array(
            MobilewsController::class => MobilewsControllerFactory::class,
        ),
    ),
    // The following section is new and should be added to your file
    'router' => array(
        'routes' => array(
            'Mobilews' => array(
                'type' => Segment::class,
                'options' => array(
                    'route' => '/mobilews[/:action][/:id]',
                    //'route' => '/mobilews[/:action]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',),
                        //'id' => '[a-zA-Z0-9_-]*[.]{0,1}[a-zA-Z]*',),
                    'defaults' => array(
                        'controller' => MobilewsController::class,
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
