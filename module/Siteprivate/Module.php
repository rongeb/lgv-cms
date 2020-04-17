<?php

// module/Album/Module.php

namespace Siteprivate;

/**
 * Class Module
 * @package Siteprivate
 */
class Module {

    /**
     * @return mixed
     */
    public function getConfig() {
        return include __DIR__ . '/config/module.config.php';
    }

}
