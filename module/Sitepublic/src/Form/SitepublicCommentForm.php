<?php

namespace Sitepublic\Form;

use Laminas\Form\Form;
use Laminas\Form\Element;

/**
 * Class SitepublicCommentForm
 * @package Sitepublic\Form
 */
class SitepublicCommentForm extends Form {

    /**
     * SitepublicCommentForm constructor.
     * @param null $name
     */
    public function __construct($name = null) {
        // we want to ignore the name passed
        parent::__construct('commentform');
        //$this->setHydrator(new ClassMethods);
        $this->setAttribute('method', 'post');

        $this->captcha = new \Laminas\Captcha\Figlet(array(
            
            'wordLen' => 4,
            'timeout' => 10800,
        ));
        
        $this->add(array(
            'name' => 'contactcontenuid',
            'attributes' => array(
                'type' => 'hidden',
            ),
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
            'type' => 'Laminas\Form\Element\Textarea',
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
                'id' => 'commentcaptchaid'
            ),
            'options' => array(
                'label' => 'Vérification',
                'captcha' => $this->captcha,
            ),
            'type'  => 'Laminas\Form\Element\Captcha',
        )); 
        
        $this->add
                (
                array
                    (
                    'type' => 'Laminas\Form\Element\Csrf',
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
            'type' => 'Laminas\Form\Element\Button',
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
