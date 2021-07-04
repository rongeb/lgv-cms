<?php

namespace Sousrubrique\Model;

use Sousrubrique\Model\Sousrubrique;
use Application\DBConnection\ParentDao;
use Rubrique\Model\Rubrique;
use Rubrique\Model\RubriqueDao;
use Sousrubrique\Model\Mapper\SousrubriqueMapper;

/**
 * Class Sousrubriquedao
 * @package Sousrubrique\Model
 */
class Sousrubriquedao extends ParentDao{

    /**
     * Sousrubriquedao constructor.
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * @param $dataType: array|object
     * @return array|array of Sousrubrique
     */
    public function getAllSousrubriques($dataType) {

        $count = 0;
        $rubriqueDao = new RubriqueDao();

        $requete = $this->dbGateway->prepare("
		SELECT *
		FROM sousrubrique ssrub
		ORDER BY rubriques_id, rang
		")or die(print_r($this->dbGateway->error_info()));

        $requete->execute();

        $requete2 = $requete->fetchAll(\PDO::FETCH_ASSOC);

        if (strcasecmp($dataType,"object") == 0) {
            //Put result in an array of objects
            $arrayOfSousrubriquestep1 = array();
            $arrayOfSousrubriquestep2 = array();
            if (is_array($requete2)) {
                $sousRubriqueMapper = new SousrubriqueMapper();
                foreach ($requete2 as $key => $value) {
                    //print_r($value);
                    //put code to define an array of objects
                    if ($value['rubriques_id'] != null && $value['rubriques_id'] != "") {

                        $rubrique = $rubriqueDao->getRubrique($value['rubriques_id']);

                        $arrayOfSousrubriquestep1[$count]['id'] = $value['id'];
                        $arrayOfSousrubriquestep1[$count]['libelle'] = $value['libelle'];
                        $arrayOfSousrubriquestep1[$count]['rang'] = $value['rang'];
                        $arrayOfSousrubriquestep1[$count]['rubrique'] = $rubrique;

                        $arrayOfSousrubriquestep2[$count] = $sousRubriqueMapper->exchangeArray($arrayOfSousrubriquestep1[$count]);

                        $count++;
                    }
                }
            }
            //print_r($arrayOfSousrubriquestep2);
            return $arrayOfSousrubriquestep2;
        } elseif (strcasecmp($dataType,"array") == 0) {
            return $requete2;
        }
    }

    /**
     * @param $rubid
     * @param $dataType: array|object
     * @return array|array of Sousrubrique
     */
    public function getSousrubriquesByRubrique($rubid, $dataType) {

        $count = 0;
        $rubriqueDao = new RubriqueDao();

        $requete = $this->dbGateway->prepare("
		SELECT *
		FROM sousrubrique ssrub
		WHERE rubriques_id = :rubid
		ORDER BY rang
		")or die(print_r($this->dbGateway->error_info()));

        $requete->execute(array(
            'rubid' => $rubid
        ));

        $requete2 = $requete->fetchAll(\PDO::FETCH_ASSOC);

        if (strcasecmp($dataType,"object") == 0) {
            //Put result in an array of objects
            $arrayOfSousrubriquestep1 = array();
            $arrayOfSousrubriquestep2 = array();
            if (is_array($requete2)) {
                $sousRubriqueMapper = new SousrubriqueMapper();
                foreach ($requete2 as $key => $value) {
                    //print_r($value);
                    //put code to define an array of objects
                    if ($value['rubriques_id'] != null && $value['rubriques_id'] != "") {

                        $rubrique = $rubriqueDao->getRubrique($value['rubriques_id']);

                        $arrayOfSousrubriquestep1[$count]['id'] = $value['id'];
                        $arrayOfSousrubriquestep1[$count]['libelle'] = $value['libelle'];
                        $arrayOfSousrubriquestep1[$count]['rang'] = $value['rang'];
                        $arrayOfSousrubriquestep1[$count]['rubrique'] = $rubrique;

                        $arrayOfSousrubriquestep2[$count] = $sousRubriqueMapper->exchangeArray($arrayOfSousrubriquestep1[$count]);

                        $count++;
                    }
                }
            }
            //print_r($arrayOfSousrubriquestep2);
            return $arrayOfSousrubriquestep2;
        } elseif (strcasecmp($dataType,"array") == 0) {
            return $requete2;
        }
    }

    /**
     * @param $rubName
     * @param $dataType: array|object
     * @return array|array of Sousrubrique
     */
    public function getSousrubriquesByRubriqueName($rubName, $dataType) {

        $count = 0;
        $rubriqueDao = new RubriqueDao();

        $requete = $this->dbGateway->prepare("
		SELECT ssrub.*
		FROM sousrubrique ssrub
                JOIN rubrique r on r.id = ssrub.rubriques_id
		WHERE r.libelle = :rubname
		ORDER BY ssrub.rang
		")or die(print_r($this->dbGateway->error_info()));

        $requete->execute(array(
            'rubname' => $rubName
        ));

        $requete2 = $requete->fetchAll(\PDO::FETCH_ASSOC);

        if (strcasecmp($dataType,"object") == 0) {
            //Put result in an array of objects
            $arrayOfSousrubriquestep1 = array();
            $arrayOfSousrubriquestep2 = array();
            if (is_array($requete2)) {
                $sousRubriqueMapper = new SousrubriqueMapper();
                foreach ($requete2 as $key => $value) {
                    //print_r($value);
                    //put code to define an array of objects
                    if ($value['rubriques_id'] != null && $value['rubriques_id'] != "") {

                        $rubrique = $rubriqueDao->getRubrique($value['rubriques_id']);

                        $arrayOfSousrubriquestep1[$count]['id'] = $value['id'];
                        $arrayOfSousrubriquestep1[$count]['libelle'] = $value['libelle'];
                        $arrayOfSousrubriquestep1[$count]['rang'] = $value['rang'];
                        $arrayOfSousrubriquestep1[$count]['rubrique'] = $rubrique;

                        $arrayOfSousrubriquestep2[$count] = $sousRubriqueMapper->exchangeArray($arrayOfSousrubriquestep1[$count]);

                        $count++;
                    }
                }
            }
            //print_r($arrayOfSousrubriquestep2);
            return $arrayOfSousrubriquestep2;
        } elseif (strcasecmp($dataType,"array") == 0) {
            return $requete2;
        }
    }

    /**
     * @param $dataType: array|object
     * @return array|array of Sousrubrique
     */
    public function getSousrubriquesOfFirstRubrique($dataType) {

        $count = 0;
        $rubriqueDao = new RubriqueDao();

        $requete = $this->dbGateway->prepare("
		SELECT ssrub.*
		FROM sousrubrique ssrub
                
		WHERE ssrub.rubriques_id = (SELECT id FROM rubrique
		ORDER BY rang
                LIMIT 1)
		ORDER BY ssrub.rang
		")or die(print_r($this->dbGateway->error_info()));

        $requete->execute();

        $requete2 = $requete->fetchAll(\PDO::FETCH_ASSOC);

        if (strcasecmp($dataType,"object") == 0) {
            //Put result in an array of objects
            $arrayOfSousrubriquestep1 = array();
            $arrayOfSousrubriquestep2 = array();
            if (is_array($requete2)) {
                $sousRubriqueMapper = new SousrubriqueMapper();
                foreach ($requete2 as $key => $value) {
                    //print_r($value);
                    //put code to define an array of objects
                    if ($value['rubriques_id'] != null && $value['rubriques_id'] != "") {

                        $rubrique = $rubriqueDao->getRubrique($value['rubriques_id']);

                        $arrayOfSousrubriquestep1[$count]['id'] = $value['id'];
                        $arrayOfSousrubriquestep1[$count]['libelle'] = $value['libelle'];
                        $arrayOfSousrubriquestep1[$count]['rang'] = $value['rang'];
                        $arrayOfSousrubriquestep1[$count]['rubrique'] = $rubrique;

                        $arrayOfSousrubriquestep2[$count] = $sousRubriqueMapper->exchangeArray($arrayOfSousrubriquestep1[$count]);

                        $count++;
                    }
                }
            }
            //print_r($arrayOfSousrubriquestep2);
            return $arrayOfSousrubriquestep2;
        } elseif (strcasecmp($dataType,"array") == 0) {
            return $requete2;
        }
    }

    /**
     * @param $id
     * @return \Sousrubrique\Model\Sousrubrique
     */
    public function getSousrubrique($id) {

        $id = (int) $id;
        $result = array();

        $rubriqueDao = new RubriqueDao();
        $sousRubriqueMapper = new SousrubriqueMapper();

        $requete = $this->dbGateway->prepare("
		SELECT * 
		FROM sousrubrique
		WHERE id = :id
		")or die(print_r($this->dbGateway->error_info()));

        $requete->execute(array(
            'id' => $id
        ));

        $requete2 = $requete->fetch(\PDO::FETCH_ASSOC);

        $rubrique = $rubriqueDao->getRubrique($requete2['rubriques_id']);

        $Sousrubriquestep1['id'] = $requete2['id'];
        $Sousrubriquestep1['libelle'] = $requete2['libelle'];
        $Sousrubriquestep1['rang'] = $requete2['rang'];
        $Sousrubriquestep1['rubrique'] = $rubrique;

        $sousrubrique = $sousRubriqueMapper->exchangeArray($Sousrubriquestep1);
        //print_r("titi".$sousrubrique);
        return $sousrubrique;
    }

    /**
     * @param \Sousrubrique\Model\Sousrubrique $sousrubrique
     */
    public function saveSousrubrique(Sousrubrique $sousrubrique) {

        $id = (int) $sousrubrique->getId();

        if ($id > 0) {

            $requete = $this->dbGateway->prepare("
				UPDATE sousrubrique SET libelle= :libelle, rang= :rang, rubriques_id = :rub_id WHERE id = :id
			")or die(print_r($this->dbGateway->errors_info()));

            $requete->execute(array(
                'id' => $id,
                'libelle' => $sousrubrique->getLibelle(),
                'rang' => $sousrubrique->getRang(),
                'rub_id' => $sousrubrique->getRubrique()->getId()
            ));
        } else {
            //print_r($sousrubrique);
            //exit;
            $requete = $this->dbGateway->prepare("INSERT into sousrubrique(libelle, rang, rubriques_id) 
					values(:libelle, :rang, :rub_id)")or die(print_r($this->dbGateway->error_info()));

            $requete->execute(array(
                'libelle' => $sousrubrique->getLibelle(),
                'rang' => $sousrubrique->getRang(),
                'rub_id' => $sousrubrique->getRubrique()->getId()
            ));
        }
    }

    /**
     * @param $id
     * @param $position
     * @return bool
     */
    public function updatepositionSousrubrique($id, $position) {

        $id = (int) $id;

        if ($id > 0) {

            $requete = $this->dbGateway->prepare("
				UPDATE sousrubrique SET rang= :position WHERE id = :id
			")or die(print_r($this->dbGateway->errors_info()));

            $result = $requete->execute(array(
                'id' => $id,
                'position' => $position
            ));
            
            return $result;
        } 
        else {
          return false;
        }
    }

    /**
     * @param $id
     */
    public function deleteSousrubrique($id) {

        $id = (int) $id;
        //echo $id;
        //fonction pour afficher la liste des tracteurs sous forme de tableau
        $requete = $this->dbGateway->prepare("
		DELETE FROM sousrubrique WHERE id = :id
		")or die(print_r($this->dbGateway->error_info()));

        $requete->execute(array(
            'id' => $id
        ));
    }

}
