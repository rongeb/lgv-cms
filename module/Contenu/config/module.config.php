<?php
namespace Contenu;

use Contenu\Controller\ContenuController;
use Contenu\Controller\ContenuControllerFactory;
use Laminas\ServiceManager\Factory\InvokableFactory;

return array(
	'controllers' => array(
		'factories' => array(
			Controller\ContenuController::class => ContenuControllerFactory::class),
	),
	
	// The following section is new and should be added to your file
	'router' => array(
		'routes' => array(
			'Contenu' => array(
				'type' => 'segment',
				'options' => array(
					'route' => '/contenu[/:action][/:id]',
					'constraints' => array(
					'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
					'id' => '[0-9]+',),
				'defaults' => array(
					'controller' => ContenuController::class,
					'action' => 'index'),
                                        //'cache'      => true),
				),
			),
		),
	),
	'view_manager' => array(
		'template_path_stack' => array(
			'Contenu' => __DIR__ . '/../view',),
	),
);
	