<?php

namespace Loginmgmt\Model\Mapper;

use Loginmgmt\Model\Login;

/**
 * Class LoginMapper
 * @package Loginmgmt\Model\Mapper
 */
class LoginMapper
{
    /**
     * @param $data
     * @return Login
     */
    public function exchangeArray($data) {

        $login = new Login();

        if (isset($data['id_access'])) {
            $login->setId($data['id_access']);
        }
        if (isset($data['user_access'])) {
            $login->setUser($data['user_access']);
        }
        if (isset($data['pwd_access'])) {
            $login->setPwd($data['pwd_access']);
        }
        if (isset($data['role_access'])) {
            $login->setRole($data['role_access']);
        }
        if (isset($data['csrf_access'])) {
            $login->setCsrf($data['csrf_access']);
        }
        if (isset($data['honeypot_access'])) {
            $login->setHoneypot($data['honeypot_access']);
        }

        return $login;
    }

    /**
     * @param $data
     * @return Login
     */
    public function exchangeForm($data) {

        $login = new Login();

        if (isset($data['id'])) {
            $login->setId($data['id']);
        }
        if (isset($data['username'])) {
            $login->setUser($data['username']);
        }
        if (isset($data['password'])) {
            $login->setPwd($data['password']);
        }
        if (isset($data['prevent'])) {
            $login->setCsrf($data['prevent']);
        }
        if (isset($data['sweethoney'])) {
            $login->setHoneypot($data['sweethoney']);
        }

        return $login;
    }
}