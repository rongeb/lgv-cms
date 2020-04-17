<?php

namespace Rubrique\Model;

use Rubrique\Model\Meta;
use Application\DBConnection\ParentDao;

/**
 * Class MetaDao
 * @package Rubrique\Model
 */
class MetaDao extends ParentDao{

    /**
     * MetaDao constructor.
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * @param $idrub
     * @param $dataType: array|object
     * @return array|array of Meta
     */
    public function getAllMetasByRubrique($idrub, $dataType) {

        $count = 0;

        $requete = $this->dbGateway->prepare("
		SELECT * 
                FROM meta
                WHERE rubrique_id = :idrub
		ORDER BY meta_key
		")or die(print_r($this->dbGateway->error_info()));

        $requete->execute(
            array(
              'idrub'=>$idrub   
            ));

        $requete2 = $requete->fetchAll(\PDO::FETCH_ASSOC);

        if ($dataType == "object") {
            //Put result in an array of objects
            $arrayOfMeta = array();

            if (is_array($requete2)) {
                foreach ($requete2 as $value) {
                    //print_r($value);
                    //put code to define an array of objects
                    $arrayOfMeta[$count] = Meta::fromArray($value);
                    $count++;
                }
            }    
            
            return $arrayOfMeta;
            
        }
        elseif ($dataType == "array") {
                return $requete2;
        }
    }

    /**
     * @param $id
     * @return \Rubrique\Model\Meta
     */
    public function getMeta($id) {
        $id = (int) $id;

        $requete = $this->dbGateway->prepare("
		SELECT * 
		FROM meta
		WHERE id = :id
		")or die(print_r($this->dbGateway->error_info()));

        $requete->execute(array(
            'id' => $id
        ));

        $requete2 = $requete->fetch(\PDO::FETCH_ASSOC);

        $meta = Meta::fromArray($requete2);
        return $meta;
    }

    /**
     * @param \Rubrique\Model\Meta $meta
     * @return int|string
     */
    public function saveMeta(Meta $meta) {
        
        $id = (int) $meta->getMetaid();
        $row=0;
        if ($id > 0) {
            var_dump($meta);
            //exit;
            $requete = $this->dbGateway->prepare("
                UPDATE meta SET meta_key= :key, meta_value= :value WHERE meta_id = :id
            ")or die(print_r($this->dbGateway->errors_info()));

            $requete->bindParam(':value', $meta->getMetavalue(), \PDO::PARAM_STR);
            $requete->bindParam(':key', $meta->getMetakey(), \PDO::PARAM_STR);
            $requete->bindParam(':id', $id, \PDO::PARAM_INT);
            
            $requete->execute();
            
            $row=$requete->rowCount();
        } 
        else {

            $requete = $this->dbGateway->prepare("INSERT into meta(meta_key, meta_value, rubrique_id) 
		values(:key, :value, :rubid)")or die(print_r($this->dbGateway->error_info()));

            $requete->execute(array(
                'key' => $meta->getMetakey(),
                'value' => $meta->getMetavalue(),
                'rubid'=>$meta->getRubriqueId()
            ));
            
            $row=$this->dbGateway->lastInsertId();
            
        }

        return $row;
    }

    /**
     * @param $id
     * @return int
     */
    public function deleteMeta($id) {

        $id = (int) $id;
        //echo $id;
        //fonction pour afficher la liste des tracteurs sous forme de tableau
        $requete = $this->dbGateway->prepare("
		DELETE FROM meta WHERE meta_id = :id
		")or die(print_r($this->dbGateway->error_info()));

        $requete->execute(array(
            'id' => $id
        ));
        
        return $requete->rowCount();
    }

}
