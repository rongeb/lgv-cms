<?php
namespace Privatespacelogin;

use Privatespacelogin\Controller\PrivatespaceloginController;
use Privatespacelogin\Controller\PrivatespaceloginControllerFactory;
use Laminas\Router\Http\Segment;

return array(
    'controllers' => array(
        'factories' => array(
            PrivatespaceloginController::class => PrivatespaceloginControllerFactory::class),
    ),
    // The following section is new and should be added to your file
    'router' => array(
        'routes' => array(
            'privatespacelogin' => array(
                'type' => Segment::class,
                'options' => array(
                    'route' => '/privatespacelogin[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',),
                    'defaults' => array(
                        'controller' => PrivatespaceloginController::class,
                        'action' => 'index',
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'privatespacelogin' => __DIR__ . '/../view',),
    ),
);
