<?php

namespace Siteprivate\Form;

use Laminas\Form\Form;
use Laminas\InputFilter\InputFilter;
use Laminas\InputFilter\InputFilterAwareInterface;
use Laminas\InputFilter\InputFilterInterface;
use ExtLib\Utils;

/**
 * Class SiteprivateNewPasswordInputFilter
 * @package Siteprivate\Form
 */
class SiteprivateNewPasswordInputFilter extends InputFilter {

    protected $translator;

    /**
     * SiteprivateNewPasswordInputFilter constructor.
     */
    public function __construct() {

        $this->translator = new Utils();

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
                        'max' => 512,
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
            'name' => 'pwdconfirm',
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
                        'max' => 512,
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
            'name' => 'token',
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
                        'max' => 512,
                        'messages' => array(
                            \Laminas\Validator\StringLength::TOO_SHORT => $this->translator->translate('La taille du jeton est trop courte'),
                            \Laminas\Validator\StringLength::TOO_LONG => $this->translator->translate('La taille jeton est trop longue'),
                            \Laminas\Validator\StringLength::INVALID => $this->translator->translate('Le jeton est invalide'),
                        ),),),
                array(
                    'name' => 'NotEmpty',
                    'options' => array(
                        'messages' => array(
                            \Laminas\Validator\NotEmpty::IS_EMPTY => $this->translator->translate('Vous devez avoir un jeton')
                        ),
                    ),
                ),
            ),
        ));


        $this->add(array(
            'name' => 'sweethoney',
            'required' => true,
            'allow_empty' => true,
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),),
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'min' => 0,
                        'max' => 0,),),
            ),
        ));
    }

}
