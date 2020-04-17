<?php

namespace Fichiers;

/**
 * Class Module
 * @package Fichiers
 */
class Module
{
	public function getConfig(){
		return include __DIR__ . '/config/module.config.php';
	}
	
}

