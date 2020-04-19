<?php

namespace Rubrique\Form;

use Laminas\InputFilter\InputFilter;
use ExtLib\Utils;

/**
 * Class MetaInputFilter
 * @package Rubrique\Form
 */
class MetaInputFilter extends InputFilter {
    
    protected $translator;

    /**
     * MetaInputFilter constructor.
     */
    public function __construct() {
        
        $this->translator = new Utils();

        $this->add(array(
            'name' => 'metaid',
            'required' => false,
            'filters' => array(
                array('name' => 'Int'),),
        ));
        
        $this->add(array(
            'name' => 'rubriqueid',
            'required' => true,
            'filters' => array(
                array('name' => 'Int'),),
        ));
        
        $this->add(array(
            'name' => 'metakey',
            'required' => false,
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),),
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'min' => 0,
                        'max' => 256,
                        'messages' => array(
                            \Laminas\Validator\StringLength::TOO_SHORT => $this->translator->translate('La taille minimum du libell&eacute; est de 1 caractère'),
                            \Laminas\Validator\StringLength::TOO_LONG => $this->translator->translate('La taille du libell&eacute; doit pas dépasser 128 caractères'),
                            \Laminas\Validator\StringLength::INVALID => $this->translator->translate('La taille du libell&eacute; ne doit pas dépasser 128 caractères'),
                        ),),),
                array(
                    'name' => 'NotEmpty',
                    'options' => array(
                        'messages' => array(
                            \Laminas\Validator\NotEmpty::IS_EMPTY => $this->translator->translate('Vous devez saisir un libell&eacute;')
                        ),
                    ),
                ),
            ),
        ));
        
        $this->add(array(
            'name' => 'metavalue',
            'required' => false,
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),),
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'min' => 0,
                        'max' => 512,
                        'messages' => array(
                            \Laminas\Validator\StringLength::TOO_SHORT => $this->translator->translate('La taille minimum du libell&eacute; est de 1 caractère'),
                            \Laminas\Validator\StringLength::TOO_LONG => $this->translator->translate('La taille du libell&eacute; doit pas dépasser 128 caractères'),
                            \Laminas\Validator\StringLength::INVALID => $this->translator->translate('La taille du libell&eacute; ne doit pas dépasser 128 caractères'),
                        ),),),
                array(
                    'name' => 'NotEmpty',
                    'options' => array(
                        'messages' => array(
                            \Laminas\Validator\NotEmpty::IS_EMPTY => $this->translator->translate('Vous devez saisir un libell&eacute;')
                        ),
                    ),
                ),
            ),
        ));
        
        
    }

}
