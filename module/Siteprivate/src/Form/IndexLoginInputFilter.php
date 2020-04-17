<?php

namespace Siteprivate\Form;

use Login\Form\LoginInputFilter;

/**
 * Class IndexLoginInputFilter
 * @package Siteprivate\Form
 */
class IndexLoginInputFilter extends LoginInputFilter {

    /**
     * IndexLoginInputFilter constructor.
     */
    public function __construct() {
        parent::__construct();
        
        $this->add(array(
            'name' => 'token',
            'required' => true,
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'min' => 1,
                        'max' => 256,),),
            ),
        ));
    }

}
