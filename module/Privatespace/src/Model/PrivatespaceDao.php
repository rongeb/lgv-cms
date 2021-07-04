<?php

namespace Privatespace\Model;

use Application\DBConnection\ParentDao;
use ExtLib\MCrypt;
use Privatespace\Model\Mapper\PrivatespaceMapper;

/**
 * Class PrivatespaceDao
 * @package Privatespace\Model
 */
class PrivatespaceDao extends ParentDao {

    /**
     * PrivatespaceDao constructor.
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * @param $dataType
     * @return array|array of Privatespace
     */
    public function getAllSpaces($dataType) {

        $mapper = new PrivatespaceMapper();

        $requete = $this->dbGateway->prepare("
		SELECT space_id, space_name, space_token
		FROM space
                ORDER BY space_name
		")or die(print_r($this->dbGateway->error_info()));

        $requete->execute();

        $requete2 = $requete->fetchAll(\PDO::FETCH_ASSOC);

        if (strcasecmp($dataType, "object") == 0) {
            //Put result in an array of objects
            $arrayOfSpaces = array();
            if (is_array($requete2)) {
                foreach ($requete2 as $value) {
                    //put code to define an array of objects
                    if ($value['space_id'] != null && $value['space_name'] != "") {
                        $arrayOfSpaces[] = $mapper->exchangeArray($value);
                    }
                }
            }

            return $arrayOfSpaces;
        } elseif (strcasecmp($dataType, "array") == 0) {
            return $requete2;
        }
    }

    public function getSpace($id) {

        $id = (int) $id;
        $result = array();
        $mapper = new PrivatespaceMapper();

        $requete = $this->dbGateway->prepare("
		SELECT space_id, space_name, space_token
		FROM space
		WHERE space_id = :id
                LIMIT 1
		")or die(print_r($this->dbGateway->error_info()));

        $requete->execute(array(
            'id' => $id
        ));

        $requete2 = $requete->fetch(\PDO::FETCH_ASSOC);

        $result = $mapper->exchangeArray($requete2);

        return $result;
    }

    public function saveSpace(Privatespace $space) {

        $id = (int) $space->getId();

        $token = $this->createToken($id, $space->getName());
        
        if ($id > 0) {

            $requete = $this->dbGateway->prepare("
		UPDATE space SET space_name = :name, space_token = :token WHERE space_id = :id
			")or die(print_r($this->dbGateway->errors_info()));

            $requete->execute(array(
            'id' => $id,
            'name' => $space->getName(),
            'token' => $token
            ));
        } else {

            $requete = $this->dbGateway->prepare("INSERT into space(space_name, space_token) 
					values(:name, :token)")or die(print_r($this->dbGateway->error_info()));

            $requete->execute(array(
                'name' => $space->getName(),
                'token' => $token
            ));
        }
    }

    public function deleteSpace($id) {

        $id = (int) $id;

        $requete = $this->dbGateway->prepare("
		DELETE FROM space WHERE space_id = :id
		")or die(print_r($this->dbGateway->error_info()));

        $requete->execute(array(
            'id' => $id
        ));
    }

    private function createToken($id, $name) {
        $mcrypt = new MCrypt();
        $tokenData = array();
        $tokenData['spaceId']=$id;
        $tokenData['spaceName']=$name;
        $tokenData['timestamp']=time();
        //var_dump($tokenData);
        $token = $mcrypt->encrypt(json_encode($tokenData));
        //var_dump($token);
        //exit;
        return $token;
    }

}
