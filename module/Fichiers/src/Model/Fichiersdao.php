<?php

namespace Fichiers\Model;

use Fichiers\Model\Fichiers;
use Application\DBConnection\ParentDao;
use Fichiers\Model\Mapper\FichiersMapper as FilesMapper;

/**
 * Class Fichiersdao
 * @package Fichiers\Model
 */
class Fichiersdao extends ParentDao
{

    /**
     * Fichiersdao constructor.
     */
    public function __construct()
    {

        parent::__construct();

    }

    private static $fields = "fichiers_id, fichiers_chemin, fichiers_nom, fichiers_type, fichiers_libelle, fichiers_meta, fichiers_thumbnailpath, fichiers_thumbnail";

    /**
     * @param $dataType
     * @return array|array of fichiers
     */
    public function getAllFichiers($dataType)
    {

        $count = 0;

        $requete = $this->dbGateway->prepare("
		SELECT " . self::$fields . " 
		FROM fichiers
		ORDER BY fichiers_nom
		") or die(print_r($this->dbGateway->error_info()));

        $requete->execute();

        $requete2 = $requete->fetchAll(\PDO::FETCH_ASSOC);
        if (is_array($requete2)) {
            $filesMapper = new FilesMapper();
            if (strcasecmp($dataType,"object")==0) {
                //Put result in an array of objects
                $arrayOfFichierstep = array();

                foreach ($requete2 as $key => $value) {

                    $arrayOfFichierstep[$count] = $filesMapper->exchangeArray($value);

                    $count++;
                }

                return $arrayOfFichierstep;

            } elseif (strcasecmp($dataType,"array")==0) {
                return $requete2;
            }
            //print_r($arrayOfFichierstep2);
        }
        /*elseif (strcasecmp($dataType,"array")==0) {
            return $requete2;
        }*/
    }

    /**
     * @param $id
     * @return Mapper\Fichiers
     */
    public function getFichiers($id)
    {

        $id = (int)$id;
        $result = array();
        $filesMapper = new FilesMapper();
        $requete = $this->dbGateway->prepare("
		SELECT " . self::$fields . "
		FROM fichiers
		WHERE fichiers_id = :id
		") or die(print_r($this->dbGateway->error_info()));

        $requete->execute(array(
            'id' => $id
        ));

        $requete2 = $requete->fetch(\PDO::FETCH_ASSOC);

        $fichiers = $filesMapper->exchangeArray($requete2);

        return $fichiers;
    }

    /**
     * @param \Fichiers\Model\Fichiers $fichiers
     */
    public function saveFichiers(Fichiers $fichiers)
    {

        $id = (int)$fichiers->getId();

        if ($id > 0) {

            $requete = $this->dbGateway->prepare("
				UPDATE fichiers 
				SET fichiers_libelle 	= :fichiers_libelle,
                                fichiers_meta           = :fichiers_meta
				WHERE fichiers_id 	= :id
			") or die(print_r($this->dbGateway->errors_info()));

            $requete->execute(array(
                'fichiers_libelle' => $fichiers->getLibelle(),
                'fichiers_meta' => $fichiers->getMetaData(),
                'id' => $fichiers->getId()
            ));
        } else {
            //print_r($fichiers);
            //exit;
            $requete = $this->dbGateway->prepare("INSERT into fichiers(fichiers_chemin, fichiers_nom, fichiers_type, fichiers_libelle, fichiers_meta, fichiers_thumbnail, fichiers_thumbnailpath) 
					values(:fichiers_chemin, :fichiers_nom, :fichiers_type, :fichiers_libelle, :fichiers_meta, :fichiers_thumbnail, :fichiers_thumbnailpath)") or die(print_r($this->dbGateway->error_info()));

            $requete->execute(array(
                'fichiers_chemin' => $fichiers->getChemin(),
                'fichiers_nom' => $fichiers->getNom(),
                'fichiers_type' => $fichiers->getType(),
                'fichiers_libelle' => $fichiers->getLibelle(),
                'fichiers_meta' => $fichiers->getMetaData(),
                'fichiers_thumbnail' => $fichiers->getThumbnail(),
                'fichiers_thumbnailpath' => $fichiers->getThumbnailpath()
            ));
        }
    }

    /**
     * @param $id
     * @return bool
     */
    public function deleteFichiers($id)
    {

        $id = (int)$id;
        $requete = $this->dbGateway->prepare("
		DELETE FROM fichiers WHERE fichiers_id = :id
		") or die(print_r($this->dbGateway->error_info()));

        $isDeleted = $requete->execute(array(
            'id' => $id
        ));
        //print_r($isDeleted);
        //exit;
        return $isDeleted;
    }

    /**
     * @param $filename
     * @return bool
     */
    public function deleteFichiersByFilename($filename)
    {
        $requete = $this->dbGateway->prepare("
		DELETE FROM fichiers WHERE fichiers_nom = :filename
		") or die(print_r($this->dbGateway->error_info()));

        $isDeleted = $requete->execute(array(
            'filename' => $filename
        ));
        //print_r($isDeleted);
        //exit;
        return $isDeleted;
    }

    /**
     * @param $filename
     * @return Fichiers
     */
    public function getFichiersByFilename($filename)
    {

        $filesMapper = new FilesMapper();
        $requete = $this->dbGateway->prepare("
		SELECT " . self::$fields ." 
		FROM fichiers
		WHERE fichiers_nom = :filename
                LIMIT 1
		") or die(print_r($this->dbGateway->error_info()));

        $requete->execute(array(
            'filename' => $filename
        ));

        $requete2 = $requete->fetch(\PDO::FETCH_ASSOC);

        $fichiers = $filesMapper->exchangeArray($requete2);

        return $fichiers;
    }

    /**
     * @param \Fichiers\Model\Fichiers $fichiers
     * @return bool
     */
    public function saveFichiersFilename(Fichiers $fichiers)
    {
        $id = (int)$fichiers->getId();
        $result = false;
        if ($id > 0) {

            $requete = $this->dbGateway->prepare("
				UPDATE fichiers 
				SET fichiers_nom 	= :fichiers_nom
                                WHERE fichiers_id 	= :id
			") or die(print_r($this->dbGateway->errors_info()));

            $requete->bindParam(':id', $id, \PDO::PARAM_INT);
            $requete->bindParam(':fichiers_nom', $fichiers->getNom(), \PDO::PARAM_STR);
            $result = $requete->execute();
        }
        //var_dump($result);
        //exit;
        return $result;
    }

}
