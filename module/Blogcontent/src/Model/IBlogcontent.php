<?php

namespace Blogcontent\Model;

use Contenu\Model\IContenu;

/**
 * Interface IBlogcontent
 * @package Blogcontent\Model
 */
interface IBlogcontent extends IContenu{

    public function getAuthor();

    public function setAuthor($_author);

    public function getThemes();

    public function setThemes($_themes);
    
    public function getDate();

    public function setDate($_blogDate);

    public function getText1();

    public function setText1($_text1);

    public function getText2();

    public function setText2($_text2);

    public function getText3();

    public function setText3($_text3);
}