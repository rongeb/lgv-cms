<?php

namespace Message;

/**
 * Class Module
 * @package Messages
 */
class Module {
/*
    public function getAutoloaderConfig() {
        return array(
            'Laminas\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',),
            'Laminas\Loader\StandardAutoloader' => array(
                'namespaces' => array(__NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,),
            ),
        );
    }
*/
    /**
     * @return mixed
     */
    public function getConfig() {
        return include __DIR__ . '/config/module.config.php';
    }

}
