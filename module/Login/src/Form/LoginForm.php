<?php

namespace Login\Form;

use Laminas\Form\Form;
use ExtLib\Utils;

/**
 * Class LoginForm
 * @package Login\Form
 */
class LoginForm extends Form {
    
    private $captcha;
    private $utils;

    /**
     * LoginForm constructor.
     * @param null $name
     */
    public function __construct($name = null) {
        // we want to ignore the name passed
        parent::__construct('login');
        
        $this->utils = new Utils();
        
        //$this->setHydrator(new ClassMethods);
        $this->setAttribute('method', 'post');
        $this->setAttribute('autocomplete','off');
        
        /*
        $this->captcha = new CaptchaImage(array(
            'expiration' => '300',
            'wordlen' => '7',
            'font' => 'data/font/arial.ttf',
            'fontSize' => '20',
            'imgDir' => 'public/captcha',
            'imgUrl' => '/mobiletools/public/captcha/'
        ));
        */
        
        $this->captcha = new \Laminas\Captcha\Figlet(array(
            
            'wordLen' => 6,
            'timeout' => 1200,
        ));
        
        
        $this->add(array(
            'name' => 'username',
            'attributes' => array(
                'type' => 'text',
                'id' => 'usernameIdTag',
                'placeholder' => $this->utils->translate('utilisateur')
            ),
            'options' => array(
                'label' => $this->utils->translate('Utilisateur'),
            ),
        ));

        $this->add(array(
            'name' => 'password',
            'attributes' => array(
                'type' => 'password',
                'id' => 'passwordIdTag',
                'placeholder' => $this->utils->translate('mot de passe')
            ),
            'options' => array(
                'label' => $this->utils->translate('Mot de passe'),
            ),
        ));
        /*
        $this->add(array(
            'name' => 'logincaptcha',
            'options' => array(
                'label' => 'Verification',
                'captcha' => $this->captcha,
            ),
            'type'  => 'Laminas\Form\Element\Captcha',
        ));
         * */
        $this->add(array(
            'name' => 'logincaptcha',
            'attributes' => array(
                'placeholder' => $this->utils->translate('saisir les caractères')
            ),
            'options' => array(
                'label' => $this->utils->translate('Vérification'),
                'captcha' => $this->captcha
                
            ),
            'type'  => 'Laminas\Form\Element\Captcha'
            
        )); 
        /*
          $this->add(array(
          'type' => 'Laminas\Form\Element\Csrf',
          'name' => 'prevent',
          'options' => array(
          'csrf_options' => array(
          'timeout' => 600
          )
          )
          ));
         */
        // CSRF field
        
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
                            'timeout' => 1200
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
                        'type' => 'Laminas\Form\Element\Button',
                        'options' => array(
                            'label' => $this->utils->translate('Valider'),
                        ),
			'attributes' => 
                        array(
			
			'value' => $this->utils->translate('Valider'),
			'id' => 'submitbutton',
                    ),
                ));
    }

}
