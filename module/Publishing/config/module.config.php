<?php
namespace Publishing;

return array(
	'controllers' => array(
		'factories' => array(
			Controller\PublishingController::class => Controller\PublishingControllerFactory::class),
	),
	
	// The following section is new and should be added to your file
	'router' => array(
		'routes' => array(
			'publishing' => array(
				'type' => 'segment',
				'options' => array(
					'route' => '/publishing[/:action][/:id]',
					'constraints' => array(
					'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
					//'publish' =>'[0-1]+',
					'id' => '[0-9]+',),
				'defaults' => array(
					'controller' => Controller\PublishingController::class,
					'action' => 'index'),
                                        //'cache'      => true),
				),
			),
		),
	),
	'view_manager' => array(
		'template_path_stack' => array(
			'publishing' => __DIR__ . '/../view',),
	),
);
	