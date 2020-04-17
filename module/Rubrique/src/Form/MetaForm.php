<?php

// module/Rubrique/src/Rubrique/Form/RubriqueForm.php:

namespace Rubrique\Form;

use Zend\Form\Form;
//use Zend\Stdlib\Hydrator\ClassMethods;
use ExtLib\Utils;

/**
 * Class MetaForm
 * @package Rubrique\Form
 */
class MetaForm extends Form {

    private $translator;

    /**
     * MetaForm constructor.
     * @param null $name
     */
    public function __construct($name = null) {

        parent::__construct('metaform');
        //$this->setHydrator(new ClassMethods);
        
        $this->translator = new Utils();

        $this->setAttribute('method', 'post');

        $this->add(array(
            'name' => 'metaid',
            'attributes' => array(
                'type' => 'hidden',
            ),
        ));

        $this->add(array(
            'name' => 'rubriqueid',
            'attributes' => array(
                'type' => 'hidden',
            ),
        ));

        $this->add(array(
            'name' => 'metakey',
            'attributes' => array(
                'type' => 'text',
            ),
            'options' => array(
                'label' => $this->translator->translate('Meta clé'),
            ),
        ));

        $this->add(array(
            'name' => 'metavalue',
            'attributes' => array(
                'type' => 'text',
            ),
            'options' => array(
                'label' => $this->translator->translate('Meta valeur'),
            ),
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Button',
            'name' => 'metasubmit',
            'options' => array(
                'label' => $this->translator->translate('Valider'),
            ),
            'attributes' => array(
                'value' => 'ajouterMeta',
                'id' => 'metasubmitbutton',
            ),
        ));
    }

}
