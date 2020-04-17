<?php
namespace Privatespace;


use Privatespace\Controller\PrivatespaceControllerFactory;
use Zend\Router\Http\Segment;


return array(
	'controllers' => array(
		'factories' => array(
			Controller\PrivatespaceController::class => PrivatespaceControllerFactory::class),
	),
	
	// The following section is new and should be added to your file
	'router' => array(
		'routes' => array(
			'privatespace' => array(
				'type' => Segment::class,
				'options' => array(
					'route' => '/privatespace[/:action][/:id]',
					'constraints' => array(
					'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
					'id' => '[0-9]+',),
				'defaults' => array(
					'controller' => Controller\PrivatespaceController::class,
					'action' => 'index',
                                    ),
				),
			),
		),
	),
	'view_manager' => array(
		'template_path_stack' => array(
			'privatespace' => __DIR__ . '/../view',),
	),
);
	