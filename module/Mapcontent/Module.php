<?php

namespace mapcontent;

/**
 * Class Module
 * @package mapcontent
 */
class Module {

    /**
     * @return mixed
     */
    public function getConfig() {
        return include __DIR__ . '/config/module.config.php';
    }

}
