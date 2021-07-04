<?php

namespace Siteprivate\Form;

use ExtLib\Utils;
use Privatespacelogin\Form\PrivatespaceloginForm;

/**
 * Class SiteprivateRegistrationForm
 * @package Siteprivate\Form
 */
class SiteprivateRegistrationForm extends PrivatespaceloginForm {

    /**
     * SiteprivateRegistrationForm constructor.
     * @param null $name
     */
    public function __construct($name = null) {
        // we want to ignore the name passed
        parent::__construct('privatespacelogin');

        $utils = new Utils();

        $captcha = new \Laminas\Captcha\Figlet(array(
            
            'wordLen' => 4,
            'timeout' => 1800,
        ));
        
        $this->add(array(
            'name' => 'pwdconfirm',
            'attributes' => array(
                'type' => 'password',
                'id' => 'pwdconfirmIdTag'
            ),
            'options' => array(
                'label' => $utils->translate('Mot de passe'),
            ),
        ));
        
        $this->add(array(
            'name' => 'logincaptcha',
            'attributes' => array(
                'placeholder' => $utils->translate('saisir les caractères')
            ),
            'options' => array(
                'label' => $utils->translate('Vérification'),
                'captcha' => $captcha
                
            ),
            'type'  => 'Laminas\Form\Element\Captcha'
            
        )); 
        
        $this->add
                (
                array
                    (
                    'type' => 'Laminas\Form\Element\Csrf',
                    'name' => 'prevent',
                    'attributes' => array
                        (
                        'type' => 'text'
                    ),
                    'options' => array
                        (
                        'csrf_options' => array
                            (
                            'timeout' => 1800
                        )
                    ),
                )
        );
        
    }

}
