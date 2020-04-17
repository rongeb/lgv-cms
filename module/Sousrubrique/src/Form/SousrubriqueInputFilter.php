<?php

namespace Sousrubrique\Form;

use Zend\InputFilter\InputFilter;
use ExtLib\Utils;

/**
 * Class SousrubriqueInputFilter
 * @package Sousrubrique\Form
 */
class SousrubriqueInputFilter extends InputFilter {

    protected $translator;

    /**
     * SousrubriqueInputFilter constructor.
     */
    public function __construct() {
        
        $this->translator = new Utils();

        $this->add(array(
            'name' => 'id',
            'required' => true,
            'filters' => array(
                array('name' => 'Int'),),
        ));
        /*
          $this->add(array(
          'name' => 'rubriques_id',
          'required' => true,
          'filters' => array(
          array('name' => 'Int'),),
          ));
         */
        $this->add(array(
            'name' => 'libelle',
            'required' => true,
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),),
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'min' => 1,
                        'max' => 128,
                        'messages' => array(
                            \Zend\Validator\StringLength::TOO_SHORT => $this->translator->translate('La taille minimum du libell&eacute; est de 1 caractère'),
                            \Zend\Validator\StringLength::TOO_LONG => $this->translator->translate('La taille du libell&eacute; doit pas dépasser 128 caractères'),
                            \Zend\Validator\StringLength::INVALID => $this->translator->translate('La taille du libell&eacute; ne doit pas dépasser 128 caractères'),
                        ),),),
                array(
                    'name' => 'NotEmpty',
                    'options' => array(
                        'messages' => array(
                            \Zend\Validator\NotEmpty::IS_EMPTY => $this->translator->translate('Vous devez saisir un libell&eacute;')
                        ),
                    ),
                ),
            ),
        ));

        $this->add(array(
            'name' => 'rang',
            'required' => false,
            'filters' => array(
                array('name' => 'Zend\Filter\StripTags'),
                array('name' => 'Zend\Filter\StringTrim'),),
            'validators' => array(
                array(
                    'name' => 'Regex',
                    'options' => array(
                        'pattern' => '/^[-]?[0-9]*$/',
                        'messages' => array(
                            \Zend\Validator\Regex::NOT_MATCH => $this->translator->translate('La position doit être vide ou doit être un nombre'),
                        ),
                    ),
                ),
        )));

        $this->add(array(
            'name' => 'rubriquesList',
            'required' => true,
            'filters' => array(
                array('name' => 'Zend\Filter\StripTags'),
                array('name' => 'Zend\Filter\StringTrim'),),
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'min' => 0,
                        'max' => 128,
                        'messages' => array(
                            \Zend\Validator\StringLength::TOO_LONG => $this->translator->translate('La taille ne doit pas dépasser 128 caractères'),
                            \Zend\Validator\StringLength::INVALID => $this->translator->translate('La taille ne doit pas dépasser 128 caractères'),
                        ),),),
                array(
                    'name' => 'NotEmpty',
                    'options' => array(
                        'messages' => array(
                            \Zend\Validator\NotEmpty::IS_EMPTY => $this->translator->translate('Vous devez choisir une rubrique')
                        ),
                    ),
                ),
            ),
        ));
    }

}
