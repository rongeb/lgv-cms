<?php

namespace Sousrubrique\Model;

use Rubrique\Model\Rubrique;
use Sousrubrique\Model\Mapper\SousrubriqueMapper as SectionMapper;

/**
 * Class Sousrubrique
 * @package Sousrubrique\Model
 */
class Sousrubrique {

    protected $id;
    protected $libelle;
    protected $rang;
    protected $rubrique;

    /**
     * Sousrubrique constructor.
     */
    public function __construct() {}

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
     * @param $_libelle
     */
    public function setLibelle($_libelle) {
        $this->libelle = $_libelle;
    }

    /**
     * @return mixed
     */
    public function getLibelle() {
        return $this->libelle;
    }

    /**
     * @param $_rang
     */
    public function setRang($_rang) {
        $this->rang = $_rang;
    }

    /**
     * @return mixed
     */
    public function getRang() {
        return $this->rang;
    }

    /**
     * @param Rubrique $_rubrique
     */
    public function setRubrique(Rubrique $_rubrique) {

        $this->rubrique = $_rubrique;
    }

    /**
     * @return mixed
     */
    public function getRubrique() {
        return $this->rubrique;
    }

    /**
     * @return array
     */
    public function getArrayCopy() {
        return get_object_vars($this);
    }

    /**
     * @param $collection
     * @param $order
     * @return sorted collection
     */
    public function sortByPosition($collection, $order){
        /*
        usort($collection, array(__CLASS__, "rankComparison"));
        return $collection;
         * */
        
        if ($order !== 'desc' && $order !== 'asc') {
            return false;
        }
        
        usort($collection, function($a, $b) use ($order) {
            //var_dump((int)$a->getRang().' '.(int)$b->getRang());
            
            if($a instanceof Sousrubrique && $b instanceof Sousrubrique){
                
                if($order === "asc"){
                    //Rank below 0 means content is not displayed so it means
                    //in the back office they have to be the last items in a list
                    if((int)$b->getRang() < 0){
                        $b->setRang("987654321098765432109876543210");
                    }
                    elseif((int)$a->getRang() < 0){
                        $a->setRang("987654321098765432109876543210");
                    }
                    
                    //if rank is equal sort by title
                    if ((int)$a->getRang() == (int)$b->getRang()){
                        return (strcmp($a->getLibelle(), $b->getLibelle())); 
                    }
                    else{
                        return ((int)$a->getRang() < (int)$b->getRang()) ? -1 : 1;
                    }
                }
                elseif($order === "desc"){
                    if ((int)$a->getRang() == (int)$b->getRang()){
                        return (strcmp($b->getLibelle(), $a->getLibelle())); 
                    }

                    return ((int)$b->getRang() < (int)$a->getRang()) ? -1 : 1;
                }
            }
            else{
                //var_dump($a);
                //var_dump($b);
            }
            
        });
        $count = 0;
        foreach ($collection as $item){
            //Except in this function who will put this value ? set -1 wher
            if(strcmp($collection[$count]->getRang(), "987654321098765432109876543210")==0){
                $collection[$count]->setRang("-1");
            }
            
            $count++;
        }
        
        return $collection;
         
    }

}
