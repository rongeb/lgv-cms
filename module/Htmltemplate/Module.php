<?php


namespace Htmltemplate;

/**
 * Class Module
 * @package Contenu
 */
class Module {

    /**
     * @return mixed
     */
    public function getConfig() {
        return include __DIR__ . '/config/module.config.php';
    }

}
