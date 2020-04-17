<?php
namespace Uploadmgmt;

use Uploadmgmt\Controller\UploadmgmtControllerFactory;
use Uploadmgmt\Controller\UploadmgmtController;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;

return array(
    'controllers' => array(
        'factories' => array(
            UploadmgmtController::class => UploadmgmtControllerFactory::class),
    ),
    // The following section is new and should be added to your file
    'router' => array(
        'routes' => array(
            'Uploadmgmt' => array(
                'type' => Segment::class,
                'options' => array(
                    'route' => '/uploadmgmt[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',),
                    'defaults' => array(
                        'controller' => UploadmgmtController::class,
                        'action' => 'index'),
                //'cache'      => true),
                ),
            ),
        ),
    ),

    'view_manager' => array(
        'template_path_stack' => array(
            'Uploadmgmt' => __DIR__ . '/../view',
		),
    ),
);
