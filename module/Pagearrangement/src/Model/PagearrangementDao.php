<?php

namespace Pagearrangement\Model;

use Rubrique\Model\RubriqueDao;
use Sousrubrique\Model\Sousrubriquedao;
use Sousrubrique\Model\Sousrubrique;
use Contenu\Model\ContenuDao;
use Contenu\Model\Contenu;
use Linktocontenu\Model\LinktocontenuDao;
use Linktocontenu\Model\Linktocontenu;
use Pagearrangement\Model\Pagearrangement;
use Application\DBConnection\ParentDao;
use ExtLib\Utils;

/**
 * Class PagearrangementDao
 * @package Pagearrangement\Model
 */
class PagearrangementDao extends ParentDao{

    /**
     * PagearrangementDao constructor.
     */
    public function __construct() {
        parent::__construct();
    }
    
    private $contenuDao;
    private $linktocontenuDao;
    private $rubriqueDao;
    private $sousRubriqueDao;

    /**
     * @param $rubriqueId
     * @param $order
     * @param $dataType
     * @return array|null|string
     */
    public function getPage($rubriqueId, $order, $dataType) {
        
        $this->rubriqueDao = new RubriqueDao();
        $this->sousRubriqueDao = new Sousrubriquedao();
        $this->contenuDao = new ContenuDao();
        $this->linktocontenuDao = new LinktocontenuDao();
        $sortContentList = new Contenu();
        $sortSectionList = new Sousrubrique();
        
        if(strcmp($dataType, "object")==0 || strcmp($dataType, "json") ==0 || strcmp($dataType, "array") ==0){
            //Pagearrangement object
            $pagearrangement = null;

            //Page (Rubrique)
            $page = $this->rubriqueDao->getRubrique($rubriqueId);

            //List of sections (SousRubrique)
            $sectionsList = $this->sousRubriqueDao->getSousrubriquesByRubrique($rubriqueId, "object");

            $sectionsList = $sortSectionList->sortByPosition($sectionsList, "asc");
            
            $contents = array();
            $contentsLinked = array();
            $sortedContents = array();
            $count = 0;

            //List of contents (Contenu)
            foreach ($sectionsList as $section){
                //Start by contents
                $contents[$count] = $this->contenuDao->getContenusBySousrubrique($section->getId(), "object");

                $isAdded = false;

                //Continue by content linked in another section
                $linktocontenuList = $this->linktocontenuDao->getAllLinktocontenusBySousrubrique($section->getId(), "object");
                foreach ($linktocontenuList as $linktocontenu){
                    $content = $linktocontenu;
                    /*
                    //-1 is the default value that mean, you take the content position
                    if($linktocontenu->getRang() > -1){
                        $content->setRang($linktocontenu->getContenu()->getRang());
                    }
                    */
                    array_push($contentsLinked, $content);
                }

                //push new contents from linktocontenu if they exist
                if(!empty($contentsLinked)){

                    foreach($contentsLinked as $link){
                        array_push($contents[$count], $link);
                    }

                    $isAdded = true;
                }

                //contents from contenu table has been already ordered by rank asc
                if(!empty($contents[$count]) && $isAdded){
                    $sortedContents[] = $sortContentList->sortByPosition($contents[$count], $order);
                }
                else{
                    //$sortedContents[] = $contents[$count];
                    $sortedContents[] = $sortContentList->sortByPosition($contents[$count], $order);
                }

                $count++;
                $isAdded = false;
                $contentsLinked = array();
            }

            //index of the array matches index of sectionsList
            $pagearrangement = new Pagearrangement($page, $sectionsList, $sortedContents);
            
            if(strcmp($dataType, "object")==0){
                return $pagearrangement->getPage();
            }
            elseif(strcmp($dataType, "json")==0){
                return $pagearrangement->to_json();
            }
            elseif(strcmp($dataType, "array")==0){
                return $pagearrangement->to_array();
            }
        }
        return null;
    }

}
