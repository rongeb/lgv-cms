<?php

namespace Htmltemplate\Model;


/**
 * Class Htmltemplate
 * @package Htmltemplate\Model
 */
class Htmltemplate {

    private $id;
    private $label;
    private $html;

    /**
     * Htmltemplate constructor.
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
     * @param $_label
     */
    public function setLabel($_label) {
        $this->label = $_label;
    }

    /**
     * @return mixed
     */
    public function getLabel() {
        return $this->label;
    }

    /**
     * @param $_html
     */
    public function setHtml($_html) {
        $this->html = $_html;
    }

    /**
     * @return mixed
     */
    public function getHtml() {
        return $this->html;
    }
}
