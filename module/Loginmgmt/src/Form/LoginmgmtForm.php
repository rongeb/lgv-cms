<?php
namespace Loginmgmt\Form;

use Laminas\Form\Form;
use Laminas\Hydrator\ClassMethods;
use ExtLib\Utils;

/**
 * Class LoginmgmtForm
 * @package Loginmgmt\Form
 */
class LoginmgmtForm extends Form {

    private $translator;

    /**
     * LoginmgmtForm constructor.
     * @param null $name
     */
    public function __construct($name = null) {
        // we want to ignore the name passed
        parent::__construct('loginmgmt');
        $this->setHydrator(new ClassMethods);

        $this->translator = new Utils();

        $this->setAttribute('method', 'post');

        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type' => 'hidden',
            ),
        ));

        $this->add(array(
            'name' => 'name',
            'attributes' => array(
                'type' => 'text',
            ),
            'options' => array(
                'label' => $this->translator->translate('Nom'),
            ),
        ));
        $this->add(array(
            'name' => 'pwd',
            'attributes' => array(
                'type' => 'text',
                'id' => 'pwdIdTag'
            ),
            'options' => array(
                'label' => $this->translator->translate('Mot de passe'),
            ),
        ));

        $this->add(array(
            'type' => 'Laminas\Form\Element\Select',
            'name' => 'roleList',
            'attributes' => array(
                'id' => 'roleSelectIdTag',
                'class' => 'roleSelectIdClass'
            ),
            'options' => array(
                'empty_option' => $this->translator->translate('Sélectionner un rôle'),
                'value_options' => array('anonymous' => $this->translator->translate('Site public'), 'user' => $this->translator->translate('Utilisateur Back Office'), 'admin' => $this->translator->translate('Administrateur')),
                'disable_inarray_validator' => true
            ),
        ));


        $this->add(array(
            'name' => 'submitbutton',
            'type' => 'Laminas\Form\Element\Button',
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
