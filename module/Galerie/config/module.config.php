<?php
namespace Galerie;

use Galerie\Controller\GalerieController;
use Galerie\Controller\GalerieControllerFactory;
use Zend\Router\Http\Segment;

return array(
	'controllers' => array(
		'factories' => array(
			GalerieController::class => GalerieControllerFactory::class),
	),
	
	// The following section is new and should be added to your file
	'router' => array(
		'routes' => array(
			'Galerie' => array(
				'type' => Segment::class,
				'options' => array(
					'route' => '/galerie[/:action][/:id]',
					'constraints' => array(
					'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
					'id' => '[0-9]+',),
				'defaults' => array(
					'controller' => GalerieController::class,
					'action' => 'index'),
                                        //'cache'      => true),
				),
			),
		),
	),
	'view_manager' => array(
		'template_path_stack' => array(
			'Galerie' => __DIR__ . '/../view',),
	),
);
	