<?php

namespace Privatespace\Model;

/**
 * Class Privatespace
 * @package Privatespace\Model
 */
class Privatespace {

    protected $id;
    protected $name;
    protected $token;

    /**
     * Privatespace constructor.
     */
    public function __construct() {}

    public function setId($_id) {
        $this->id = $_id;
    }

    public function getId() {
        return $this->id;
    }

    public function setName($_name) {
        $this->name = $_name;
    }

    public function getName() {
        return $this->name;
    }
    
    public function getToken(){
        return $this->token;
    }
    
    public function setToken($_token) {
        $this->token = $_token;
    }

}
