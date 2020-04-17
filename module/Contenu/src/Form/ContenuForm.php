<?php

namespace Contenu\Form;

use Htmltemplate\Model\HtmltemplateDao;
use Zend\Form\Form;
use Zend\Form\Element;
use Rubrique\Model\RubriqueDao;
use ExtLib\Utils;

/**
 * Class ContenuForm
 * @package Contenu\Form
 */
class ContenuForm extends Form {

    protected $utils;


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

    protected function getHtmltemplates() {

        $htmltemplateDao = new HtmltemplateDao();
        $htmltemplates = $htmltemplateDao->getAllHtmltemplate("array");
        $htmlArray = array();

        foreach ($htmltemplates as $value) {
            $htmlArray[$value['id']] = $value['label'];
        }

        return $htmlArray;
    }

    /**
     * ContenuForm constructor.
     * @param null $name
     */
    public function __construct($name = null) {
        
        $this->utils = new Utils(); 

        // we want to ignore the name passed
        parent::__construct('contenuform');
        //$this->setHydrator(new ClassMethods);
        $this->setAttribute('method', 'post');

        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type' => 'hidden',
                'value' => 0
            ),
        ));

        $this->add(array(
            'name' => 'titre',
            'attributes' => array(
                'type' => 'text'
            ),
            'options' => array(
                'label' => $this->utils->translate('Titre'),
            ),
        ));

        $this->add(array(
            'name' => 'soustitre',
            'attributes' => array(
                'type' => 'text'
            ),
            'options' => array(
                'label' => $this->utils->translate('Sous-Titre'),
            ),
        ));
        
        $this->add(array(
            'name' => 'position',
            'attributes' => array(
                'type' => 'text'
            ),
            'options' => array(
                'label' => $this->utils->translate('Position'),
            ),
        ));
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'sousrubriquesList',
            'attributes' => array(
                'id' => 'sousrubriqueSelectIdTag',
                'class' => 'sousrubriqueSelectIdClass'
            ),
            'options' => array(
                //'label' => 'Choisir la rubrique',
                'empty_option' => $this->utils->translate('Sélectionner une sous-rubrique'),
                'disable_inarray_validator' => true
            //'class' => 'input-medium',
            //'value_options' => $this->getSousRubriques()
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
                'empty_option' => $this->utils->translate('Sélectionner une rubrique'),
                //'class' => 'input-medium',
                'value_options' => $this->getRubriques()
            ),
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Textarea',
            'name' => 'contenu',
            'attributes' => array(
                'id' => 'contenuId',
                'class' => 'contenuClass'
            )
        ));


        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'htmltemplateList',
            'attributes' => array(
                'id' => 'htmltemplateSelectIdTag',
                'class' => 'htmltemplateSelectIdClass'
            ),
            'options' => array(
                //'label' => 'Choisir la rubrique',
                'empty_option' => $this->utils->translate('Utiliser un modèle html - Optionnel'),
                //'class' => 'input-medium',
                'value_options' => $this->getHtmltemplates(),
                'disable_inarray_validator' => true
            ),
        ));


        $this->add(array(
            'type' => 'Zend\Form\Element\Button',
            'name' => 'submitbutton',
            'options' => array(
                'label' => $this->utils->translate('Valider'),
            ),
            'attributes' => array(
                'value' => $this->utils->translate('Valider'),
                'id' => 'submitbutton',
                'class' => 'btn-info'
            ),
        ));
       
    }

}
