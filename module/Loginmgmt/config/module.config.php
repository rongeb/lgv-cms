<?php
namespace Loginmgmt;

use Loginmgmt\Controller\LoginmgmtController;
use Loginmgmt\Controller\LoginmgmtControllerFactory;
use Laminas\Router\Http\Segment;

return array(
	'controllers' => array(
		'factories' => array(
			LoginmgmtController::class => LoginmgmtControllerFactory::class),
	),
	
	// The following section is new and should be added to your file
	'router' => array(
		'routes' => array(
			'loginmgmt' => array(
				'type' => Segment::class,
				'options' => array(
					'route' => '/loginmgmt[/:action][/:id]',
					'constraints' => array(
					'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
					'id' => '[0-9]+',),
				'defaults' => array(
					'controller' => LoginmgmtController::class,
					'action' => 'index',
                                    ),
				),
			),
		),
	),
	'view_manager' => array(
		'template_path_stack' => array(
			'loginmgmt' => __DIR__ . '/../view',),
	),
);
	