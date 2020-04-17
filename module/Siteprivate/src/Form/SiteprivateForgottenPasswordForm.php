<?php

// module/Rubrique/src/Rubrique/Form/RubriqueForm.php:

namespace Siteprivate\Form;

use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;
use Privatespace\Model\PrivatespaceDao;
use ExtLib\Utils;

/**
 * Class SiteprivateForgottenPasswordForm
 * @package Siteprivate\Form
 */
class SiteprivateForgottenPasswordForm extends Form {

    private $utils;
    //private $captcha;
   /* 
    private function getAllSpaces(){
        $privatespaceDao = new PrivatespaceDao();
        
        $privateSpaces = $privatespaceDao->getAllSpaces("array");
        
        $privatespaceDropdownlist = array();

        foreach ($privateSpaces as $value) {

            $privatespaceDropdownlist[$value['space_id']] = $value['space_name'];
        }
        
        return $privatespaceDropdownlist;
    }
    */
    /**
     * SiteprivateForgottenPasswordForm constructor.
     * @param null $name
     */
    public function __construct($name = null) {
        // we want to ignore the name passed
        parent::__construct('forgottenpassword');

        $this->utils = new Utils();
        
        $captcha = new \Zend\Captcha\Figlet(array(
            
            'wordLen' => 4,
            'timeout' => 1800,
        ));
        
        $this->setAttribute('method', 'post');

        $this->add(array(
            'name' => 'email',
            'attributes' => array(
                'type' => 'text'
            )
        ));
 /*       
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'spacesList',
            'attributes' => array(
                'id' => 'spacesId',
                'class' => 'spacesClass'
            ),
            'options' => array(
                'empty_option' => $this->translator->translate('Sélectionner un espace privé'),
                'value_options' => $this->getAllSpaces(),
                'disable_inarray_validator' => true
            ),
        ));
   */     
        $this->add(array(
            'name' => 'logincaptcha',
            'attributes' => array(
                'placeholder' => $this->utils->translate('saisir les caractères')
            ),
            'options' => array(
                'label' => $this->utils->translate('Vérification'),
                'captcha' => $captcha
                
            ),
            'type'  => 'Zend\Form\Element\Captcha'
            
        ));
        
        $this->add
                (
                array
                    (
                    'type' => 'Zend\Form\Element\Csrf',
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
            'type' => 'Zend\Form\Element\Submit',
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
