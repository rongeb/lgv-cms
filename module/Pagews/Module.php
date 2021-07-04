<?php

namespace Pagews;

/**
 * Class Module
 * @package Pagews
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