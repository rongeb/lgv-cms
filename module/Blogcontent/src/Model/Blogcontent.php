<?php

namespace Blogcontent\Model;

use Contenu\Model\Contenu;
use Sousrubrique\Model\Sousrubrique;
use Blogcontent\Model\IBlogcontent;

/**
 * Class Blogcontent
 * @package Blogcontent\Model
 */
class Blogcontent extends Contenu implements IBlogcontent{

    protected $author;
    protected $themes;
    protected $blogDate;
    protected $text1;
    protected $text2;
    protected $text3;

    /**
     * Blogcontent constructor.
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * @return mixed
     */
    public function getAuthor(){
        return $this->author;
    }

    /**
     * @param $_author
     */
    public function setAuthor($_author){
        $this->author=$_author;
    }

    /**
     * @return mixed
     */
    public function getThemes(){
        return $this->themes;
    }

    /**
     * @param $_themes
     */
    public function setThemes($_themes){
        $this->themes=$_themes;
    }

    /**
     * @return mixed
     */
    public function getDate(){
        return $this->blogDate;
    }

    /**
     * @param $_blogDate
     */
    public function setDate($_blogDate){
        $this->blogDate=$_blogDate;
    }

    /**
     * @return mixed
     */
    public function getText1(){
        return $this->text1;
    }

    /**
     * @param $_text1
     */
    public function setText1($_text1){
        $this->text1=$_text1;
    }

    /**
     * @return mixed
     */
    public function getText2(){
        return $this->text2;
    }

    /**
     * @param $_text2
     */
    public function setText2($_text2){
        $this->text2=$_text2;
    }

    /**
     * @return mixed
     */
    public function getText3(){
        return $this->text3;
    }

    /**
     * @param $_text3
     */
    public function setText3($_text3){
        $this->text3=$_text3;
    }

    /**
     * @return array
     */
    public function getArrayCopy() {
       return get_object_vars($this);
    }

}
