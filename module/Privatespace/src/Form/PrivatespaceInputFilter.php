<?php

namespace Privatespace\Form;

use Laminas\Form\Form;
use Laminas\InputFilter\InputFilter;
use Laminas\InputFilter\InputFilterAwareInterface;
use Laminas\InputFilter\InputFilterInterface;
use ExtLib\Utils;

/**
 * Class PrivatespaceInputFilter
 * @package Privatespace\Form
 */
class PrivatespaceInputFilter extends InputFilter {

    protected $translator;

    /**
     * PrivatespaceInputFilter constructor.
     */
    public function __construct() {
        
        $this->translator = new Utils();

        $this->add(array(
            'name' => 'id',
            'required' => true,
            'filters' => array(
                array('name' => 'Int'),),
        ));

        $this->add(array(
            'name' => 'name',
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
