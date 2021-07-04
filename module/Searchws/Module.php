<?php

namespace Searchws;

/**
 * Class Module
 * @package Searchws
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