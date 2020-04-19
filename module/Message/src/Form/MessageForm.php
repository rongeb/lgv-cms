<?php

namespace Message\Form;

use Laminas\Form\Form;
use Laminas\Form\Element;
use Message\Model\TypeMessage;
use ExtLib\Utils;

/**
 * Class MessageForm
 * @package Message\Form
 */
class MessageForm extends Form {
   
    private $utils;

    /**
     * MessageForm constructor.
     * @param null $name
     */
    public function __construct($name = null) {
        // we want to ignore the name passed
        parent::__construct('messageform');
        
        $this->utils = new Utils();
        
        //$this->setHydrator(new ClassMethods);
        $this->setAttribute('method', 'post');

        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type' => 'hidden',
            ),
        ));

        $this->add(array(
            'name' => 'row1',
            'attributes' => array(
                'type' => 'text'
            ),
            'options' => array(
                'label' => $this->utils->translate('Nom'),
            ),
        ));
        
        $this->add(array(
            'name' => 'row2',
            'attributes' => array(
                'type' => 'text'
            ),
            'options' => array(
                'label' => $this->utils->translate('Entreprise'),
            ),
        ));
        
        $this->add(array(
            'name' => 'row3',
            'attributes' => array(
                'type' => 'text'
            ),
            'options' => array(
                'label' => $this->utils->translate('Email'),
            ),
        ));
        
        $this->add(array(
            'name' => 'row4',
            'attributes' => array(
                'type' => 'text'
            ),
            'options' => array(
                'label' => $this->utils->translate('Autre ligne')
            ),
        ));
        /*
        $this->add(array(
            'name' => 'type',
            'attributes' => array(
                'type' => 'text'
            ),
            'options' => array(
                'label' => 'Type de message',
            ),
        ));
         
         */
        
        $this->add(array(
            'type' => 'Laminas\Form\Element\Select',
            'name' => 'type',
			'attributes'=>array(
				'id'   => 'typeSelectIdTag',
				'class'	   => 'typeSelectIdClass'
			),
			'options' => array(
				//'label' => 'Choisir la rubrique',
				'empty_option' => $this->utils->translate('Sélectionner le type de message'),
                                'value_options' => array(
                                    TypeMessage::$blog =>TypeMessage::$blog, 
                                    TypeMessage::$contact=>TypeMessage::$contact,
                                    TypeMessage::$goldenbook=>TypeMessage::$goldenbook),
                                'disable_inarray_validator' => true
            ),
	));
        
        
        /*
        $this->add(array(
            'name' => 'position',
            'attributes' => array(
                'type' => 'text'
            ),
            'options' => array(
                'label' => 'Position',
            ),
        ));
        */
        $this->add(array(
            'name' => 'timestamp',
            'attributes' => array(
                'type' => 'text'
            ),
            'options' => array(
                'label' => 'Date format yyyy-mm-dd hh:ii:ss',
            )
        ));

        $this->add(array(
            'type' => 'Laminas\Form\Element\Textarea',
            'name' => 'msg',
            'attributes' => array(
                'id' => 'msgId',
                'class' => 'msgClass'
            ),
            'options' => array(
                'label' => $this->utils->translate('Contenu du message'),
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
                'id' => 'submitbutton',
            ),
        ));
    }

}
