<?php

namespace Blogcontent\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Galerie\Form\GalerieInputFilter;
use ExtLib\Utils;

/**
 * Class BlogcontentInputFilter
 * @package Blogcontent\Form
 */
class BlogcontentInputFilter extends GalerieInputFilter {

    /**
     * BlogcontentInputFilter constructor.
     */
    public function __construct() {

        parent::__construct();

        $this->translator = new Utils();

        $this->add(array(
            'name' => 'author',
            'required' => false,
            'filters' => array(
                array('name' => 'Zend\Filter\StripTags'),
                array('name' => 'Zend\Filter\StringTrim')
            ),
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'min' => 0,
                        'max' => 256,
                        'messages' => array(
                            \Zend\Validator\StringLength::TOO_LONG => $this->translator->translate('La taille ne doit pas dépasser 256 caractères'),
                            \Zend\Validator\StringLength::INVALID => $this->translator->translate('La taille ne doit pas dépasser 256 caractères'),
                        )),),
            ),
        ));
        $this->add(array(
            'name' => 'themes',
            'required' => false,
            'filters' => array(
                array('name' => 'Zend\Filter\StripTags'),
                array('name' => 'Zend\Filter\StringTrim')
            ),
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'min' => 0,
                        'max' => 256,
                        'messages' => array(
                            \Zend\Validator\StringLength::TOO_LONG => $this->translator->translate('La taille ne doit pas dépasser 256 caractères'),
                            \Zend\Validator\StringLength::INVALID => $this->translator->translate('La taille ne doit pas dépasser 256 caractères'),
                        )),),
            ),
        ));

        $this->add(array(
            'name' => 'blogdate',
            'required' => true,
            'filters' => array(
                array('name' => 'Zend\Filter\StripTags'),
                array('name' => 'Zend\Filter\StringTrim')
            ),
            'validators' => array(
                array(
                    'name' => 'Regex',
                    'options' => array(
                        'pattern' => '/\\A(?:^((\\d{2}(([02468][048])|([13579][26]))[\\-\\/\\s]?((((0?[13578])|(1[02]))[\\-\\/\\s]?((0?[1-9])|([1-2][0-9])|(3[01])))|(((0?[469])|(11))[\\-\\/\\s]?((0?[1-9])|([1-2][0-9])|(30)))|(0?2[\\-\\/\\s]?((0?[1-9])|([1-2][0-9])))))|(\\d{2}(([02468][1235679])|([13579][01345789]))[\\-\\/\\s]?((((0?[13578])|(1[02]))[\\-\\/\\s]?((0?[1-9])|([1-2][0-9])|(3[01])))|(((0?[469])|(11))[\\-\\/\\s]?((0?[1-9])|([1-2][0-9])|(30)))|(0?2[\\-\\/\\s]?((0?[1-9])|(1[0-9])|(2[0-8]))))))(\\s(((0?[0-9])|(1[0-9])|(2[0-3]))\\:([0-5][0-9])((\\s)|(\\:([0-5][0-9])))?))?$)\\z/',
                        'messages' => array(
                             \Zend\Validator\Regex::NOT_MATCH => $this->translator->translate('La date n\'est pas valide')
                        )
                    )
             ),
                array(
                    'name' => 'NotEmpty',
                    'options' => array(
                        'messages' => array(
                            \Zend\Validator\NotEmpty::IS_EMPTY => $this->translator->translate('Vous devez saisir une date')
                        ),
                    ),
                ),
                )
        ));

        $this->add(array(
            'name' => 'text1',
            'required' => false,
            'filters' => array(
                array('name' => 'Zend\Filter\StripTags'),
                array('name' => 'Zend\Filter\StringTrim')
            ),
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'min' => 0,
                        'max' => 256,
                        'messages' => array(
                            \Zend\Validator\StringLength::TOO_LONG => $this->translator->translate('La taille ne doit pas dépasser 256 caractères'),
                            \Zend\Validator\StringLength::INVALID => $this->translator->translate('La taille ne doit pas dépasser 256 caractères'),
                        )),),
            ),
        ));

        $this->add(array(
            'name' => 'text2',
            'required' => false,
            'filters' => array(
                array('name' => 'Zend\Filter\StripTags'),
                array('name' => 'Zend\Filter\StringTrim')
            ),
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'min' => 0,
                        'max' => 256,
                        'messages' => array(
                            \Zend\Validator\StringLength::TOO_LONG => $this->translator->translate('La taille ne doit pas dépasser 256 caractères'),
                            \Zend\Validator\StringLength::INVALID => $this->translator->translate('La taille ne doit pas dépasser 256 caractères'),
                        )),),
            ),
        ));

        $this->add(array(
            'name' => 'text3',
            'required' => false,
            'filters' => array(
                array('name' => 'Zend\Filter\StripTags'),
                array('name' => 'Zend\Filter\StringTrim')
            ),
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'min' => 0,
                        'max' => 256,
                        'messages' => array(
                            \Zend\Validator\StringLength::TOO_LONG => $this->translator->translate('La taille ne doit pas dépasser 256 caractères'),
                            \Zend\Validator\StringLength::INVALID => $this->translator->translate('La taille ne doit pas dépasser 256 caractères'),
                        )),),
            ),
        ));
    }

}
