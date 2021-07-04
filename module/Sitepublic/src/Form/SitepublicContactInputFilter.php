<?php

namespace Sitepublic\Form;

use Laminas\InputFilter\InputFilter;

/**
 * Class SitepublicContactInputFilter
 * @package Sitepublic\Form
 */
class SitepublicContactInputFilter extends InputFilter {

    /**
     * SitepublicContactInputFilter constructor.
     */
    public function __construct() {

        $this->add(array(
            'name' => 'contactnom',
            'required' => true,
            'filters' => array(
                array('name' => 'Laminas\Filter\StripTags'),
                array('name' => 'Laminas\Filter\StringTrim')
            ),
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'min' => 1,
                        'max' => 128,
                        'messages' => array(
                            \Laminas\Validator\StringLength::TOO_LONG => 'La taille ne doit pas dépasser 128 caractères',
                            \Laminas\Validator\StringLength::INVALID => 'La taille ne doit pas dépasser 128 caractères',
                        )),),
            ),
        ));

        $this->add(array(
            'name' => 'contactentreprise',
            'required' => true,
            'filters' => array(
                array('name' => 'Laminas\Filter\StripTags'),
                array('name' => 'Laminas\Filter\StringTrim'),),
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'min' => 1,
                        'max' => 128,
                        'messages' => array(
                            \Laminas\Validator\StringLength::TOO_LONG => 'La taille ne doit pas dépasser 128 caractères',
                            \Laminas\Validator\StringLength::INVALID => 'La taille ne doit pas dépasser 128 caractères',
                        ),),),
            ),
        ));
        
        $this->add(array(
            'name' => 'contactemail',
            'required' => true,
            'filters' => array(
                array('name' => 'Laminas\Filter\StripTags'),
                array('name' => 'Laminas\Filter\StringTrim'),),
            'validators' => array(
                array(
                    'name' => 'Regex',
                    'options' => array(
                        'pattern' => '/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/',
                        'messages' => array(
                            \Laminas\Validator\Regex::NOT_MATCH => "L'email est invalide",
                        ),
                    ),
                ),
        )));

        $this->add(array(
            'name' => 'contactsweethoney',
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
