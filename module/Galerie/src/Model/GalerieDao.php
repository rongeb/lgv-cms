<?php

namespace Galerie\Model;

use Sousrubrique\Model\Sousrubrique;
use Sousrubrique\Model\Sousrubriquedao;
use Contenu\Model\Contenu;
use Contenu\Model\ContenuDao;
use Contenu\Model\ContenuType;
use Contenu\Model\Mapper\ContenuMapper;

/**
 * Class GalerieDao
 * @package Galerie\Model
 */
class GalerieDao extends ContenuDao {
    /**
     * GalerieDao constructor.
     */
    public function __construct() {
        
        parent::__construct();
    }

    /**
     * @param $dataType
     * @return array|array of Contenu
     */
    public function getAllGaleries($dataType) {
        
        $count = 0;
        $sousrubriqueDao = new Sousrubriquedao();

        $requete = $this->dbGateway->prepare("
		SELECT c.*
		FROM contenu c
                WHERE c.type ='".ContenuType::$galleryItem."' 
                ORDER BY c.sousrubriques_id, c.rang
		")or die(print_r($this->dbGateway->error_info()));

        $requete->execute();

        $requete2 = $requete->fetchAll(\PDO::FETCH_ASSOC);

        if (strcasecmp($dataType,"object") == 0) {
            //Put result in an array of objects
            $arrayOfContenustep1 = array();
            $arrayOfContenustep2 = array();


            if (is_array($requete2)) {
                $contenuMapper = new ContenuMapper();
                foreach ($requete2 as $key => $value) {
                    //print_r($value);
                    //put code to define an array of objects
                    if ($value['sousrubriques_id'] != null && $value['sousrubriques_id'] != "") {

                        $sousrubrique = $sousrubriqueDao->getSousrubrique($value['sousrubriques_id']);

                        $arrayOfContenustep1[$count]['id'] = $value['contenu_id'];
                        $arrayOfContenustep1[$count]['titre'] = $value['titre'];
                        $arrayOfContenustep1[$count]['soustitre'] = $value['soustitre'];
                        $arrayOfContenustep1[$count]['contenu'] = $value['contenuhtml'];
                        $arrayOfContenustep1[$count]['position'] = $value['rang'];
                        $arrayOfContenustep1[$count]['image'] = $value['image'];
                        $arrayOfContenustep1[$count]['image2'] = $value['image2'];
                        $arrayOfContenustep1[$count]['sousrubrique'] = $sousrubrique;

                        $arrayOfContenustep2[$count] = $contenuMapper->exchangeArray($arrayOfContenustep1[$count]);

                        $count++;
                    }
                }
            }
            
            return $arrayOfContenustep2;
             
        }
        elseif (strcasecmp($dataType,"array") == 0) {
            return $requete2;
        }
    }

    /**
     * @param $id
     * @param $limit
     * @param $dataType
     * @return array|array of Contenu
     */
    public function getAllGaleriesByRubrique($id, $limit, $dataType) {
        //public function getAllGaleriesByRubrique($id, $dataType) {
        $count = 0;
        $count2 = -1;
        $sousrubriqueDao = new Sousrubriquedao();

        $requete = $this->dbGateway->prepare("
		SELECT c.*
		FROM contenu c
                JOIN sousrubrique sr on sr.id = c.sousrubriques_id
                JOIN rubrique r on r.id = sr.rubriques_id
                WHERE c.type ='".ContenuType::$galleryItem."' AND r.id = :idrub AND c.rang > -1 AND sr.rang > -1
		ORDER BY sr.rang, c.rang
                LIMIT :limitation
		")or die(print_r($this->dbGateway->error_info()));

        $requete->bindParam(':idrub', $id, \PDO::PARAM_INT);
        $requete->bindParam(':limitation', $limit, \PDO::PARAM_INT);

        $requete->execute();

        $requete2 = $requete->fetchAll(\PDO::FETCH_ASSOC);

        if (strcasecmp($dataType,"object") == 0) {
            //Put result in an array of objects
            $arrayOfContenustep1 = array();
            $arrayOfContenustep2 = array();
            $arrayOfContenustep3 = array();

            $sousrub = "";
            if (is_array($requete2)) {
                $contenuMapper = new ContenuMapper();
                foreach ($requete2 as $key => $value) {

                    //put code to define an array of objects
                    if ($value['sousrubriques_id'] != null && $value['sousrubriques_id'] != "") {

                        if ($sousrub != $value['sousrubriques_id']) {
                            $count2++;
                            $count = 0;
                        }

                        $sousrub = $value['sousrubriques_id'];

                        $arrayOfContenustep1[$count]['id'] = $value['contenu_id'];
                        $arrayOfContenustep1[$count]['titre'] = $value['titre'];
                        $arrayOfContenustep1[$count]['soustitre'] = $value['soustitre'];
                        $arrayOfContenustep1[$count]['contenu'] = $value['contenuhtml'];
                        $arrayOfContenustep1[$count]['position'] = $value['rang'];
                        $arrayOfContenustep1[$count]['image'] = $value['image'];
                        $arrayOfContenustep1[$count]['image2'] = $value['image2'];
                        //$arrayOfContenustep1[$count]['sousrubrique'] = $sousrubrique;

                        $arrayOfContenustep2[$count] = $contenuMapper->exchangeArray($arrayOfContenustep1[$count]);

                        $arrayOfContenustep3[$count2][$count] = $arrayOfContenustep2[$count];
                        //var_dump($arrayOfContenustep3[$count2][$count]);
                        $count++;
                    }
                }
            } 
            return $arrayOfContenustep3;
        }
        elseif (strcasecmp($dataType,"array") == 0) {
           return $requete2;
        }
    }

    /**
     * @param $id
     * @param $limit
     * @param $dataType
     * @return array|array of Contenu
     */
    public function getAllGaleriesByRubriqueName($id, $limit, $dataType) {

        //var_dump($id);
        $count = 0;
        $count2 = -1;
        $sousrubriqueDao = new Sousrubriquedao();

        $requete = $this->dbGateway->prepare("
		SELECT c.*
		FROM contenu c
                JOIN sousrubrique sr on sr.id = c.sousrubriques_id
                JOIN rubrique r on r.id = sr.rubriques_id
                WHERE c.type ='".ContenuType::$galleryItem."' AND r.libelle LIKE :rubName AND c.rang > -1 AND sr.rang > -1
		ORDER BY sr.rang, c.rang
                LIMIT :limit
		")or die(print_r($this->dbGateway->error_info()));

        $requete->execute(array(
            'idrub' => $id,
            'limit' => $limit));

        $requete2 = $requete->fetchAll(\PDO::FETCH_ASSOC);

        //var_dump($requete2);
        //exit();
        if (strcasecmp($dataType,"object") == 0) {
            //Put result in an array of objects
            $arrayOfContenustep1 = array();
            $arrayOfContenustep2 = array();
            $arrayOfContenustep3 = array();

            $sousrub = "";
            if (is_array($requete2)) {
                $contenuMapper = new ContenuMapper();
                foreach ($requete2 as $key => $value) {
                    //print_r($value);
                    //put code to define an array of objects
                    if ($value['sousrubriques_id'] != null && $value['sousrubriques_id'] != "") {

                        //$sousrubrique = $sousrubriqueDao->getSousrubrique($value['sousrubriques_id']);
                        if ($sousrub != $value['sousrubriques_id']) {
                            $count2++;
                            $count = 0;
                        }

                        $sousrub = $value['sousrubriques_id'];

                        $arrayOfContenustep1[$count]['id'] = $value['contenu_id'];
                        $arrayOfContenustep1[$count]['titre'] = $value['titre'];
                        $arrayOfContenustep1[$count]['soustitre'] = $value['soustitre'];
                        $arrayOfContenustep1[$count]['contenu'] = $value['contenuhtml'];
                        $arrayOfContenustep1[$count]['position'] = $value['rang'];
                        $arrayOfContenustep1[$count]['image'] = $value['image'];
                        $arrayOfContenustep1[$count]['image2'] = $value['image2'];
                        //$arrayOfContenustep1[$count]['sousrubrique'] = $sousrubrique;

                        $arrayOfContenustep2[$count] = $contenuMapper->exchangeArray($arrayOfContenustep1[$count]);

                        $arrayOfContenustep3[$count2][$count] = $arrayOfContenustep2[$count];
                        //var_dump($arrayOfContenustep3[$count2][$count]);
                        $count++;
                    }
                }
            }
            
            return $arrayOfContenustep3;
             
        }
        elseif (strcasecmp($dataType,"array") == 0) {
           return $requete2;
        }
    }

    /**
     * @param $id
     * @return Contenu
     */
    public function getGalerieContenu($id) {

        $contenu = $this->getContenu($id);

        return $contenu;
    }

    /**
     * @param $sourubriqueid
     * @param $dataType
     * @return array
     */
    public function getGalerieContenusFromSousrubrique($sourubriqueid, $dataType) {

        $contenu = $this->getContenusBySousrubrique($sourubriqueid, $dataType);

        return $contenu;
    }

    /**
     * @param Contenu $contenu
     */
    public function saveGalerieContenu(Contenu $contenu) {
        $this->saveContenu($contenu);
    }

    /**
     * @param $id
     */
    public function deleteGalerieContenu($id) {

        $this->deleteContenu($id);
    }

}
