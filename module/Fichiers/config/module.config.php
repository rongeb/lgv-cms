<?php
namespace Fichiers;

use Fichiers\Controller\FichiersControllerFactory;
use Laminas\Router\Http\Segment;

return array(
	'controllers' => array(
		'factories' => array(
			Controller\FichiersController::class => FichiersControllerFactory::class),
	),
	
	// The following section is new and should be added to your file
	'router' => array(
		'routes' => array(
			'Fichiers' => array(
				'type' => Segment::class,
				'options' => array(
					'route' => '/fichiers[/:action][/:id]',
					'constraints' => array(
					'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
					'id' => '[0-9]+',),
				'defaults' => array(
					'controller' => Controller\FichiersController::class,
					'action' => 'index'),
                                        //'cache'      => true),
				),
			),
		),
	),
	'view_manager' => array(
		'template_path_stack' => array(
			'Fichiers' => __DIR__ . '/../view',),
	),
);
	