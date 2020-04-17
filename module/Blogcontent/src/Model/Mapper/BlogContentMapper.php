<?php

namespace Blogcontent\Model\Mapper;

use Blogcontent\Model\Blogcontent;
use Contenu\Model\Mapper\ContenuMapper;

/**
 * Class BlogContentMapper
 * @package Blogcontent\Model\Mapper
 */
class BlogContentMapper
{

    /**
     * BlogContentMapper constructor.
     */
    public function __construct()
    {
    }

    /**
     * @param $data
     * @return Blogcontent
     */
    public function exchangeArray($data) {

        $blogcontent = new Blogcontent();

        if (isset($data['id'])) {
            $blogcontent->setId($data['id']);
        }
        if (isset($data['titre'])) {
            $blogcontent->setTitre($data['titre']);
        }
        if (isset($data['soustitre'])) {
            $blogcontent->setSousTitre($data['soustitre']);
        }
        if (isset($data['contenu'])) {
            $blogcontent->setContenuHtml($data['contenu']);
        }
        if (isset($data['position'])) {
            $blogcontent->setRang($data['position']);
        }
        if (isset($data['image'])) {
            $blogcontent->setImage($data['image']);
        }
        if (isset($data['image2'])) {
            $blogcontent->setImage2($data['image2']);
        }
        if (isset($data['sousrubrique'])) {
            $blogcontent->setSousRubrique($data['sousrubrique']);
        }
        if (isset($data['type'])) {
            $blogcontent->setType($data['type']);
        }
        if (isset($data['author'])) {
            $blogcontent->setAuthor($data['author']);
        }
        if (isset($data['themes'])) {
            $blogcontent->setThemes($data['themes']);
        }
        if (isset($data['blogdate'])) {
            $blogcontent->setDate($data['blogdate']);
        }
        if (isset($data['text1'])) {
            $blogcontent->setText1($data['text1']);
        }
        if (isset($data['text2'])) {
            $blogcontent->setText2($data['text2']);
        }
        if (isset($data['text3'])) {
            $blogcontent->setText3($data['text3']);
        }

        return $blogcontent;
    }

    /**
     * @param $data
     * @return array
     */
    public function to_json($data){
        $json = array();
        $count =0;
        foreach ($data as $value) {

            if (isset($value['contenu_id'])) {
                $json[$count]["blogid"]=$value['contenu_id'];
            }
            if (isset($value['titre'])) {
                $json[$count]["blogtitre"] =$value['titre'];
            }
            if (isset($value['soustitre'])) {
                $json[$count]["blogsoustitre"]=$value['soustitre'];
            }
            if (isset($value['contenuhtml'])) {
                $json[$count]["blogcontenu"]=$value['contenuhtml'];
            }
            if (isset($value['rang'])) {
                $json[$count]["blogposition"]=$value['rang'];
            }
            if (isset($value['image'])) {
                $json[$count]["blogimage"]=$value['image'];
            }
            if (isset($value['image2'])) {
                $json[$count]["blogimage2"]=$value['image2'];
            }
            if (isset($value['sousrubriques_id'])) {
                $json[$count]["blogsousrubrique"]=$value['sousrubriques_id'];
            }
            if (isset($value['type'])) {
                $json[$count]["blogtype"]=$value['type'];
            }
            if (isset($value['author'])) {
                $json[$count]["blogauthor"]=$value['author'];
            }
            if (isset($value['themes'])) {
                $json[$count]["blogthemes"]=$value['themes'];
            }
            if (isset($value['contenu_date'])) {
                $json[$count]["blogdate"]=$value['contenu_date'];
            }
            if (isset($value['othertext1'])) {
                $json[$count]["blogtext1"]=$value['othertext1'];
            }
            if (isset($value['othertext2'])) {
                $json[$count]["blogtext2"]=$value['othertext2'];
            }
            if (isset($value['othertext3'])) {
                $json[$count]["blogtext3"]=$value['othertext3'];
            }
            $count++;
        }

        return $json;
    }

    public function exchangeForm($data) {

        return self::exchangeArray($data);
    }
}