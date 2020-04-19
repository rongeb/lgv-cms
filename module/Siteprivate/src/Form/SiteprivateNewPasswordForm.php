<?php

namespace Siteprivate\Form;

use Laminas\Form\Form;
use Laminas\Stdlib\Hydrator\ClassMethods;
use Privatespace\Model\PrivatespaceDao;
use ExtLib\Utils;

/**
 * Class SiteprivateNewPasswordForm
 * @package Siteprivate\Form
 */
class SiteprivateNewPasswordForm extends Form {


    /**
     * SiteprivateNewPasswordForm constructor.
     * @param null $name
     */
    public function __construct($name = null) {
        // we want to ignore the name passed
        parent::__construct('forgotten');

        $translator = new Utils();

        $captcha = new \Laminas\Captcha\Figlet(array(

            'wordLen' => 4,
            'timeout' => 1800,
        ));

        $this->setAttribute('method', 'post');

        $this->add(array(
            'name' => 'pwd',
            'attributes' => array(
                'type' => 'text',
                'id' => 'pwdIdTag'
            ),
            'options' => array(
                'label' => $translator->translate('Mot de passe'),
            ),
        ));

        $this->add(array(
            'name' => 'pwdconfirm',
            'attributes' => array(
                'type' => 'text',
                'id' => 'pwdconfirmIdTag'
            ),
            'options' => array(
                'label' => $translator->translate('Confirmer le mot de passe'),
            ),
        ));

        $this->add(array(
            'name' => 'token',
            'attributes' => array(
                'type' => 'hidden',
                'id' => 'tokenIdTag'
            )
        ));
        
        $this->add(array(
            'name' => 'logincaptcha',
            'attributes' => array(
                'placeholder' => $translator->translate('saisir les caractères')
            ),
            'options' => array(
                'label' => $translator->translate('Vérification'),
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
        
        $this->add(array(
            'name' => 'sweethoney',
            'attributes' => array(
                'type' => 'text',
                'id' => 'sweethoney',
            )
        ));

        $this->add(array(
            'name' => 'submitbutton',
            'type' => 'Laminas\Form\Element\Submit',
            'options' => array(
                'label' => $translator->translate('Valider'),
            ),
            'attributes' =>
            array(
                'value' => $translator->translate('Valider'),
                'id' => 'submitbutton',
            ),
        ));
    }

}
