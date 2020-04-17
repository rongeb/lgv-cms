<?php

namespace Login\Model;

use Login\Model\Login;
use Application\DBConnection\ParentDao;

/**
 * Class LoginDao
 * @package Login\Model
 */
class LoginDao extends ParentDao{

    /**
     * LoginDao constructor.
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * @param $user
     * @param $password
     * @return string: number of row affected
     */
    public function getAuthenticationByUserAndPwd($user, $password) {

        $requete = $this->dbGateway->prepare("
		SELECT COUNT(*)
		FROM backofficeaccess
		WHERE pwd_access = :pwd and user_access = :user
		")or die(print_r($this->dbGateway->error_info()));

        $requete->execute(array(
            'pwd' => $password,
            'user' => $user
        ));

        $number_of_rows = $requete->fetchColumn();
        //$number_of_rows = $requete->fetchColumn();
        //var_dump($number_of_rows);
        return $number_of_rows;
    }

    /**
     * @param $user
     * @param $password
     * @return string: number of row affected
     */
    public function getRole($user, $password) {

        $requete = $this->dbGateway->prepare("
		SELECT role_access
		FROM backofficeaccess
		WHERE pwd_access = :pwd and user_access = :user
		")or die(print_r($this->dbGateway->error_info()));

        $requete->execute(array(
            'pwd' => $password,
            'user' => $user
        ));

        $number_of_rows = $requete->fetchColumn();

        return $number_of_rows;
    }
}
