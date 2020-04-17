<?php

namespace Publishing;

/**
 * Class Module
 * @package Publishing
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

