<?php

namespace Backofficesearch;

/**
 * Class Module
 * @package Backofficesearch
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