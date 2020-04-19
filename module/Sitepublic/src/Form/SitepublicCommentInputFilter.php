<?php

namespace Sitepublic\Form;

use Laminas\InputFilter\InputFilter;
use ExtLib\Utils;

/**
 * Class SitepublicCommentInputFilter
 * @package Sitepublic\Form
 */
class SitepublicCommentInputFilter extends InputFilter {
    
    private $translator;

    /**
     * SitepublicCommentInputFilter constructor.
     */
    public function __construct() {
        
        $this->translator = new Utils();
        
        $this->add(array(
            'name' => 'contactcontenuid',
            'required' => true,
            'filters' => array(
                array('name' => 'Int'),),
        ));
        

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
                            \Laminas\Validator\StringLength::TOO_LONG => $this->translator->translate('La taille ne doit pas dépasser 128 caractères'),
                            \Laminas\Validator\StringLength::INVALID => $this->translator->translate('La taille ne doit pas dépasser 128 caractères'),
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
                            \Laminas\Validator\StringLength::TOO_LONG => $this->translator->translate('La taille ne doit pas dépasser 128 caractères'),
                            \Laminas\Validator\StringLength::INVALID => $this->translator->translate('La taille ne doit pas dépasser 128 caractères'),
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
                        ///^[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?$/
                        'pattern' => '/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/',
                        'messages' => array(
                            \Laminas\Validator\Regex::NOT_MATCH => $this->translator->translate("L'email est invalide"),
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
