<?php
namespace Privatespacelogin\Form;

use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;
use Privatespace\Model\PrivatespaceDao;
use ExtLib\Utils;

/**
 * Class PrivatespaceloginForm
 * @package Privatespacelogin\Form
 */
class PrivatespaceloginForm extends Form {

    private $translator;

    /**
     * @return array
     */
    private function getAllSpaces(){
        $privatespaceDao = new PrivatespaceDao();
        
        $privateSpaces = $privatespaceDao->getAllSpaces("array");
        
        $privatespaceDropdownlist = array();

        foreach ($privateSpaces as $value) {

            $privatespaceDropdownlist[$value['space_id']] = $value['space_name'];
        }
        
        return $privatespaceDropdownlist;
    }

    /**
     * PrivatespaceloginForm constructor.
     * @param null $name
     */
    public function __construct($name = null) {
        // we want to ignore the name passed
        parent::__construct('privatespacelogin');
        
        $this->translator = new Utils();

        $this->setAttribute('method', 'post');

        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type' => 'hidden',
            ),
        ));

        $this->add(array(
            'name' => 'email',
            'attributes' => array(
                'type' => 'text',
            ),
            'options' => array(
                'label' => $this->translator->translate('Email'),
            ),
        ));
        $this->add(array(
            'name' => 'pwd',
            'attributes' => array(
                'type' => 'password',
                'id' => 'pwdIdTag'
            ),
            'options' => array(
                'label' => $this->translator->translate('Mot de passe'),
            ),
        ));

        $this->add(array(
            'name' => 'firstname',
            'attributes' => array(
                'type' => 'text',
            ),
            'options' => array(
                'label' => $this->translator->translate('Prénom'),
            ),
        ));

        $this->add(array(
            'name' => 'lastname',
            'attributes' => array(
                'type' => 'text',
            ),
            'options' => array(
                'label' => $this->translator->translate('Nom'),
            ),
        ));

        $this->add(array(
            'name' => 'company',
            'attributes' => array(
                'type' => 'text',
            ),
            'options' => array(
                'label' => $this->translator->translate('Société'),
            ),
        ));

        $this->add(array(
            'name' => 'streetnumber',
            'attributes' => array(
                'type' => 'text',
            ),
            'options' => array(
                'label' => $this->translator->translate('Numéro de voie'),
            ),
        ));

        $this->add(array(
            'name' => 'streetline_1',
            'attributes' => array(
                'type' => 'text',
            ),
            'options' => array(
                'label' => $this->translator->translate('Libellé de la rue ligne 1'),
            ),
        ));

        $this->add(array(
            'name' => 'streetline_2',
            'attributes' => array(
                'type' => 'text',
            ),
            'options' => array(
                'label' => $this->translator->translate('Libellé de la rue ligne 2'),
            ),
        ));

        $this->add(array(
            'name' => 'streetline_3',
            'attributes' => array(
                'type' => 'text',
            ),
            'options' => array(
                'label' => $this->translator->translate('Libellé de la rue ligne 3'),
            ),
        ));

        $this->add(array(
            'name' => 'zipcode',
            'attributes' => array(
                'type' => 'text',
            ),
            'options' => array(
                'label' => $this->translator->translate('Code postal'),
            ),
        ));

        $this->add(array(
            'name' => 'city',
            'attributes' => array(
                'type' => 'text',
            ),
            'options' => array(
                'label' => $this->translator->translate('Ville'),
            ),
        ));

        $this->add(array(
            'name' => 'mobilephone',
            'attributes' => array(
                'type' => 'text',
            ),
            'options' => array(
                'label' => $this->translator->translate('Téléphone mobile'),
            ),
        ));

        $this->add(array(
            'name' => 'homephone',
            'attributes' => array(
                'type' => 'text',
            ),
            'options' => array(
                'label' => $this->translator->translate('Téléphone fixe'),
            ),
        ));
        
        $this->add(array(
            'name' => 'website',
            'attributes' => array(
                'type' => 'text',
            ),
            'options' => array(
                'label' => $this->translator->translate('Site web'),
            ),
        ));
        
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
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'validate',
            'attributes' => array(
                'id' => 'validateId',
                'class' => 'validateClass'
            ),
            'options' => array(
                'empty_option' => $this->translator->translate('Voulez-vous valider l\'inscription'),
                'value_options' => array(0=>$this->translator->translate('Oui'),1=>$this->translator->translate('Non')),
                'disable_inarray_validator' => true
            ),
        ));
        
        $this->add(array(
            'name' => 'sweethoney',
            'attributes' => array(
                'type' => 'text',
                'id' => 'sweethoney',
            )
        ));

        $this->add(array(
            'name' => 'submitbutton',
            'type' => 'Zend\Form\Element\Button',
            'options' => array(
                'label' => $this->translator->translate('Valider'),
            ),
            'attributes' =>
            array(
                'value' => $this->translator->translate('Valider'),
                'id' => 'submitbutton',
            ),
        ));
    }
}
