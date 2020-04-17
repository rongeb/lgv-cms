<?php

namespace Loginmgmt;

/**
 * Class Module
 * @package Loginmgmt
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

