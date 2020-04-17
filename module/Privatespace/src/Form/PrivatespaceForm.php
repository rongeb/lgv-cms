<?php

namespace Privatespace\Form;

use Zend\Form\Form;
use Zend\Hydrator\ClassMethods;
use ExtLib\Utils;

/**
 * Class PrivatespaceForm
 * @package Privatespace\Form
 */
class PrivatespaceForm extends Form {

    private $translator;

    /**
     * PrivatespaceForm constructor.
     * @param null $name
     */
    public function __construct($name = null) {
        // we want to ignore the name passed
        parent::__construct('space');
        $this->setHydrator(new ClassMethods);
        $this->setAttribute('method', 'post');
        
        $this->translator = new Utils();
        
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
                'label' => $this->translator->translate('Libellé'),
            ),
        ));


        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => $this->translator->translate('Valider'),
                'id' => 'submitbutton',
            ),
        ));
    }

}
