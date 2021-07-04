<?php

namespace Commentaire\Model;

use Application\DBConnection\ParentDao;
use Commentaire\Model\Commentaire;
use Commentaire\Model\Mapper\CommentaireMapper;

/**
 * Class CommentaireDao
 * @package Commentaire\Model
 */
class CommentaireDao extends ParentDao{

    /**
     * CommentaireDao constructor.
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * @param $dataType
     * @return array|array of Commentaire
     */
    public function getAllCommentaires($dataType) {

        $count = 0;
        $mapper = new CommentaireMapper();

        $requete = $this->dbGateway->prepare("
		SELECT m.commentaire_id, m.commentaire_msg, m.commentaire_row1, m.commentaire_row2, m.commentaire_row3, m.commentaire_row4, m.commentaire_position, m.commentaire_type, m.commentaire_date, m.commentaire_status, m.commentaire_contenuid
		FROM commentaire m
		ORDER BY commentaire_contenuid, m.commentaire_date desc  
		")or die(print_r($this->dbGateway->error_info()));

        $requete->execute();

        $requete2 = $requete->fetchAll(\PDO::FETCH_ASSOC);

        if (strcasecmp($dataType,"object") == 0) {
            //Put result in an array of objects
            $arrayOfCommentairestep1 = array();
            
            foreach ($requete2 as $key => $value) {
                
                $arrayOfCommentairestep1[$count] = $mapper->exchangeArray($value);

                $count++;
            }
            
            return $arrayOfCommentairestep1;
        } elseif (strcasecmp($dataType,"array") == 0) {
            return $requete2;
        }
    }

    /**
     * @param $id
     * @return \Commentaire\Model\Commentaire
     */
    public function getCommentaire($id) {

        $id = (int) $id;
        $mapper = new CommentaireMapper();

        $requete = $this->dbGateway->prepare("
		SELECT *
		FROM commentaire m
                WHERE m.commentaire_id = :id
		")or die(print_r($this->dbGateway->error_info()));

        $requete->execute(array(
            'id' => $id
        ));

        $requete2 = $requete->fetch(\PDO::FETCH_ASSOC);
        
        $commentaire = $mapper->exchangeArray($requete2);

        return $commentaire;
    }

    /**
     * @param $type
     * @param $status
     * @param $size
     * @param $dataType
     * @return array|array of Commentaire
     */
    public function getCommentairesByType($type, $status, $size, $dataType) {

        $count = 0;
        $mapper = new CommentaireMapper();

        $requete = $this->dbGateway->prepare("
		SELECT m.commentaire_id, m.commentaire_msg, m.commentaire_row1, m.commentaire_row2, m.commentaire_row3, m.commentaire_row4, m.commentaire_position, m.commentaire_type, m.commentaire_date, m.commentaire_status, m.commentaire_contenuid
		FROM commentaire m
		WHERE m.commentaire_type = :type AND m.commentaire_status = :status
		ORDER BY m.commentaire_type, m.commentaire_position
                LIMIT :size
                ")or die(print_r($this->dbGateway->error_info()));

        $requete->execute(array(
            'type' => $type,
            'status' => $status,
            'size' => $size
        ));

        $requete2 = $requete->fetchAll(\PDO::FETCH_ASSOC);

        if (strcasecmp($dataType,"object") == 0) {
            //Put result in an array of objects
            $arrayOfCommentairestep1 = array();
            //$arrayOfCommentairestep2 = array();
            //foreach($requete2 as $value){
            foreach ($requete2 as $key => $value) {
                
                $arrayOfCommentairestep1[$count] = $mapper->exchangeArray($value);

                $count++;
            }
            //print_r($arrayOfCommentairestep2);
            return $arrayOfCommentairestep1;
        } elseif (strcasecmp($dataType,"array") == 0) {
            return $requete2;
        }
    }

    /**
     * @param $rubriqueid
     * @param $status
     * @param $dataType
     * @return array|array of Commentaires
     */
    public function getCommentairesByRubrique($rubriqueid, $status, $dataType) {

        $mapper = new CommentaireMapper();

        $requete = $this->dbGateway->prepare("
		SELECT com.commentaire_id, com.commentaire_msg, com.commentaire_row1, com.commentaire_row2, com.commentaire_row3, com.commentaire_row4, com.commentaire_position, com.commentaire_type, com.commentaire_date, com.commentaire_status, com.commentaire_contenuid
		FROM rubrique r
                LEFT JOIN sousrubrique sr on sr.rubriques_id = r.id
                LEFT JOIN contenu c on c.sousrubriques_id = sr.id
                LEFT JOIN commentaire com on com.commentaire_contenuid = c.contenu_id
		WHERE r.id = :rubriqueid AND commentaire_status = :status
		ORDER BY com.commentaire_contenuid, com.commentaire_date DESC
                ")or die(print_r($this->dbGateway->error_info()));

        $requete->execute(array(
            'rubriqueid' => $rubriqueid,
            'status' => $status
        ));

        $requete2 = $requete->fetchAll(\PDO::FETCH_ASSOC);
         
        if (strcasecmp($dataType,"object") == 0) {
            //Put result in an array of objects
            $arrayOfCommentairestep1 = array();
            
            if(is_array($requete2)){
                $count=0;
                foreach ($requete2 as $key => $value) {
                    $arrayOfCommentairestep1[$count] = $mapper->exchangeArray($value);
                    $count++;
                }
            }
            //print_r($arrayOfCommentairestep2);
            return $arrayOfCommentairestep1;
        } 
        elseif (strcasecmp($dataType,"array") == 0) {
            return $requete2;
        }
    }

    /**
     * @param $contenuid
     * @param $status
     * @param $dataType
     * @return array|array of Commentaires
     */
    public function getCommentairesByContenu($contenuid, $status, $dataType) {

        $mapper = new CommentaireMapper();

        $requete = $this->dbGateway->prepare("
		SELECT m.commentaire_id, m.commentaire_msg, m.commentaire_row1, m.commentaire_row2, m.commentaire_row3, m.commentaire_row4, m.commentaire_position, m.commentaire_type, m.commentaire_date, m.commentaire_status, m.commentaire_contenuid
		FROM commentaire m
		WHERE m.commentaire_contenuid = :contenuid AND commentaire_status = :status
		ORDER BY m.commentaire_contenuid, m.commentaire_date DESC
                ")or die(print_r($this->dbGateway->error_info()));

        $requete->execute(array(
            'contenuid' => $contenuid,
            'status' => $status
        ));

        $requete2 = $requete->fetchAll(\PDO::FETCH_ASSOC);
         
        if (strcasecmp($dataType,"object") == 0) {
            //Put result in an array of objects
            $arrayOfCommentairestep1 = array();
            
            if(is_array($requete2)){
                $count=0;
                foreach ($requete2 as $key => $value) {
                    $arrayOfCommentairestep1[$count] = $mapper->exchangeArray($value);
                    $count++;
                }
            }
            //print_r($arrayOfCommentairestep2);
            return $arrayOfCommentairestep1;
        } 
        elseif (strcasecmp($dataType,"array") == 0) {
            return $requete2;
        }
    }

    /**
     * @param \Commentaire\Model\Commentaire $commentaire
     * @return bool
     */
    public function saveCommentaire(Commentaire $commentaire) {

        $id = (int) $commentaire->getId();
        
        if (!(bool)($commentaire->getRow1())) {
            $commentaire->setRow1("");
        }
        if (!(bool)($commentaire->getRow2())) {
            $commentaire->setRow2("");
        }
        if (!(bool)($commentaire->getRow3())) {
            $commentaire->setRow3("");
        }
        if (!(bool)($commentaire->getRow4())) {
            $commentaire->setRow4("");
        }
        if (!(bool)($commentaire->getMessage())) {
            $commentaire->setMessage("");
        }
        if (!(bool)($commentaire->getType())) {
            $commentaire->setType("blog");
        }
        if (!(bool)($commentaire->getRang())) {
            $commentaire->setRang(0);
        }
        if (!(bool)($commentaire->getDate())) {
            $commentaire->setDate(time());
        }
        if (!(bool)($commentaire->getCommentaireStatut())) {
            $commentaire->setCommentaireStatut(0);
        }
        if (!(bool)($commentaire->getType())) {
            $commentaire->setType("");
        }
        if (!(bool)($commentaire->getContenuId())) {
            $commentaire->setContenuId(0);
        }
        
        if ($id > 0) {

            $requete = $this->dbGateway->prepare("
				UPDATE commentaire 
				SET commentaire_row1 = :row1, 
				commentaire_row2 = :row2,
				commentaire_row3 = :row3,
				commentaire_row4 = :row4,
                                commentaire_msg = :msg,
                                commentaire_status = :status,
                                commentaire_contenuid = :contenuid,
                                commentaire_type = :type,
                                commentaire_date = :datemsg
				WHERE commentaire_id = :id
			")or die(print_r($this->dbGateway->errors_info()));

            $info = $requete->execute(array(
                'id' => $id,
                'row1' => $commentaire->getRow1(),
                'row2' => $commentaire->getRow2(),
                'row3' => $commentaire->getRow3(),
                'row4' => $commentaire->getRow4(),
                'msg' => $commentaire->getMessage(),
                'type' => $commentaire->getType(),
                'status' => $commentaire->getCommentaireStatut(),
                'contenuid' => $commentaire->getContenuId(),
                'datemsg' => $commentaire->getDate()
            ));

            return $info;
        } else {
            
            $requete = $this->dbGateway->prepare("INSERT into commentaire("
                    . "commentaire_row1, "
                    . "commentaire_row2, "
                    . "commentaire_row3, "
                    . "commentaire_row4,  "
                    . "commentaire_msg, "
                    . "commentaire_type, "
                    . "commentaire_date, "
                    . "commentaire_status, "
                    . "commentaire_contenuid) "
                    . "values("
                    . ":rowa, "
                    . ":rowb, "
                    . ":rowc, "
                    . ":rowd, "
                    . ":msg, "
                    . ":typeMsg, "
                    . ":datemsg, "
                    . ":status, "
                    . ":contenuid)")
                    or die(print_r($this->dbGateway->error_info()));
                 
            $info = $requete->execute(array(
                'rowa' => $commentaire->getRow1(),
                'rowb' => $commentaire->getRow2(),
                'rowc' => $commentaire->getRow3(),
                'rowd' => $commentaire->getRow4(),
                'msg' => $commentaire->getMessage(),
                'typeMsg' => $commentaire->getType(),
                'status' => $commentaire->getCommentaireStatut(),
                'contenuid' => $commentaire->getContenuId(),
                'datemsg' => $commentaire->getDate()
            ));

            return $info;
        }
    }

    /**
     * @param $id
     */
    public function deleteCommentaire($id) {

        $id = (int) $id;
        //echo $id;
        //fonction pour afficher la liste des tracteurs sous forme de tableau
        $requete = $this->dbGateway->prepare("
		DELETE FROM commentaire WHERE commentaire_id = :id
		")or die(print_r($this->dbGateway->error_info()));

        $requete->execute(array(
            'id' => $id
        ));
    }

}
