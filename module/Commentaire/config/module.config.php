<?php
namespace Commentaire;

use Commentaire\Controller\CommentaireControllerFactory;
use Zend\Router\Http\Segment;

return array(
	'controllers' => array(
		'factories' => array(
			Controller\CommentaireController::class => CommentaireControllerFactory::class),
	),
	
	// The following section is new and should be added to your file
	'router' => array(
		'routes' => array(
			'Commentaire' => array(
				'type' => Segment::class,
				'options' => array(
					'route' => '/commentaire[/:action][/:id]',
					'constraints' => array(
					'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
					'id' => '[0-9]+',),
				'defaults' => array(
					'controller' => Controller\CommentaireController::class,
					'action' => 'index'),
                                        //'cache'      => true),
				),
			),
		),
	),
	'view_manager' => array(
		'template_path_stack' => array(
			'Commentaire' => __DIR__ . '/../view',),
	),
);
	