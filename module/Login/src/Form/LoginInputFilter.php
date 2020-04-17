<?php

namespace Login\Form;

use Zend\InputFilter\InputFilter;

/**
 * Class LoginInputFilter
 * @package Login\Form
 */
class LoginInputFilter extends InputFilter {

    /**
     * LoginInputFilter constructor.
     */
    public function __construct() {

        $this->add(array(
            'name' => 'username',
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
                        'max' => 128,),),
            ),
        ));

        $this->add(array(
            'name' => 'password',
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
                        'max' => 128,),),
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
        /*
        $this->add(array
            (
            'name' => 'prevent',
            'required' => true,
            'validators' => array
                (array(
                    'name' => 'Csrf',
                    'options' => array(
                        'messages' => array(
                        \Zend\Validator\Csrf::NOT_SAME => 'Are you a human or a robot ?',
                        ),
                    ),
                ),
            )
        ));
        */
    }

}
