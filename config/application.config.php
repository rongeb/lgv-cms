<?php

$appConfig = array(
    // This should be an array of module namespaces used in the application.
    'modules' => array(
        'Zend\Navigation',
        'Zend\Paginator',
        'Zend\Serializer',
        'Zend\ServiceManager\Di',
        'Zend\Session',
        'Zend\Log',
        'Zend\Db',
        'Zend\Cache',
        'Zend\InputFilter',
        'Zend\Filter',
        'Zend\Hydrator',
        'Zend\Validator',
        'Zend\Router',
        'Zend\I18n',
        'Zend\Mvc\I18n',
        'Zend\Form',
        'Zend\Mail',
        'Application',
        'DynamicLayout',
        'MyAcl',
        'Login',
        'Loginmgmt',
        'Pagearrangement',
        'Linktocontenu',
        'Rubrique',
        'Message',
        'Sousrubrique',
        'Fichiers',
        'Galerie',
        'Contenu',
        'Blogcontent',
        'Commentaire',
        'Sitepublic',
        'Privatespace',
        'Privatespacelogin',
        'Siteprivate',
        'Uploadmgmt',
        'Pagews',
        'Mobilews',
        'Mapcontent',
        'Searchws',
        'Publishing',
        'Backofficesearch',
        'Htmltemplate'
    ),
    // These are various options for the listeners attached to the ModuleManager
    'module_listener_options' => array(
        // This should be an array of paths in which modules reside.
        // If a string key is provided, the listener will consider that a module
        // namespace, the value of that key the specific path to that module's
        // Module class.
        'module_paths' => array(
            './module',
            './vendor',
        ),

        // Whether or not to enable a configuration cache.
        // If enabled, the merged configuration will be cached and used in
        // subsequent requests.
        //'config_cache_enabled' => true,
        // The key used to create the configuration cache file name.

        //'config_cache_key' => "124567890AZERTYUIOPQSDFGHJKLMWXC",

        // Whether or not to enable a module class map cache.
        // If enabled, creates a module class map cache which will be used
        // by in future requests, to reduce the autoloading process.

        //'module_map_cache_enabled' => true,

        // The key used to create the class map cache file name.
        //'module_map_cache_key' => "AZERTYUIOPQSDFGHJKLMWXC124567890",


        // The path in which to cache merged configuration.
        //'cache_dir' => "./data/cache/",
        // Whether or not to enable modules dependency checking.
        // Enabled by default, prevents usage of modules that depend on other modules
        // that weren't loaded.
        // 'check_dependencies' => true,
    ),
    // Used to create an own service manager. May contain one or more child arrays.
    //'service_listener_options' => array(
    //     array(
    //         'service_manager' => $stringServiceManagerName,
    //         'config_key'      => $stringConfigKey,
    //         'interface'       => $stringOptionalInterface,
    //         'method'          => $stringRequiredMethodName,
    //     ),
    // )
    // Initial configuration with which to seed the ServiceManager.
    // Should be compatible with Zend\ServiceManager\Config.
    // 'service_manager' => array(),
);

// Your environment defines if the cache of the config and the map is enabled.
// It is useful to enable theses caches in Production mode. A request is faster
// because the configuration is not aggregated each time the app receives an http request.
// In dev mode you usually need to update the config regularly, so the cache is not necessary.
if(strcasecmp(ANIT_ENVIRONMENT, 'dev') != 0){
    $appConfig['module_listener_options']['config_cache_enabled'] = true;
    $appConfig['module_listener_options']['config_cache_key'] = "124567890AZERTYUIOPQSDFGHJKLMWXC";
    $appConfig['module_listener_options']['module_map_cache_enabled'] = true;
    $appConfig['module_listener_options']['module_map_cache_key'] = 'AZERTYUIOPQSDFGHJKLMWXC124567890';
    $appConfig['module_listener_options']['cache_dir'] = './data/cache/';
    $appConfig['module_listener_options']['check_dependencies'] = true;
}

return $appConfig;
