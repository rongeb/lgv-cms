<?php

namespace Message\Model;

use Application\DBConnection\ParentDao;
use Message\Model\Message;
use Message\Model\Mapper\MessageMapper;

/**
 * Class MessageDao
 * @package Message\Model
 */
class MessageDao extends ParentDao{

    /**
     * MessageDao constructor.
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * @param $dataType: array|object
     * @return array|array of Message
     */
    public function getAllMessages($dataType) {

        $count = 0;
        $messageMapper = new MessageMapper();

        $requete = $this->dbGateway->prepare("
		SELECT *
		FROM message m
		ORDER BY m.message_type, m.message_date 
		")or die(print_r($this->dbGateway->error_info()));

        $requete->execute();

        $requete2 = $requete->fetchAll(\PDO::FETCH_ASSOC);

        if (strcasecmp($dataType,"object") == 0) {
            //Put result in an array of objects
            $arrayOfMessagestep1 = array();
            if (is_array($requete2)) {
                foreach ($requete2 as $key => $value) {

                    $arrayOfMessagestep1[$count] = $messageMapper->exchangeArray($value);

                    $count++;
                }
            }
            return $arrayOfMessagestep1;
            
        } elseif (strcasecmp($dataType,"array")==0) {
            return $requete2;
        }
    }

    /**
     * @param $id
     * @return \Message\Model\Message
     */
    public function getMessage($id) {

        $id = (int) $id;
        $messageMapper = new MessageMapper();
        $requete = $this->dbGateway->prepare("
		SELECT *
		FROM message m
                WHERE m.message_id = :id
		")or die(print_r($this->dbGateway->error_info()));

        $requete->execute(array(
            'id' => $id
        ));

        $requete2 = $requete->fetch(\PDO::FETCH_ASSOC);

        $message = $messageMapper->exchangeArray($requete2);

        return $message;
    }

    /**
     * @param $type
     * @param $dataType: array|objrct
     * @return array|array of Message
     */
    public function getMessagesByType($type, $dataType) {

        $messageMapper = new MessageMapper();
        $count=0;
        $requete = $this->dbGateway->prepare("
		SELECT *
		FROM message m
		WHERE m.message_type = :type
		ORDER BY m.message_type, m.message_position
                ")or die(print_r($this->dbGateway->error_info()));

        $requete->execute(array(
            'type' => $type
        ));

        $requete2 = $requete->fetch(\PDO::FETCH_ASSOC);

        if (strcasecmp($dataType,"object") == 0) {
            //Put result in an array of objects
            $arrayOfMessagestep1 = array();
            if (is_array($requete2)) {
                foreach ($requete2 as $key => $value) {

                    $arrayOfMessagestep1[$count] = $messageMapper->exchangeArray($value);

                    $count++;
                }
            }
            //print_r($arrayOfMessagestep2);
            return $arrayOfMessagestep1;
        } 
        elseif (strcasecmp($dataType,"array") ==0) {
            return $requete2;
        }
    }

    /**
     * @param \Message\Model\Message $message
     */
    public function saveMessage(Message $message) {

        $id = (int) $message->getId();

        if ($message->getRow1() == null) {
            $message->setRow1("");
        }
        if ($message->getRow2() == null) {
            $message->setRow2("");
        }
        if ($message->getRow3() == null) {
            $message->setRow3("");
        }
        if ($message->getRow4() == null) {
            $message->setRow4("");
        }
        if ($message->getMessage() == null) {
            $message->setMessage("");
        }
        if ($message->getType() == null) {
            $message->setType("unknown");
        }
        if ($message->getRang() == null) {
            $message->setRang(0);
        }
        if ($message->getDate() == null) {
            $message->setDate(time());
        }

        if ($id > 0) {

            $requete = $this->dbGateway->prepare("
				UPDATE message 
				SET message_row1 = :row1, 
				message_row2 = :row2,
				message_row3 = :row3,
				message_row4 = :row4,
                                message_msg = :msg,
                                
                                message_type = :type,
                                message_date = :datemsg
				WHERE message_id = :id
			")or die(print_r($this->dbGateway->errors_info()));

            $requete->execute(array(
                'id' => $id,
                'row1' => $message->getRow1(),
                'row2' => $message->getRow2(),
                'row3' => $message->getRow3(),
                'row4' => $message->getRow4(),
                'msg' => $message->getMessage(),
                'type' => $message->getType(),
                //'rang' => $message->getRang(),
                'datemsg' => $message->getDate()
            ));
        } else {

            $requete = $this->dbGateway->prepare("INSERT into message(message_row1, message_row2, message_row3, message_row4,  message_msg, message_type, message_date) "
                    . "values(:rowa, :rowb, :rowc, :rowd, :msg, :type, :datemsg)")or die(print_r($this->dbGateway->error_info()));

            $info = $requete->execute(array(
                'rowa' => $message->getRow1(),
                'rowb' => $message->getRow2(),
                'rowc' => $message->getRow3(),
                'rowd' => $message->getRow4(),
                'msg' => $message->getMessage(),
                'type' => $message->getType(),
                //'position' => $message->getRang(),
                'datemsg' => $message->getDate()
            ));
        }
    }

    /**
     * @param $id
     */
    public function deleteMessage($id) {

        $id = (int) $id;
        //echo $id;
        //fonction pour afficher la liste des tracteurs sous forme de tableau
        $requete = $this->dbGateway->prepare("
		DELETE FROM message WHERE message_id = :id
		")or die(print_r($this->dbGateway->error_info()));

        $requete->execute(array(
            'id' => $id
        ));
    }

}
