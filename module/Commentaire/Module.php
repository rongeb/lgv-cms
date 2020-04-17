<?php

namespace Commentaire;

/**
 * Class Module
 * @package Commentaire
 */
class Module {

    /**
     * @return mixed
     */
    public function getConfig() {
        return include __DIR__ . '/config/module.config.php';
    }

}
