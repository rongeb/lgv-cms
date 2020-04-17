<?php

namespace Pagearrangement\Model;

use Rubrique\Model\Rubrique;
use Sousrubrique\Model\Sousrubrique;

/**
 * Class Pagearrangement
 * @package Pagearrangement\Model
 */
class Pagearrangement {
   
    private $pagestructure = array();
    private $page;
    private $sectionsList;
    private $contentsList;
   
    /**
     * 
     * @param type Rubrique $_page
     * @param type Sousrubrique $_sections
     * @param type IContenu $_contentsbysection ordered by section's rank
     */
    public function __construct($_page, $_sections, $_contentspersection) {
        $this->page = $_page;
        $this->sectionsList = $_sections;
        $this->contentsList = $_contentspersection;
        
        $this->pagestructure["page_".$this->page->getId()] = $this->page;
        //var_dump($this->pagestructure);
        //exit;
        $count = 0;
        
        //
        foreach($this->sectionsList as $section){
            
            $this->pagestructure['section_'.$section->getId()] = $section;
            //
            foreach($this->contentsList[$count] as $content){
                $this->pagestructure['content_'.$content->getId()] = $content;
            }
            
            $count++;
        }
       
    }
    
    public function getPage() {
        return $this->pagestructure;
    }
    
    public function to_json(){
        $json = array();
        
        foreach ($this->pagestructure as $key=>$value) {
            
            $nodeType = explode("_", $key);
            
            if(strcmp("content", $nodeType[0])==0){
                
                if ((bool)$value->getId()) {
                    $json["content_".$value->getId()]["content_id"]=$value->getId();
                }
                if ((bool)$value->getTitre()) {
                    $json["content_".$value->getId()]["content_title"] =$value->getTitre();
                }
                if ((bool)$value->getSousTitre()) {
                    $json["content_".$value->getId()]["content_subtitle"]=$value->getSousTitre();
                }
                if ((bool)$value->getContenuHtml()) {
                    $json["content_".$value->getId()]["content_html"]=$value->getContenuHtml();
                }
                if(null != $value->getRang()){
                   $json["content_".$value->getId()]["content_position"]=$value->getRang();
                }
                if ((bool)$value->getImage()) {
                    $json["content_".$value->getId()]["content_image"]=$value->getImage();
                }
                if ((bool)$value->getImage2()) {
                    $json["content_".$value->getId()]["content_image2"]=$value->getImage2();
                }
                if ((bool)$value->getType()) {
                    $json["content_".$value->getId()]["content_type"]=$value->getType();
                }
                if((method_exists($value, 'getAuthor')) && (bool)$value->getAuthor()) {
                    $json["content_".$value->getId()]["content_author"]=$value->getAuthor();
                }
                if((method_exists($value, 'getThemes')) && (bool)$value->getThemes()) {
                    $json["content_".$value->getId()]["content_themes"]=$value->getThemes();
                }
                if((method_exists($value, 'getDate')) && (bool)$value->getDate()) {
                    $json["content_".$value->getId()]["content_date"]=$value->getDate();
                }
                if((method_exists($value, 'getText1')) && (bool)$value->getText1()) {
                    $json["content_".$value->getId()]["content_text1"]=$value->getText1();
                }
                if((method_exists($value, 'getText2')) && (bool)$value->getText2()) {
                    $json["content_".$value->getId()]["content_text2"]=$value->getText2();
                }
                if((method_exists($value, 'getText3')) && (bool)$value->getText3()) {
                    $json["content_".$value->getId()]["content_text3"]=$value->getText3();
                }
                if(method_exists($value,'getGpsInfoList') && (bool)$value->getGpsInfoList()) {
                    $json["content_".$value->getId()]["content_gpsinfolist"]=$value->getGpsInfoList();
                }
               
            }
            elseif (strcmp("section", $nodeType[0])==0){
                
                if((bool)$value->getId()){
                    $json["section_".$value->getId()]["section_id"]=$value->getId();
                }
                if((bool)$value->getLibelle()){
                    $json["section_".$value->getId()]["section_title"] =$value->getLibelle();
                }
                if(null != $value->getRang()){
                    $json["section_".$value->getId()]["section_position"]=$value->getRang();
                }
                
            }
            elseif(strcmp("page", $nodeType[0])==0){
               
                if((bool)$value->getId()){
                    $json["page_".$value->getId()]["page_id"]=$value->getId();
                }
                if((bool)$value->getLibelle()){
                    $json["page_".$value->getId()]["page_title"] =$value->getLibelle();
                }
                if(null != $value->getRang()){
                    $json["page_".$value->getId()]["page_position"]=$value->getRang();
                }  
            }
        
        }
        //var_dump($json);
        //exit;
        return json_encode($json);
    }
    
