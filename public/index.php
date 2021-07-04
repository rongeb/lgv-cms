<?php
/**
 * This makes our life easier when dealing with paths. Everything is relative
 * to the application root now.
 */
//error_reporting(E_ALL);
error_reporting(E_ERROR);
ini_set('display_errors', true);
 
chdir(dirname(__DIR__));
define('BASE_PATH', realpath(dirname(__DIR__)));
define('PUBLIC_PATH', BASE_PATH.'/public');
define('ANIT_ENVIRONMENT', 'dev');

// Setup autoloading
require 'init_autoloader.php';


// Run the application!
Laminas\Mvc\Application::init(require 'config/application.config.php')->run();
