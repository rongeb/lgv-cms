<?php

namespace Htmltemplate\Form;

use Zend\Form\Form;
use Zend\Form\Element;
use ExtLib\Utils;

/**
 * Class HtmltemplateForm
 * @package Htmltemplate\Form
 */
class HtmltemplateForm extends Form {

    protected $utils;

    /**
     * HtmltemplateForm constructor.
     * @param null $name
     */
    public function __construct($name = null) {
        
        $this->utils = new Utils(); 

        // we want to ignore the name passed
        parent::__construct('htmltemplateform');
        $this->setAttribute('method', 'post');

        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type' => 'hidden',
                'value' => 0
            ),
        ));

        $this->add(array(
            'name' => 'label',
            'attributes' => array(
                'type' => 'text'
            ),
            'options' => array(
                'label' => $this->utils->translate('Titre'),
            ),
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Textarea',
            'name' => 'template',
            'attributes' => array(
                'id' => 'templateId',
                'class' => 'templateClass'
            )
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Button',
            'name' => 'submitbutton',
            'options' => array(
                'label' => $this->utils->translate('Valider'),
            ),
            'attributes' => array(
                'value' => $this->utils->translate('Valider'),
                'id' => 'submitbutton',
                'class' => 'btn-info'
            ),
        ));
    }
}
