<?php

namespace Rubrique\Model;

use Rubrique\Model\Rubrique;
use Application\DBConnection\ParentDao;
use Rubrique\Model\Mapper\RubriqueMapper;

/**
 * Class RubriqueDao
 * @package Rubrique\Model
 */
class RubriqueDao extends ParentDao {

    /**
     * RubriqueDao constructor.
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * @param $spaceId
     * @param $dataType
     * @return mixed|\Rubrique\Model\Rubrique
     */
    public function getFirstRubriqueBySpaceId($spaceId, $dataType) {

        $requete = $this->dbGateway->prepare("
		SELECT id, libelle, rang, scope, spaceId, filename, contactForm, messageForm, updateForm, fileuploadForm, publishing
                FROM rubrique 
                WHERE spaceId = :spaceid AND rang > -1
		        ORDER BY rang
                LIMIT 1
		")or die(print_r($this->dbGateway->error_info()));

        $requete->execute(array(
            'spaceid' => $spaceId
        ));

        $requete2 = $requete->fetch(\PDO::FETCH_ASSOC);
        // print_r($requete2);

        if (strcasecmp($dataType,"object") == 0) {
            //print_r($dataType);
            $mapper = new RubriqueMapper();
            $rubriqueObj = $mapper->exchangeArray($requete2);
            return $rubriqueObj;
        } elseif (strcasecmp($dataType,"array") == 0) {
            return $requete2;
        }
    }


    /**
     * @param $spaceId
     * @param $dataType: array|object
     * @return mixed|\Rubrique\Model\Rubrique
     */
    public function getFirstRubriqueBySpace($spaceId, $dataType) {

        $mapper = new RubriqueMapper();

        $requete = $this->dbGateway->prepare("
		SELECT id, libelle, rang, scope, spaceId, filename, contactForm, messageForm, updateForm, fileuploadForm, publishing
                FROM rubrique 
                WHERE spaceId = :spaceid AND publishing = 1 AND rang > -1
		        ORDER BY rang
                LIMIT 1
		")or die(print_r($this->dbGateway->error_info()));

        $requete->execute(array(
            'spaceid' => $spaceId
        ));

        $requete2 = $requete->fetch(\PDO::FETCH_ASSOC);
        // print_r($requete2);
        if (strcasecmp($dataType,"object") == 0) {
            //print_r($dataType);
            $rubriqueObj = $mapper->exchangeArray($requete2);
            return $rubriqueObj;
        } elseif (strcasecmp($dataType,"array") == 0) {
            return $requete2;
        }
    }

    /**
     * @param $token
     * @param $dataType: array|object
     * @return mixed|\Rubrique\Model\Rubrique
     */
    public function getRubriqueBySpaceToken($token, $dataType) {

        $mapper = new RubriqueMapper();
        $requete = $this->dbGateway->prepare("
		SELECT rub.id, rub.libelle, rub.rang, rub.scope, rub.spaceId, rub.filename, rub.contactForm, rub.messageForm, rub.updateForm, rub.fileuploadForm, rub.publishing
                FROM rubrique rub
                JOIN space s on s.space_id = rub.spaceId
                WHERE s.space_token = :token 
                ORDER BY rub.rang ASC
		LIMIT 1
		")or die(print_r($this->dbGateway->error_info()));

        $requete->execute(array(
            'token' => $token
        ));

        $requete2 = $requete->fetch(\PDO::FETCH_ASSOC);

        if (strcasecmp($dataType,"object") == 0) {

            $rubriqueObj = $mapper->exchangeArray($requete2);
            return $rubriqueObj;
        } elseif (strcasecmp($dataType,"array") == 0) {
            return $requete2;
        }
    }

    /**
     * @param $filename
     * @param $dataType: array|object
     * @return mixed|\Rubrique\Model\Rubrique
     */
    public function getRubriqueByFilename($filename, $dataType) {
        $mapper = new RubriqueMapper();

        $requete = $this->dbGateway->prepare("
		SELECT rub.id, rub.libelle, rub.rang, rub.scope, rub.spaceId, rub.filename, rub.contactForm, rub.messageForm, rub.updateForm, rub.fileuploadForm, rub.publishing
                FROM rubrique rub
                WHERE rub.filename = :filename
                LIMIT 1
		")or die(print_r($this->dbGateway->error_info()));

        $requete->execute(array(
            'filename' => $filename
        ));
        
        $requete2 = $requete->fetch(\PDO::FETCH_ASSOC);
        
        if (strcasecmp($dataType,"object") == 0) {

            $arrayOfRubrique = $mapper->exchangeArray($requete2);
            return $arrayOfRubrique;
        } elseif (strcasecmp($dataType,"array") == 0) {
            return $requete2;
        }
    }

    /**
     * @param $filename
     * @param $dataType: array|object
     * @return mixed|\Rubrique\Model\Rubrique
     */
    public function getPublicRubriqueByFilename($filename, $dataType) {
        $mapper = new RubriqueMapper();

        $requete = $this->dbGateway->prepare("
		SELECT rub.id, rub.libelle, rub.rang, rub.scope, rub.spaceId, rub.filename, rub.contactForm, rub.messageForm, rub.updateForm, rub.fileuploadForm, rub.publishing
                FROM rubrique rub
                WHERE rub.filename = :filename AND rub.spaceId =-1 AND rub.rang > -1 AND rub.publishing = 1
                LIMIT 1
		")or die(print_r($this->dbGateway->error_info()));

        $requete->execute(array(
            'filename' => $filename
        ));

        $requete2 = $requete->fetch(\PDO::FETCH_ASSOC);

        if (strcasecmp($dataType,"object") == 0) {

            $arrayOfRubrique = $mapper->exchangeArray($requete2);
            return $arrayOfRubrique;
        } elseif (strcasecmp($dataType,"array") == 0) {
            return $requete2;
        }
    }

    /**
     * @param $filename
     * @param $dataType: array|object
     * @return mixed|\Rubrique\Model\Rubrique
     */
    public function getPrivateRubriqueByFilename($filename, $dataType) {
        $mapper = new RubriqueMapper();
        $requete = $this->dbGateway->prepare("
		SELECT rub.id, rub.libelle, rub.rang, rub.scope, rub.spaceId, rub.filename, rub.contactForm, rub.messageForm, rub.updateForm, fileuploadForm, publishing
                FROM rubrique rub
                WHERE rub.filename = :filename AND rub.spaceId > 0 AND rub.rang > -1 AND rub.publishing = 1
                LIMIT 1
		")or die(print_r($this->dbGateway->error_info()));

        $requete->execute(array(
            'filename' => $filename
        ));

        $requete2 = $requete->fetch(\PDO::FETCH_ASSOC);

        if (strcasecmp($dataType,"object") == 0) {

            $arrayOfRubrique = $mapper->exchangeArray($requete2);
            return $arrayOfRubrique;
        } elseif (strcasecmp($dataType,"array") == 0) {
            return $requete2;
        }
    }

    /**
     * @param $dataType: array|object
     * @return array|array of Rubrique
     */
    public function getAllRubriques($dataType) {

        $count = 0;
        $mapper = new RubriqueMapper();

        $requete = $this->dbGateway->prepare("
		SELECT id, libelle, rang, scope, spaceId, filename, contactForm, messageForm, updateForm, fileuploadForm, publishing
                FROM rubrique
		ORDER BY spaceId, rang
		")or die(print_r($this->dbGateway->error_info()));

        $requete->execute();

        $requete2 = $requete->fetchAll(\PDO::FETCH_ASSOC);

        if (strcasecmp($dataType,"object") == 0) {
            //Put result in an array of objects
            $arrayOfRubrique = array();

            if (is_array($requete2)) {
                foreach ($requete2 as $value) {
                    //print_r($value);
                    //put code to define an array of objects
                    $arrayOfRubrique[$count] = $mapper->exchangeArray($value);
                    $count++;
                }
            }
            
            return $arrayOfRubrique;
        } elseif (strcasecmp($dataType,"array") == 0) {
            return $requete2;
        }
    }

    /**
     * @param $dataType: array|object
     * @return array|array of Rubrique
     */
    public function getAllPublicAndPublishedRubriques($dataType) {

        $count = 0;
        $mapper = new RubriqueMapper();

        $requete = $this->dbGateway->prepare("
		SELECT id, libelle, rang, scope, spaceId, filename, contactForm, messageForm, updateForm, fileuploadForm, publishing
                FROM rubrique
		ORDER BY spaceId, rang
		")or die(print_r($this->dbGateway->error_info()));

        $requete->execute();

        $requete2 = $requete->fetchAll(\PDO::FETCH_ASSOC);

        if (strcasecmp($dataType,"object") == 0) {
            //Put result in an array of objects
            $arrayOfRubrique = array();

            if (is_array($requete2)) {
                foreach ($requete2 as $value) {
                    //print_r($value);
                    //put code to define an array of objects
                    $arrayOfRubrique[$count] = $mapper->exchangeArray($value);
                    $count++;
                }
            }

            return $arrayOfRubrique;
        } elseif (strcasecmp($dataType,"array") == 0) {
            return $requete2;
        }
    }

    /**
     * @param $spaceId
     * @param $dataType: array|object
     * @return array|array of Rubrique
     */
    public function getAllRubriquesBySpaceId($spaceId, $dataType) {

        $count = 0;
        $mapper = new RubriqueMapper();
        $requete = $this->dbGateway->prepare("
		SELECT id, libelle, rang, scope, spaceId, filename, contactForm, messageForm, updateForm, fileuploadForm, publishing
                FROM rubrique
                WHERE spaceId = :spaceId AND rang > -1
		ORDER BY rang
		")or die(print_r($this->dbGateway->error_info()));

        $requete->execute(array(
            'spaceId' => $spaceId
        ));

        $requete2 = $requete->fetchAll(\PDO::FETCH_ASSOC);

        if (strcasecmp($dataType,"object") == 0) {
            //Put result in an array of objects
            $arrayOfRubrique = array();

            if (is_array($requete2)) {
                foreach ($requete2 as $value) {
                    //print_r($value);
                    //put code to define an array of objects
                    $arrayOfRubrique[$count] = $mapper->exchangeArray($value);
                    $count++;
                }
            }

            return $arrayOfRubrique;
        } elseif (strcasecmp($dataType,"array") == 0) {
            return $requete2;
        }
    }

    /**
     * @param $dataType: array|object
     * @return array|array of Rubrique
     */
    public function getAllRubriquesForAllPrivateSpaces($dataType) {

        $count = 0;
        $mapper = new RubriqueMapper();
        $requete = $this->dbGateway->prepare("
		SELECT id, libelle, rang, scope, spaceId, filename, contactForm, messageForm, updateForm, fileuploadForm, publishing
                FROM rubrique
                WHERE spaceId > -1
		ORDER BY spaceId, rang
		")or die(print_r($this->dbGateway->error_info()));

        $requete->execute();

        $requete2 = $requete->fetchAll(\PDO::FETCH_ASSOC);

        if (strcasecmp($dataType,"object") == 0) {
            //Put result in an array of objects
            $arrayOfRubrique = array();

            if (is_array($requete2)) {
                foreach ($requete2 as $value) {
                    //print_r($value);
                    //put code to define an array of objects
                    $arrayOfRubrique[$count] = $mapper->exchangeArray($value);
                    $count++;
                }
            }

            return $arrayOfRubrique;
        } elseif (strcasecmp($dataType,"array") == 0) {
            return $requete2;
        }
    }

    /**
     * @param $id
     * @return \Rubrique\Model\Rubrique
     */
    public function getRubrique($id) {
        $id = (int) $id;
        $mapper = new RubriqueMapper();
        $requete = $this->dbGateway->prepare("
		SELECT id, libelle, rang, scope, spaceId, filename, contactForm, messageForm, updateForm, fileuploadForm, publishing
		FROM rubrique
		WHERE id = :id
		")or die(print_r($this->dbGateway->error_info()));

        $requete->execute(array(
            'id' => $id
        ));

        $requete2 = $requete->fetch(\PDO::FETCH_ASSOC);

        $rubrique = $mapper->exchangeArray($requete2);
        return $rubrique;
    }

    /**
     * @param $rank
     * @param $dataType: array|object
     * @return mixed|\Rubrique\Model\Rubrique
     */
    public function getRubriqueByRang($rank, $dataType) {

        $mapper = new RubriqueMapper();

        $requete = $this->dbGateway->prepare("
		SELECT id, libelle, rang, scope, spaceId, filename, contactForm, messageForm, updateForm, fileuploadForm, publishing
		FROM rubrique
		WHERE rang = :rank
                LIMIT 1
		")or die(print_r($this->dbGateway->error_info()));

        $requete->execute(array(
            'rank' => $rank
        ));

        $requete2 = $requete->fetch(\PDO::FETCH_ASSOC);

        if (strcasecmp($dataType,"object") == 0) {

            $rubrique = $mapper->exchangeArray($requete2[0]);
            return $rubrique;
        } elseif (strcasecmp($dataType,"array") == 0) {
            return $requete2;
        }
    }

    /**
     * @param \Rubrique\Model\Rubrique $rubrique
     * @return int|string
     */
    public function saveRubrique(Rubrique $rubrique) {
        $id = (int) $rubrique->getId();

        if ($id > 0) {

            $requete = $this->dbGateway->prepare("
				UPDATE rubrique 
                                SET libelle= :libelle, rang= :rang, scope = :scope, spaceId = :spaceId, filename = :filename, 
                                contactForm = :contactForm, messageForm = :messageForm, updateForm = :updateForm, fileuploadForm=:fileuploadForm, publishing=:publishing
                                WHERE id = :id
			")or die(print_r($this->dbGateway->errors_info()));

            $requete->execute(array(
                'id' => $id,
                'libelle' => $rubrique->getLibelle(),
                'rang' => $rubrique->getRang(),
                'scope' => $rubrique->getScope(),
                'spaceId' => $rubrique->getSpaceId(),
                'filename' => $rubrique->getFilename(),
                'contactForm' => $rubrique->getHasContactForm(),
                'messageForm' => $rubrique->getHasMessageForm(),
                'updateForm' => $rubrique->getHasUpdateForm(),
                'fileuploadForm' => $rubrique->gethasFileuploadForm(),
                'publishing'=> $rubrique->getPublishing()
            ));
            //var_dump($requete->errorInfo());
            //exit;
        } else {
            $requete = $this->dbGateway->prepare("INSERT into rubrique(libelle, rang, scope, spaceId, filename, contactForm, messageForm, updateForm, fileuploadForm, publishing) 
					values(:libelle, :rang, :scope, :spaceId, :filename, :contactForm, :messageForm, :updateForm, :fileuploadForm, :publishing)")or die(print_r($this->dbGateway->error_info()));

            $requete->execute(array(
                'libelle' => $rubrique->getLibelle(),
                'rang' => $rubrique->getRang(),
                'scope' => $rubrique->getScope(),
                'spaceId' => $rubrique->getSpaceId(),
                'filename' => $rubrique->getFilename(),
                'contactForm' => $rubrique->getHasContactForm(),
                'messageForm' => $rubrique->getHasMessageForm(),
                'updateForm' => $rubrique->getHasUpdateForm(),
                'fileuploadForm' => $rubrique->gethasFileuploadForm(),
                'publishing'=> $rubrique->getPublishing()
            ));

            $id = $this->dbGateway->lastInsertId();
            return $id;
        }
    }

    /**
     * @param $id
     * @return bool
     */
    public function deleteRubrique($id) {

        $id = (int) $id;

        $requete = $this->dbGateway->prepare("
		DELETE FROM rubrique WHERE id = :id
		")or die(print_r($this->dbGateway->error_info()));

        return $requete->execute(array(
            'id' => $id
        ));
    }

}
