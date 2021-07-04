<?php

namespace Linktocontenu\Model;

use Blogcontent\Model\IBlogcontent;
use Contenu\Model\IContenu;
use Sousrubrique\Model\Sousrubrique;
use Rubrique\Model\Rubrique;

/**
 * Class Linktocontenu
 * @package Linktocontenu\Model
 */
class Linktocontenu implements IBlogcontent {

    protected $id;
    protected $position;
    protected $title;
    protected $subtitle;
    protected $section;
    protected $html;
    protected $image;
    protected $image2;
    protected $type;
    protected $author;
    protected $themes;
    protected $linkDate;
    protected $text1;
    protected $text2;
    protected $text3;
    protected $gpsInfoList;
    
    protected $linktopage;
    protected $contenu;
    protected $linktosection;

    /**
     * Linktocontenu constructor.
     */
    public function __construct() {
        
    }

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
     * @param IContenu $_contenu
     */
    public function setContenu(IContenu $_contenu) {
        $this->contenu = $_contenu;
    }

    /**
     * @return mixed
     */
    public function getRang() {
        return $this->position;
    }

    /**
     * @param $_position
     */
    public function setRang($_position) {
        $this->position = $_position;
    }

    /**
     * @return mixed
     */
    public function getContenu() {
        return $this->contenu;
    }

    /**
     * @param $_title
     */
    public function setTitre($_title) {
        $this->title = $_title;
    }

    /**
     * @return mixed
     */
    public function getTitre() {
        return $this->title;
    }

    /**
     * @param $_subtitle
     */
    public function setSousTitre($_subtitle) {
        $this->subtitle = $_subtitle;
    }

    /**
     * @return mixed
     */
    public function getSousTitre() {
        return $this->subtitle;
    }
/*
    public function setRubrique(Rubrique $_page) {
        $this->page = $_page;
    }
    
    public function getRubrique() {
        return $this->page;
    }
*/
    /**
     * @param Sousrubrique $_section
     */
    public function setSousrubrique(SousRubrique $_section) {
        $this->section = $_section;
    }

    /**
     * @return SousRubrique
     */
    public function getSousrubrique() {
        return $this->section;
    }

    /**
     * @return mixed
     */
    public function getContenuHtml() {
        return $this->html;
    }

    /**
     * @param $_html
     */
    public function setContenuHtml($_html) {
        $this->html = $_html;
    }

    /**
     * @return mixed
     */
    public function getImage() {
        return $this->image;
    }

    /**
     * @param $_image
     */
    public function setImage($_image) {
        $this->image = $_image;
    }

    /**
     * @return mixed
     */
    public function getImage2() {
        return $this->image2;
    }

    /**
     * @param $_image2
     */
    public function setImage2($_image2) {
        $this->image2 = $_image2;
    }

    /**
     * @return mixed
     */
    public function getType(){
        return $this->type;
    }

    /**
     * @param $_type
     */
    public function setType($_type) {
        $this->type = $_type;
    }

    /**
     * @return mixed
     */
    public function getLinktopage(){
        return $this->linktopage;
    }

    /**
     * @param $_linktopage
     */
    public function setLinktopage($_linktopage){
        $this->linktopage = $_linktopage;
    }


    /**
     * @return mixed
     */
    public function getLinktosection(){
        return $this->linktosection;
    }
    public function setLinktosection($_linktosection){
        $this->linktosection = $_linktosection;
    }

    /**
     * @return array
     */
    public function getArrayCopy() {
        return get_object_vars($this);
    }


    /**
     * @return mixed
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param $_author
     */
    public function setAuthor($_author)
    {
        $this->author = $_author;
    }

    /**
     * @return mixed
     */
    public function getThemes()
    {
        return $this->themes;
    }

    /**
     * @param $_themes
     */
    public function setThemes($_themes)
    {
        $this->themes = $_themes;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->linkDate;
    }

    /**
     * @param $_linkDate
     */
    public function setDate($_linkDate)
    {
        $this->linkDate = $_linkDate;
    }

    /**
     * @return mixed
     */
    public function getText1()
    {
        return $this->text1;
    }

    /**
     * @param $_text1
     * @return mixed
     */
    public function setText1($_text1)
    {
        return $this->text1;
    }

    /**
     * @return mixed
     */
    public function getText2()
    {
        return $this->text2;
    }

    /**
     * @param $_text2
     */
    public function setText2($_text2)
    {
        $this->text2 = $_text2;
    }

    /**
     * @return mixed
     */
    public function getText3()
    {
        return $this->text3;
    }

    /**
     * @param $_text3
     */
    public function setText3($_text3)
    {
        $this->text3 = $_text3;
    }

    /**
     * @return mixed
     * it is an Std Object with 3 properties:
     * - latitude
     * - longitude
     * - description
     */
    public function getGpsInfoList()
    {
        return $this->gpsInfoList;
    }

    /**
     * @param $_gpsInfoList: associative array with 3 properties
     * - latitude
     * - longitude
     * - description
     * @return json string
     */
    public function setGpsInfoList($_gpsInfoList)
    {
        $gpsInfos = array();
        //print_r($_gpsInfoList);
        //exit;
        foreach($_gpsInfoList as $value) {
            //print_r($value);
            $gpsInfo['latitude'] = $value->latitude;
            $gpsInfo['longitude'] = $value->longitude;
            $gpsInfo['description'] = $value->description;
            array_push($gpsInfos, $gpsInfo);
        }

        return $this->gpsInfoList = json_encode($gpsInfos);
    }
}