    public function to_array(){
        $myArray = array();
        
        foreach ($this->pagestructure as $key=>$value) {
            
            $nodeType = explode("_", $key);
            
            if(strcmp("content", $nodeType[0])==0){
                
                if ((bool)$value->getId()) {
                    $myArray["content_".$value->getId()]["content_id"]=$value->getId();
                }
                if ((bool)$value->getTitre()) {
                    $myArray["content_".$value->getId()]["content_title"] =$value->getTitre();
                }
                if ((bool)$value->getSousTitre()) {
                    $myArray["content_".$value->getId()]["content_subtitle"]=$value->getSousTitre();
                }
                if ((bool)$value->getContenuHtml()) {
                    $myArray["content_".$value->getId()]["content_html"]=$value->getContenuHtml();
                }
                if(null != $value->getRang()){
                   $myArray["content_".$value->getId()]["content_position"]=$value->getRang();
                }
                if ((bool)$value->getImage()) {
                    $myArray["content_".$value->getId()]["content_image"]=$value->getImage();
                }
                if ((bool)$value->getImage2()) {
                    $myArray["content_".$value->getId()]["content_image2"]=$value->getImage2();
                }
                if ((bool)$value->getType()) {
                    $myArray["content_".$value->getId()]["content_type"]=$value->getType();
                }
                if((method_exists($value, 'getAuthor')) && (bool)$value->getAuthor()) {
                    $myArray["content_".$value->getId()]["content_author"]=$value->getAuthor();
                }
                if((method_exists($value, 'getThemes')) && (bool)$value->getThemes()) {
                    $myArray["content_".$value->getId()]["content_themes"]=$value->getThemes();
                }
                if((method_exists($value, 'getDate')) && (bool)$value->getDate()) {
                    $myArray["content_".$value->getId()]["content_date"]=$value->getDate();
                }
                if((method_exists($value, 'getText1')) && (bool)$value->getText1()) {
                    $myArray["content_".$value->getId()]["content_text1"]=$value->getText1();
                }
                if((method_exists($value, 'getText2')) && (bool)$value->getText2()) {
                    $myArray["content_".$value->getId()]["content_text2"]=$value->getText2();
                }
                if((method_exists($value, 'getText3')) && (bool)$value->getText3()) {
                    $myArray["content_".$value->getId()]["content_text3"]=$value->getText3();
                }
                if(method_exists($value,'getGpsInfoList') && (bool)$value->getGpsInfoList()) {
                    $myArray["content_".$value->getId()]["content_gpsinfolist"]=$value->getGpsInfoList();
                }
               
            }
            elseif (strcmp("section", $nodeType[0])==0){
                
                if((bool)$value->getId()){
                    $myArray["section_".$value->getId()]["section_id"]=$value->getId();
                }
                if((bool)$value->getLibelle()){
                    $myArray["section_".$value->getId()]["section_title"] =$value->getLibelle();
                }
                if(null != $value->getRang()){
                    $myArray["section_".$value->getId()]["section_position"]=$value->getRang();
                }
                
            }
            elseif(strcmp("page", $nodeType[0])==0){
               
                if((bool)$value->getId()){
                    $myArray["page_".$value->getId()]["page_id"]=$value->getId();
                }
                if((bool)$value->getLibelle()){
                    $myArray["page_".$value->getId()]["page_title"] =$value->getLibelle();
                }
                if(null != $value->getRang()){
                    $myArray["page_".$value->getId()]["page_position"]=$value->getRang();
                }  
            }
        
        }
        //var_dump($myArray);
        //exit;
        return $myArray;
    }

}
