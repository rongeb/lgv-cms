<?php

namespace Pagearrangement;

/**
 * Class Module
 * @package Pagearrangement
 */
class Module {

    /**
     * @return mixed
     */
    public function getConfig(){
		return include __DIR__ . '/config/module.config.php';
	}
}

