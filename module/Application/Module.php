<?php

namespace Application;

use Laminas\Mvc\ModuleRouteListener;
use Laminas\Mvc\MvcEvent;
use Laminas\Session\SessionManager;
use Laminas\Session\Config\SessionConfig;
use Laminas\Session\Container;
use Laminas\Session\Validator\HttpUserAgent;

/**
 * Class Module
 * @package Application
 */
class Module
{

    /**
     * @param MvcEvent $e
     */
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        //modify the condition depending on your environments / display exception is not a good idea in a production environment
        if (strcasecmp(ANIT_ENVIRONMENT, 'dev')==0) {
            //https://stackoverflow.com/questions/46969748/display-all-exception-messages-in-zend-instead-of-an-error-occurred
            //Attach render errors
            $eventManager->attach(MvcEvent::EVENT_RENDER_ERROR, function ($e) {
                if ($e->getParam('exception')) {
                    $this->displayException($e->getParam('exception')); //Custom error render function.
                }
            });
            //Attach dispatch errors
            $eventManager->attach(MvcEvent::EVENT_DISPATCH_ERROR, function ($e) {
                if ($e->getParam('exception')) {
                    $this->displayException($e->getParam('exception'));//Custom error render function.
                }
            });
        }

        // get the cache listener service
        // $e->getApplication()->getServiceManager()->get('CacheDataListener');

        //force ssl
        //$eventManager->attach('route', array($this, 'doHttpsRedirect'));
        /*
        $translator=$e->getApplication()->getServiceManager()->get('translator');
        \Laminas\Validator\AbstractValidator::setDefaultTranslator($translator); */

        $this->initSession(array(
            'remember_me_seconds' => 10800,
            'use_cookies' => true,
            'cookie_httponly' => true,
            'cache_expire' => 180,
            'cookie_lifetime' => 10800
        ));
    }

    /**
     * @return mixed
     */
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    /*
        public function getAutoloaderConfig() {
            return array(
                'Laminas\Loader\StandardAutoloader' => array(
                    'namespaces' => array(
                        __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                    ),
                ),
            );
        }
    */
    /**
     * @param $config
     * Session initialization
     */
    public function initSession($config)
    {
        $sessionConfig = new SessionConfig();
        $sessionConfig->setOptions($config);
        $sessionManager = new SessionManager($sessionConfig);
        $sessionManager->getValidatorChain()
            ->attach(
                'session.validate',
                array(new HttpUserAgent(), 'isValid')
            );
        /*
          $sessionManager->getValidatorChain()
          ->attach(
            'session.validate',
              array(new RemoteAddr(), 'isValid')
          );*/
        $sessionManager->start();
        /**
         * Optional: If you later want to use namespaces, you can already store the
         * Manager in the shared (static) Container (=namespace) field
         */
        Container::setDefaultManager($sessionManager);
    }

    //

    /**
     * @param $e
     * https://stackoverflow.com/questions/46969748/display-all-exception-messages-in-zend-instead-of-an-error-occurred
     */
    public function displayException($e)
    {
        echo "<span style='font-family: courier new; padding: 2px 5px; background:red; color: white;'> " . $e->getMessage() . '</span><br/>';
        echo "<pre>" . $e->getTraceAsString() . '</pre>';
    }

    /*
     * 
    //source -> http://stackoverflow.com/questions/18141140/zf2-and-force-https-for-specific-routes
    public function doHttpsRedirect(MvcEvent $e){
        $sm = $e->getApplication()->getServiceManager();
        $uri = $e->getRequest()->getUri();
        $scheme = $uri->getScheme();
        if ($scheme != 'https'){
            $uri->setScheme('https');
            $response=$e->getResponse();
            $response->getHeaders()->addHeaderLine('Location', $uri);
            $response->setStatusCode(302);
            $response->sendHeaders();
            return $response;
        }
    }
     * 
     */

}
