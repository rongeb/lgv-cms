<?php

namespace Loginmgmt\Model;

use Login\Model\LoginDao;
use Loginmgmt\Model\Mapper\LoginMapper;

/**
 * Class LoginmgmtDao
 * @package Loginmgmt\Model
 */
class LoginmgmtDao extends LoginDao {

    /**
     * LoginmgmtDao constructor.
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * @param $dataType: array|object
     * @return array|array of Login
     */
    public function getAllLogin($dataType) {

        $count = 0;

        $requete = $this->dbGateway->prepare("
		SELECT id_access, user_access, pwd_access, role_access
		FROM backofficeaccess
		ORDER BY user_access
		")or die(print_r($this->dbGateway->error_info()));

        $requete->execute();

        $requete2 = $requete->fetchAll(\PDO::FETCH_ASSOC);

        if (strcasecmp($dataType,"object") == 0) {
            //Put result in an array of objects
            $arrayOfUsers = array();
            if (is_array($requete2)) {
                $loginMapper = new LoginMapper();
                foreach ($requete2 as $value) {
                    //put code to define an array of objects
                    if ($value['id_access'] != null && $value['id_access'] != "") {
                        $arrayOfUsers[] = $loginMapper->exchangeArray($value);
                    }
                }
            }
            return $arrayOfUsers;
        } elseif (strcasecmp($dataType,"array") == 0) {
            return $requete2;
        }
    }

    /**
     * @param $id
     * @return array|Login
     */
    public function getLogin($id) {

        $id = (int) $id;
        $result = array();
        $loginMapper = new LoginMapper();
        $requete = $this->dbGateway->prepare("
		SELECT id_access, user_access, pwd_access, role_access
		FROM backofficeaccess
		WHERE id_access = :id
                LIMIT 1
		")or die(print_r($this->dbGateway->error_info()));

        $requete->execute(array(
            'id' => $id
        ));

        $requete2 = $requete->fetch(\PDO::FETCH_ASSOC);

        //var_dump($requete2);
        $result = $loginMapper->exchangeArray($requete2);

        return $result;
    }

    /**
     * @param $username
     * @return int
     */
    public function checkLoginUserame($username){
       
        $requete = $this->dbGateway->prepare("
		SELECT user_access
		FROM backofficeaccess
		WHERE user_access = :username
                ")or die(print_r($this->dbGateway->error_info()));

        $requete->execute(array(
            'username' => $username
        ));

        //$requete2 = $requete->fetch(\PDO::FETCH_ASSOC);
       //
       return $requete->rowCount();
    }

    /**
     * @param Login $login
     */
    public function saveLogin(Login $login) {

        $id = (int) $login->getId();

        if ($id > 0) {

            $requete = $this->dbGateway->prepare("
		UPDATE backofficeaccess SET user_access = :user, pwd_access = :pwd, role_access = :role WHERE id_access = :id
			")or die(print_r($this->dbGateway->errors_info()));

            $requete->execute(array(
                'id' => $id,
                'user' => $login->getUser(),
                'pwd' => $login->getPwd(),
                'role' => $login->getRole()
            ));
        } else {

            $requete = $this->dbGateway->prepare("INSERT into backofficeaccess(user_access, pwd_access, role_access) 
					values(:user, :pwd, :role)")or die(print_r($this->dbGateway->error_info()));

            $requete->execute(array(
                'user' => $login->getUser(),
                'pwd' => $login->getPwd(),
                'role' => $login->getRole()
            ));
        }
    }

    /**
     * @param $id
     */
    public function deleteLogin($id) {

        $id = (int) $id;

        $requete = $this->dbGateway->prepare("
		DELETE FROM backofficeaccess WHERE id_access = :id
		")or die(print_r($this->dbGateway->error_info()));

        $requete->execute(array(
            'id' => $id
        ));
    }

    
}

