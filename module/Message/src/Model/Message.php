<?php

namespace Message\Model;

/**
 * Class Message
 * @package Message\Model
 */
class Message {

    protected $id;
    protected $row1;
    protected $row2;
    protected $row3;
    protected $row4;
    protected $message;
    protected $rang;
    protected $type;
    protected $timestamp;


    /**
     * Message constructor.
     */
    public function __construct() {
        
    }

    /**
     * @param $_id
     */
    public function setId($_id) {
        $this->id = $_id;
    }

    /**
     * @return mixed
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @param $_row1
     */
    public function setRow1($_row1) {
        $this->row1 = $_row1;
    }

    /**
     * @return mixed
     */
    public function getRow1() {
        return $this->row1;
    }

    /**
     * @param $_row2
     */
    public function setRow2($_row2) {
        $this->row2 = $_row2;
    }

    /**
     * @return mixed
     */
    public function getRow2() {
        return $this->row2;
    }

    /**
     * @param $_row3
     */
    public function setRow3($_row3) {
        $this->row3 = $_row3;
    }

    /**
     * @return mixed
     */
    public function getRow3() {
        return $this->row3;
    }

    /**
     * @param $_row4
     */
    public function setRow4($_row4) {
        $this->row4 = $_row4;
    }

    /**
     * @return mixed
     */
    public function getRow4() {
        return $this->row4;
    }

    /**
     * @return mixed
     */
    public function getMessage() {
        return $this->message;
    }

    /**
     * @param $_message
     */
    public function setMessage($_message) {
        $this->message = $_message;
    }

    /**
     * @return mixed
     */
    public function getRang() {
        return $this->rang;
    }

    /**
     * @param $_rang
     */
    public function setRang($_rang) {
        $this->rang = $_rang;
    }

    /**
     * @return mixed
     */
    public function getType() {
        return $this->type;
    }

    /**
     * @param $_type
     */
    public function setType($_type) {
        $this->type = $_type;
    }

    /**
     * @return mixed
     */
    public function getDate() {
        return $this->timestamp;
    }

    /**
     * @param $_timestamp
     */
    public function setDate($_timestamp) {
        $this->timestamp = $_timestamp;
    }


    /**
     * @return arrays
     */
    public function getArrayCopy() {
        return get_object_vars($this);
    }

}
