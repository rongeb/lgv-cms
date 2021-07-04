<?php

namespace MyAcl;

use Laminas\ServiceManager\Factory\InvokableFactory;

return array(
	// added for Acl   ###################################
	'controller_plugins' => array(
        'factories' => array(
	       Controller\Plugin\MyAclPlugin::class => InvokableFactory::class
	     )
	 ),
	// end: added for Acl   ###################################	
);