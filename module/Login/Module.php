<?php

namespace Login;

/**
 * Class Module
 * @package Login
 */
class Module
{
    /**
     * @return mixed
     */
    public function getConfig(){
		return include __DIR__ . '/config/module.config.php';
	}
	
}

