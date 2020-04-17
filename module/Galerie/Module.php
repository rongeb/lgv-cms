<?php
namespace Galerie;

/**
 * Class Module
 * @package Galerie
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

