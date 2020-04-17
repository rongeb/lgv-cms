<?php

namespace SousRubrique\Form;

use Zend\Form\Form;
use Zend\Form\Element;
use Rubrique\Model\RubriqueDao;
use ExtLib\Utils;

/**
 * Class SousRubriqueForm
 * @package SousRubrique\Form
 */
class SousRubriqueForm extends Form {

    private $translator;

    /**
     * @return array
     */
    protected function getRubriques() {
        $rubriquesDao = new RubriqueDao();
        $rubriques = $rubriquesDao->getAllRubriques("array");

        $rubriqueArray = array();

        foreach ($rubriques as $value) {

            $rubriqueArray[$value['id']] = $value['libelle'];
        }

        return $rubriqueArray;
    }

    /**
     * SousRubriqueForm constructor.
     * @param null $name
     */
    public function __construct($name = null) {
        // we want to ignore the name passed
        parent::__construct('sousrubrique');
        //$this->setHydrator(new ClassMethods);
        $this->translator = new Utils();
        
        $this->setAttribute('method', 'post');

        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type' => 'hidden',
            ),
        ));

        $this->add(array(
            'name' => 'rubriques_id',
            'attributes' => array(
                'type' => 'hidden',
                'id' => 'idrub'
            ),
        ));

        $this->add(array(
            'name' => 'libelle',
            'attributes' => array(
                'type' => 'text'
            ),
            'options' => array(
                'label' => $this->translator->translate('Libellé'),
            ),
        ));
        $this->add(array(
            'name' => 'rang',
            'attributes' => array(
                'type' => 'text'
            ),
            'options' => array(
                'label' => $this->translator->translate('Position'),
            ),
        ));
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'rubriquesList',
            'attributes' => array(
                'id' => 'rubriqueSelectIdTag',
                'class' => 'rubriqueSelectIdClass'
            ),
            'options' => array(
                //'label' => 'Choisir la rubrique',
                'empty_option' => $this->translator->translate('Sélectionner une rubrique'),
                //'class' => 'input-medium',
                'value_options' => $this->getRubriques()
            ),
        ));
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Valider',
                'id' => 'submitbutton',
            ),
        ));
    }

}
