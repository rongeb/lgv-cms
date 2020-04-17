<?php

namespace Linktocontenu\Model\Mapper;

use Linktocontenu\Model\Linktocontenu as LinkedContent;

/**
 * Class LinktocontenuMapper
 * @package Linktocontenu\Model\Mapper
 */
class LinktocontenuMapper
{
    /**
     * @param $data
     * @return LinkedContent
     */
    public function exchangeArray($data) {

        $linkedContent = new LinkedContent();

        if (isset($data['id'])) {
            $linkedContent->setId($data['id']);
        }
        if (isset($data['contenuobj'])) {
            $linkedContent->setContenu($data['contenuobj']);
        }
        if (isset($data['position'])) {
            $linkedContent->setRang($data['position']);
        }
        if (isset($data['title'])) {
            $linkedContent->setTitre($data['title']);
        }
        if (isset($data['subtitle'])) {
            $linkedContent->setSousTitre($data['subtitle']);
        }
        /*
        if (isset($data['page'])){
            $linkedContent->setRubrique($data['page']);
        }
         *
         */
        if (isset($data['section'])) {
            $linkedContent->setSousrubrique($data['section']);
        }
        if (isset($data['html'])) {
            $linkedContent->setContenuHtml($data['html']);
        }
        if (isset($data['image'])) {
            $linkedContent->setImage($data['image']);
        }
        if (isset($data['image2'])) {
            $linkedContent->setImage2($data['image2']);
        }
        if(isset($data['type'])){
            $linkedContent->setType($data['type']);
        }

        if (isset($data['author'])) {
            $linkedContent->setAuthor($data['author']);
        }
        if (isset($data['themes'])) {
            $linkedContent->setThemes($data['themes']);
        }
        if (isset($data['blogdate'])) {
            $linkedContent->setDate($data['blogdate']);
        }
        if (isset($data['text1'])) {
            $linkedContent->setText1($data['text1']);
        }
        if (isset($data['text2'])) {
            $linkedContent->setText2($data['text2']);
        }
        if (isset($data['text3'])) {
            $linkedContent->setText3($data['text3']);
        }

        if (isset($data['gps_coordinates'])) {
            // always null
            $linkedContent->setGpsInfoList(null);
        }
        if (isset($data['linktopage'])) {
            $linkedContent->setLinktopage($data['linktopage']);
        }
        if (isset($data['linktosection'])) {
            $linkedContent->setLinktosection($data['linktosection']);
        }
        //var_dump($linkedContent);
        //exit;
        return $linkedContent;
    }
}