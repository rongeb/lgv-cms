<?php

namespace Uploadmgmt;

/**
 * Class Module
 * @package Uploadmgmt
 */
class Module {
    public function getConfig(){
        return include __DIR__ . '/config/module.config.php';
    }

}

