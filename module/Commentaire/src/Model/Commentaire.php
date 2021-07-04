<?php

namespace Commentaire\Model;

use Message\Model\Message;

/**
 * Class Commentaire
 * @package Commentaire\Model
 */
class Commentaire extends Message {

    protected $idContenu;
    protected $commentaireStatut;

    /**
     * Commentaire constructor.
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * @param $_id
     */
    public function setContenuId($_id) {
        $this->idContenu = $_id;
    }

    /**
     * @return mixed
     */
    public function getContenuId() {
        return $this->idContenu;
    }

    /**
     * @param $_commentaireStatut
     */
    public function setCommentaireStatut($_commentaireStatut) {
        $this->commentaireStatut = $_commentaireStatut;
    }

    /**
     * @return mixed
     */
    public function getCommentaireStatut() {
        return $this->commentaireStatut;
    }

}
