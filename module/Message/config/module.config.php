<?php
namespace Message;

use Message\Controller\MessageControllerFactory;
use Zend\Router\Http\Segment;

return array(
	'controllers' => array(
		'factories' => array(
			Controller\MessageController::class => MessageControllerFactory::class),
	),
	
	// The following section is new and should be added to your file
	'router' => array(
		'routes' => array(
			'Message' => array(
				'type' => Segment::class,
				'options' => array(
					'route' => '/message[/:action][/:id]',
					'constraints' => array(
					'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
					'id' => '[0-9]+',),
				'defaults' => array(
					'controller' => Controller\MessageController::class,
					'action' => 'index'),
                                        //'cache'      => true),
				),
			),
		),
	),
	'view_manager' => array(
		'template_path_stack' => array(
			'Message' => __DIR__ . '/../view',),
	),
);
	