<?php

namespace Rubrique\Form;

use Laminas\Form\Form;
use Laminas\InputFilter\InputFilter;
use Laminas\InputFilter\InputFilterAwareInterface;
use Laminas\InputFilter\InputFilterInterface;
use ExtLib\Utils;

/**
 * Class RubriqueInputFilter
 * @package Rubrique\Form
 */
class RubriqueInputFilter extends InputFilter
{

    protected $translator;

    /**
     * RubriqueInputFilter constructor.
     */
    public function __construct()
    {

        $this->translator = new Utils();

        $this->add(array(
            'name' => 'id',
            'required' => true,
            'filters' => array(
                array('name' => 'Int'),),
        ));

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
            'name' => 'rang',
            'required' => false,
            'filters' => array(
                array('name' => 'Laminas\Filter\StripTags'),
                array('name' => 'Laminas\Filter\StringTrim'),),
            'validators' => array(
                array(
                    'name' => 'Regex',
                    'options' => array(
                        'pattern' => '/^[-]?[0-9]*$/',
                        'messages' => array(
                            \Laminas\Validator\Regex::NOT_MATCH => $this->translator->translate('La position doit être vide ou doit être un nombre'),
                        ),
                    ),
                ),
            )));

        $this->add(array(
            'name' => 'spacesList',
            'required' => false,
            'filters' => array(
                array('name' => 'Int'),),
        ));

        $this->add(array(
            'name' => 'scope',
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

        $this->add(array(
            'name' => 'contactForm',
            'required' => true
        ));

        $this->add(array(
            'name' => 'messageForm',
            'required' => true
        ));

        $this->add(array(
            'name' => 'updateForm',
            'required' => true
        ));

        $this->add(array(
            'name' => 'filename',
            'required' => false,
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
                            \Laminas\Validator\StringLength::TOO_SHORT => $this->translator->translate('La taille minimum du fichier est de 1 caractère'),
                            \Laminas\Validator\StringLength::TOO_LONG => $this->translator->translate('La taille du fichier doit pas dépasser 128 caractères'),
                            \Laminas\Validator\StringLength::INVALID => $this->translator->translate('La taille du fichier ne doit pas dépasser 128 caractères'),
                        ),),
                ),
                array(
                    'name' => 'Regex',
                    'options' => array(
                        'pattern' => '/^.*\.(phtml)$/',
                        'messages' => array(
                            \Laminas\Validator\Regex::NOT_MATCH => $this->translator->translate('L\'extension doit se terminer par phtml en minuscule')
                        )
                    )
                )
            )
        ));
    }

}
