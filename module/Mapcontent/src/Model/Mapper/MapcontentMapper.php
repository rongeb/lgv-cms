<?php

namespace Mapcontent\Model\Mapper;

use Mapcontent\Model\Mapcontent;

/**
 * Class MapcontentMapper
 * @package Mapcontent\Model\Mapper
 */
class MapcontentMapper
{
    /**
     * MapcontentMapper constructor.
     */
    function __construct()
    {
    }

    /**
     * @param $data
     * @return Mapcontent
     */
    public function exchangeArray($data) {

        $mapContent = new Mapcontent();

        if (isset($data['id'])) {
            $mapContent->setId($data['id']);
        }
        if (isset($data['titre'])) {
            $mapContent->setTitre($data['titre']);
        }
        if (isset($data['soustitre'])) {
            $mapContent->setSousTitre($data['soustitre']);
        }
        if (isset($data['contenu'])) {
            $mapContent->setContenuHtml($data['contenu']);
        }
        if (isset($data['position'])) {
            $mapContent->setRang($data['position']);
        }
        if (isset($data['image'])) {
            $mapContent->setImage($data['image']);
        }
        if (isset($data['image2'])) {
            $mapContent->setImage2($data['image2']);
        }
        if (isset($data['sousrubrique'])) {
            $mapContent->setSousRubrique($data['sousrubrique']);
        }
        if (isset($data['type'])) {
            $mapContent->setType($data['type']);
        }
        if (isset($data['gps_coordinates'])) {
            $mapContent->setGpsInfoList(json_decode($data['gps_coordinates']));
        }

        return $mapContent;
    }
}