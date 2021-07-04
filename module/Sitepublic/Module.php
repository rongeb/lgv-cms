<?php

namespace Sitepublic;

/**
 * Class Module
 * @package Sitepublic
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

