<?php
namespace Blogcontent;

/**
 * Class Module
 * @package Blogcontent
 */
class Module
{
    /**
     * @return mixed
     */
    public function getConfig(){
		return include __DIR__ . '/config/module.config.php';
	}
	
}

