<?php

namespace Loginmgmt\Model;

/**
 * Class Login
 * @package Loginmgmt\Model
 */
class Login {

    protected $id;
    protected $user;
    protected $pwd;
    protected $role;
    protected $csrf;
    protected $honeypot;

    /**
     * Login constructor.
     */
    public function __construct() {}

    /**
     * @param $_id
     */
    public function setId($_id) {
        $this->id = $_id;
    }

    /**
     * @return mixed
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @param $_user
     */
    public function setUser($_user) {
        $this->user = $_user;
    }

    /**
     * @return mixed
     */
    public function getUser() {
        return $this->user;
    }

    /**
     * @param $_pwd
     */
    public function setPwd($_pwd) {
        $this->pwd = $_pwd;
    }

    /**
     * @return mixed
     */
    public function getPwd() {
        return $this->pwd;
    }

    /**
     * @param $_role
     */
    public function setRole($_role) {
        $this->role = $_role;
    }

    /**
     * @return mixed
     */
    public function getRole() {
        return $this->role;
    }

    /**
     * @return mixed
     */
    public function getCsrf() {
        return $this->csrf;
    }

    /**
     * @param $_csrf
     */
    public function setCsrf($_csrf) {
        $this->csrf = $_csrf;
    }

    /**
     * @return mixed
     */
    public function getHoneypot() {
        return $this->honeypot;
    }

    /**
     * @param $_honeypot
     */
    public function setHoneypot($_honeypot) {
        $this->honeypot = $_honeypot;
    }

    /**
     * @return array
     */
    public function getArrayCopy() {
        return get_object_vars($this);
    }

}
