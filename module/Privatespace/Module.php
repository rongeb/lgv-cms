<?php

namespace Privatespace;

/**
 * Class Module
 * @package Privatespace
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

