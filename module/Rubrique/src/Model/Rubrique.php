<?php

namespace Rubrique\Model;

use Rubrique\Model\Mapper\RubriqueMapper as Mapper;

/**
 * Class Rubrique
 * @package Rubrique\Model
 */
class Rubrique {

    protected $id;
    protected $libelle;
    protected $position;
    protected $scope;
    protected $spaceId;
    protected $filename;
    protected $hasContactForm;
    protected $hasMessageForm;
    protected $hasUpdateForm;
    protected $hasFileuploadForm;
    protected $publishing;

    /**
     * Rubrique constructor.
     */
    public function __construct() {}

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
     * @param $_libelle
     */
    public function setLibelle($_libelle) {
        $this->libelle = $_libelle;
    }

    /**
     * @return mixed
     */
    public function getLibelle() {
        return $this->libelle;
    }

    /**
     * @param $_position
     */
    public function setRang($_position) {
        $this->position = $_position;
    }

    /**
     * @return mixed
     */
    public function getRang() {
        return $this->position;
    }

    /**
     * @param $_scope
     */
    public function setScope($_scope) {
        $this->scope = $_scope;
    }

    /**
     * @return mixed
     */
    public function getScope() {
        return $this->scope;
    }

    /**
     * @param $_privatespace_id
     */
    public function setSpaceId($_privatespace_id) {
        $this->spaceId = $_privatespace_id;
    }

    /**
     * @return mixed
     */
    public function getSpaceId() {
        return $this->spaceId;
    }

    /**
     * @param $_filename
     */
    public function setFilename($_filename) {
        $this->filename = $_filename;
    }

    /**
     * @return mixed
     */
    public function getFilename() {
        return $this->filename;
    }

    /**
     * @param $_hasContactForm
     */
    public function setHasContactForm($_hasContactForm){
        $this->hasContactForm = $_hasContactForm;
    }

    /**
     * @return mixed
     */
    public function getHasContactForm(){
        return $this->hasContactForm;
    }
    
    public function setHasMessageForm($_hasMessageForm){
        $this->hasMessageForm = $_hasMessageForm;
    }
    
    public function getHasMessageForm(){
        return $this->hasMessageForm;
    }
    
    public function setHasUpdateForm($_hasUpdateForm){
        $this->hasUpdateForm = $_hasUpdateForm;
    }
    
    public function getHasUpdateForm(){
        return $this->hasUpdateForm;
    }

    public function setHasFileuploadForm($_hasFileuploadForm){
        $this->hasFileuploadForm = $_hasFileuploadForm;
    }

    public function gethasFileuploadForm(){
        return $this->hasFileuploadForm;
    }

    public function setPublishing($_topublish){
        $this->publishing = $_topublish;
    }

    public function getPublishing(){
        return $this->publishing;
    }
}
