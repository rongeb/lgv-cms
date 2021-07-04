<?php

// module/Fichiers/src/Fichiers/Form/FichiersForm.php:

namespace Fichiers\Form;

use Laminas\Form\Form;
use Laminas\Form\Element;
use ExtLib\Utils;

/**
 * Class FichiersForm
 * @package Fichiers\Form
 */
class FichiersForm extends Form {

    private $utils;

    /**
     * FichiersForm constructor.
     * @param null $name
     */
    public function __construct($name = null) {
        // we want to ignore the name passed
        parent::__construct('formfichiers');
        $this->utils = new Utils();

        //$this->setHydrator(new ClassMethods);
        $this->setAttribute('method', 'post');

        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type' => 'hidden',
            ),
        ));

        $this->add(array(
            'name' => 'imagepath',
            'attributes' => array(
                'type' => 'hidden',
                'id' => 'fichierpath'
            ),
        ));

        $this->add(array(
            'name' => 'libelle',
            'attributes' => array(
                'type' => 'text'
            ),
        ));

        $this->add(array(
            'name' => 'metadata',
            'attributes' => array(
                'type' => 'text'
            ),
        ));


        $this->add(array(
            'type' => 'Laminas\Form\Element\File',
            'name' => 'newfichier',
            'attributes' => array(
                'id' => 'newfichierId',
            //'class'	   => 'sousrubriqueSelectIdClass'
            ),
            'options' => array(
                'label' => $this->utils->translate('Choisir un fichier'),
            ),
        ));

        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => $this->utils->translate('Valider'),
                'id' => 'submitbutton',
            ),
        ));
    }

}
