<?php

namespace Contenu\Model;

use Sousrubrique\Model\Sousrubrique;

/**
 * Interface IContenu
 * @package Contenu\Model
 */
interface IContenu {
    
    public function setId($_id);

    public function getId();

    public function setTitre($_titre);

    public function getTitre();

    public function setSousTitre($_soustitre);

    public function getSousTitre();
    
    public function setSousRubrique(SousRubrique $_sousrubrique);

    public function getSousRubrique();
    
    public function getContenuHtml();

    public function setContenuHtml($_contenuhtml);

    public function getRang();

    public function setRang($_rang);

    public function getImage();

    public function setImage($_image);
    
    public function getImage2();

    public function setImage2($_image2);
    
    public function getType();
    
    public function setType($_type);
}
