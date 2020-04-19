<?php
namespace MyAcl;

use MyAcl\Controller\Plugin\MyAclPlugin;
use Laminas\ModuleManager\ModuleManager; // added for module specific layouts. ericp

// added for Acl  ###################################
use Laminas\Mvc\MvcEvent,
    Laminas\ModuleManager\Feature\AutoloaderProviderInterface,
    Laminas\ModuleManager\Feature\ConfigProviderInterface;

/**
 * Class Module
 * @package MyAcl
 */
class Module 

{

    /**
     * @return mixed
     */
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }	
	
	// added for Acl   ###################################
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager = $e->getApplication()->getEventManager();
        $eventManager->attach('route', array($this, 'loadConfiguration'), 2);
        //you can attach other function need here...
    }

    /**
     * @param MvcEvent $e
     */
    public function loadConfiguration(MvcEvent $e)
    {
    $application   = $e->getApplication();
	$sm            = $application->getServiceManager();
	$sharedManager = $application->getEventManager()->getSharedManager();
	
    $router = $sm->get('router');
	$request = $sm->get('request');
	
	$matchedRoute = $router->match($request);
	if (null !== $matchedRoute) { 
           $sharedManager->attach('Laminas\Mvc\Controller\AbstractActionController','dispatch', 
                function($e) use ($sm) {
		   $sm->get('ControllerPluginManager')->get(MyAclPlugin::class)
                      ->doAuthorization($e); //pass to the plugin...    
	       },2
           );
        }
    }
	
	
	// end: added for Acl   ###################################
	
	/*
	 *  // added init() func for module specific layouts. ericp
	 * http://blog.evan.pro/module-specific-layouts-in-zend-framework-2
	 */
    public function init(ModuleManager $moduleManager)
    {
        $sharedEvents = $moduleManager->getEventManager()->getSharedManager();
        $sharedEvents->attach(__NAMESPACE__, 'dispatch', function($e) {
            // This event will only be fired when an ActionController under the MyModule namespace is dispatched.
            $controller = $e->getTarget();

        }, 100);
    }
}
