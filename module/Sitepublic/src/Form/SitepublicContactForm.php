<?php

namespace Sitepublic\Form;

use Zend\Form\Form;
use Zend\Form\Element;

/**
 * Class SitepublicContactForm
 * @package Sitepublic\Form
 */
class SitepublicContactForm extends Form {

    /**
     * SitepublicContactForm constructor.
     * @param null $name
     */
    public function __construct($name = null) {
        // we want to ignore the name passed
        parent::__construct('contactform');
        //$this->setHydrator(new ClassMethods);
        $this->setAttribute('method', 'post');

        $this->captcha = new \Zend\Captcha\Figlet(array(
            
            'wordLen' => 4,
            'timeout' => 10800,
        ));
        
        
        $this->add(array(
            'name' => 'contactnom',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control'
            )
        ));

        $this->add(array(
            'name' => 'contactentreprise',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control'
            )
        ));
        
        $this->add(array(
            'name' => 'contactemail',
            'attributes' => array(
                'type' => 'text',
                'class' => 'form-control'
            )
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Textarea',
            'name' => 'contacttext',
            'attributes' => array(
                'class' => 'form-control',
                'row' => '8'
            )
            
        ));
        
        $this->add(array(
            'name' => 'contactcaptcha',
            'attributes' => array(
                'class' => 'form-control',
                'id' => 'contactcaptchaid'
            ),
            'options' => array(
                'label' => 'Vérification',
                'captcha' => $this->captcha,
            ),
            'type'  => 'Zend\Form\Element\Captcha',
        )); 
        
        $this->add
                (
                array
                    (
                    'type' => 'Zend\Form\Element\Csrf',
                    'name' => 'contactprevent',
                    'attributes' => array
                        (
                        'type' => 'text'
                    ),
                    'options' => array
                        (
                        'csrf_options' => array
                            (
                            'timeout' => 10800
                        )
                    ),
                )
        );
        
        $this->add(array(
            'name' => 'contactsweethoney',
            'attributes' => array(
                'type' => 'text',
                'id' => 'contactsweethoney',
            )
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Button',
            'name' => 'submitbutton',
            'options' => array(
                'label' => 'Valider',
            ),
            'attributes' => array(
                'value' => 'Valider',
                'id' => 'submitbtn',
                'class' => 'btn-u btn-brd btn-brd-hover btn-u-dark'
            ),
        ));
    }

}
