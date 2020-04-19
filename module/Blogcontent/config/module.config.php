<?php
namespace Blogcontent;


use Blogcontent\Controller\BlogcontentControllerFactory;
use Laminas\Router\Http\Segment;

return array(
	'controllers' => array(
		'factories' => array(
			Controller\BlogcontentController::class => BlogcontentControllerFactory::class),
	),
	
	// The following section is new and should be added to your file
	'router' => array(
		'routes' => array(
			'Blogcontent' => array(
				'type' => Segment::class,
				'options' => array(
					'route' => '/blogcontent[/:action][/:id]',
					'constraints' => array(
					'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
					'id' => '[0-9]+',),
				'defaults' => array(
					'controller' => Controller\BlogcontentController::class,
					'action' => 'index'),
                                        //'cache'      => true),
				),
			),
		),
	),
	'view_manager' => array(
		'template_path_stack' => array(
			'Blogcontent' => __DIR__ . '/../view',),
	),
);
	