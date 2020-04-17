<?php

namespace Privatespace\Model\Mapper;

use Privatespace\Model\Privatespace;

/**
 * Class PrivatespaceMapper
 * @package Privatespace\Model\Mapper
 */
class PrivatespaceMapper
{
    /**
     * @param $data
     * @return Privatespace
     */
    public function exchangeArray($data) {

        $privateSpace = new Privatespace();

        if (isset($data['space_id'])) {
            $privateSpace->setId($data['space_id']);
        }
        if (isset($data['space_name'])) {
            $privateSpace->setName($data['space_name']);
        }
        if (isset($data['space_token'])) {
            $privateSpace->setToken($data['space_token']);
        }

        return $privateSpace;
    }


}