<?php

namespace Sousrubrique;

/**
 * Class Module
 * @package Sousrubrique
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

