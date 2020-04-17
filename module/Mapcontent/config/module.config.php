<?php
namespace Mapcontent;

use Mapcontent\Controller\MapcontentController;
use Mapcontent\Controller\MapcontentControllerFactory;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;

return array(
	'controllers' => array(
		'factories' => array(
			Controller\MapcontentController::class => MapcontentControllerFactory::class),
	),
	
	// The following section is new and should be added to your file
	'router' => array(
		'routes' => array(
			'mapcontent' => array(
				'type' => Segment::class,
				'options' => array(
					'route' => '/mapcontent[/:action][/:id]',
					'constraints' => array(
					'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
					'id' => '[0-9]+',),
				'defaults' => array(
					'controller' => MapcontentController::class,
					'action' => 'index'),
                                        //'cache'      => true),
				),
			),
		),
	),
	'view_manager' => array(
		'template_path_stack' => array(
			'mapcontent' => __DIR__ . '/../view',),
	),
);
	