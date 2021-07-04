<?php

namespace Privatespacelogin;

/**
 * Class Module
 * @package Privatespacelogin
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
