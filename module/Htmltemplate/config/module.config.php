<?php
namespace Htmltemplate;

use Htmltemplate\Controller\HtmltemplateController;
use Htmltemplate\Controller\HtmltemplateControllerFactory;

return array(
	'controllers' => array(
		'factories' => array(
			Controller\HtmltemplateController::class => HtmltemplateControllerFactory::class),
	),
	
	// The following section is new and should be added to your file
	'router' => array(
		'routes' => array(
			'htmltemplate' => array(
				'type' => 'segment',
				'options' => array(
					'route' => '/htmltemplate[/:action][/:id]',
					'constraints' => array(
					'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
					'id' => '[0-9]+',),
				'defaults' => array(
					'controller' => HtmltemplateController::class,
					'action' => 'index'),
                                        //'cache'      => true),
				),
			),
		),
	),
	'view_manager' => array(
		'template_path_stack' => array(
			'htmltemplate' => __DIR__ . '/../view',),
	),
);
	