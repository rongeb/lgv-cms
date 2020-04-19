<?php
namespace Pagearrangement;

use Pagearrangement\Controller\PagearrangementControllerFactory;
use Laminas\Router\Http\Segment;

return array(
	'controllers' => array(
		'factories' => array(
			Controller\PagearrangementController::class => PagearrangementControllerFactory::class),
	),
	
	// The following section is new and should be added to your file
	'router' => array(
		'routes' => array(
			'Pagearrangement' => array(
				'type' => Segment::class,
				'options' => array(
					'route' => '/pagearrangement[/:action][/:id]',
					'constraints' => array(
					'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
					'id' => '[0-9]+',),
				'defaults' => array(
					'controller' => Controller\PagearrangementController::class,
					'action' => 'index'),
                                        //'cache'      => true),
				),
			),
		),
	),
	'view_manager' => array(
		'template_path_stack' => array(
                    'Pagearrangement' => __DIR__ . '/../view',),
	),
);
	