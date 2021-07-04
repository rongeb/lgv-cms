<?php
namespace Rubrique;

return array(
	'controllers' => array(
		'factories' => array(
			Controller\RubriqueController::class => Controller\RubriqueControllerFactory::class),
	),
	
	// The following section is new and should be added to your file
	'router' => array(
		'routes' => array(
			'rubrique' => array(
				'type' => 'segment',
				'options' => array(
					'route' => '/rubrique[/:action][/:id]',
					'constraints' => array(
					'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
					'id' => '[0-9]+',),
				'defaults' => array(
					'controller' => Controller\RubriqueController::class,
					'action' => 'index'),
                                        //'cache'      => true),
				),
			),
		),
	),
	'view_manager' => array(
		'template_path_stack' => array(
			'rubrique' => __DIR__ . '/../view',),
	),
);
	