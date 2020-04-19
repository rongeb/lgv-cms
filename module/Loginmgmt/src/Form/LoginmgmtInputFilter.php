<?php

namespace Loginmgmt\Form;

use Laminas\Form\Form;
use Laminas\InputFilter\InputFilter;
use Laminas\InputFilter\InputFilterAwareInterface;
use Laminas\InputFilter\InputFilterInterface;
use ExtLib\Utils;

/**
 * Class LoginmgmtInputFilter
 * @package Loginmgmt\Form
 */
class LoginmgmtInputFilter extends InputFilter {
    
    protected $translator;

    /**
     * LoginmgmtInputFilter constructor.
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
                        'min' => 3,
                        'max' => 128,
                        'messages' => array(
                            \Laminas\Validator\StringLength::TOO_SHORT => $this->translator->translate('La taille minimum du nom est de 3 caractères minimum'),
                            \Laminas\Validator\StringLength::TOO_LONG => $this->translator->translate('La taille du nom doit pas dépasser 128 caractères'),
                            \Laminas\Validator\StringLength::INVALID => $this->translator->translate('La taille du nom ne doit pas dépasser 128 caractères'),
                        ),),),
                array(
                    'name' => 'NotEmpty',
                    'options' => array(
                        'messages' => array(
                            \Laminas\Validator\NotEmpty::IS_EMPTY => $this->translator->translate('Vous devez saisir un nom')
                        ),
                    ),
                ),
            ),
        ));
        
        
        $this->add(array(
            'name' => 'pwd',
            'required' => true,
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),),
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'min' => 5,
                        'max' => 128,
                        'messages' => array(
                            \Laminas\Validator\StringLength::TOO_SHORT => $this->translator->translate('La taille minimum du mot de passe est de 5 caractères'),
                            \Laminas\Validator\StringLength::TOO_LONG => $this->translator->translate('La taille du mot de passe doit pas dépasser 128 caractères'),
                            \Laminas\Validator\StringLength::INVALID => $this->translator->translate('La taille du mot de passe ne doit pas dépasser 128 caractères'),
                        ),),),
                array(
                    'name' => 'NotEmpty',
                    'options' => array(
                        'messages' => array(
                            \Laminas\Validator\NotEmpty::IS_EMPTY => $this->translator->translate('Vous devez saisir un mot de passe de 5 caractères minimum')
                        ),
                    ),
                ),
            ),
        ));
        
        $this->add(array(
            'name' => 'roleList',
            'required' => true,
            'filters' => array(
                array('name' => 'Laminas\Filter\StripTags'),
                array('name' => 'Laminas\Filter\StringTrim'),),
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'min' => 0,
                        'max' => 128,
                        'messages' => array(
                            \Laminas\Validator\StringLength::TOO_LONG => $this->translator->translate('La taille ne doit pas dépasser 128 caractères'),
                            \Laminas\Validator\StringLength::INVALID => $this->translator->translate('La taille ne doit pas dépasser 128 caractères'),
                        ),),),
                array(
                    'name' => 'NotEmpty',
                    'options' => array(
                        'messages' => array(
                            \Laminas\Validator\NotEmpty::IS_EMPTY => $this->translator->translate('Vous devez choisir un rôle')
                        ),
                    ),
                ),
            ),
        ));
        
    }

}
