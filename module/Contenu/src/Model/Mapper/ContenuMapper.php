<?php

namespace Contenu\Model\Mapper;

use Contenu\Model\Contenu;

/**
 * Class ContenuMapper
 * @package Contenu\Model\Mapper
 */
class ContenuMapper
{
    /**
     * ContenuMapper constructor.
     */
    function __construct()
    {
    }

    /**
     * @param $data
     * @return Contenu
     */
    public function exchangeArray($data) {

        $stdContent = new Contenu();

        if (isset($data['id'])) {
            $stdContent->setId($data['id']);
        }
        if (isset($data['titre'])) {
            $stdContent->setTitre($data['titre']);
        }
        if (isset($data['soustitre'])) {
            $stdContent->setSousTitre($data['soustitre']);
        }
        if (isset($data['contenu'])) {
            $stdContent->setContenuHtml($data['contenu']);
        }
        if (isset($data['position'])) {
            $stdContent->setRang($data['position']);
        }
        if (isset($data['image'])) {
            $stdContent->setImage($data['image']);
        }
        if (isset($data['image2'])) {
            $stdContent->setImage2($data['image2']);
        }
        if (isset($data['sousrubrique'])) {
            $stdContent->setSousRubrique($data['sousrubrique']);
        }
        if (isset($data['type'])) {
            $stdContent->setType($data['type']);
        }

        return $stdContent;
    }
}