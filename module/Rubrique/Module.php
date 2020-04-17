<?php

namespace Rubrique;

/**
 * Class Module
 * @package Rubrique
 */
class Module
{
    /**
     * @return mixed
     */
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

}

