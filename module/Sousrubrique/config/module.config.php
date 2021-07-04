<?php
namespace SousRubrique;

use Sousrubrique\Controller\SousrubriqueController;
use Sousrubrique\Controller\SousrubriqueControllerFactory;
use Laminas\Router\Http\Segment;
use Laminas\ServiceManager\Factory\InvokableFactory;

return array(
	'controllers' => array(
		'factories' => array(
			Controller\SousrubriqueController::class => SousrubriqueControllerFactory::class),
	),
	
	// The following section is new and should be added to your file
	'router' => array(
		'routes' => array(
			'Sousrubrique' => array(
				'type' => Segment::class,
				'options' => array(
					'route' => '/sousrubrique[/:action][/:id]',
					'constraints' => array(
					'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
					'id' => '[0-9]+',),
				'defaults' => array(
					'controller' => Controller\SousrubriqueController::class,
					'action' => 'index'),
                                        //'cache'      => true),
				),
			),
		),
	),
	'view_manager' => array(
		'template_path_stack' => array(
			'Sousrubrique' => __DIR__ . '/../view',),
	),
);
	