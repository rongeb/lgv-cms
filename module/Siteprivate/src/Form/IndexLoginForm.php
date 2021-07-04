<?php

namespace Siteprivate\Form;

use Login\Form\LoginForm;

/**
 * Class IndexLoginForm
 * @package Siteprivate\Form
 */
class IndexLoginForm extends LoginForm {

    /**
     * IndexLoginForm constructor.
     * @param null $name
     */
    public function __construct($name = null) {
        // we want to ignore the name passed
        parent::__construct('login');
        
        $this->add(array(
            'name' => 'token',
            'attributes' => array(
                'type' => 'hidden',
                'id' => 'tokenId'
            ),
        ));
    }

}
