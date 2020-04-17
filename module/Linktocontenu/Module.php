<?php

namespace Linktocontenu;

/**
 * Class Module
 * @package Linktocontenu
 */
class Module {

    /**
     * @return mixed
     */
    public function getConfig() {
        return include __DIR__ . '/config/module.config.php';
    }

}
