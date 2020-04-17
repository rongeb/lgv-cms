<?php

// module/SousRubrique/src/SousRubrique/Form/SousRubriqueForm.php:

namespace Commentaire\Form;

use Zend\Form\Form;
use Zend\Form\Element;
use Rubrique\Model\RubriqueDao;
use Message\Model\TypeMessage;
use ExtLib\Utils;

/**
 * Class CommentaireForm
 * @package Commentaire\Form
 */
class CommentaireForm extends Form {
   
    private $utils;

    /**
     * @return array
     */
    protected function getRubriques() {

        $rubriquesDao = new RubriqueDao();

        $rubriques = $rubriquesDao->getAllRubriques("array");

        $rubriqueArray = array();

        foreach ($rubriques as $value) {

            $rubriqueArray[$value['id']] = $value['libelle'];
        }

        return $rubriqueArray;
    }

    /**
     * CommentaireForm constructor.
     * @param null $name
     */
    public function __construct($name = null) {
        // we want to ignore the name passed
        parent::__construct('commentaireform');
        
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
                'label' => $this->utils->translate('Autre'),
            ),
        ));
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'rubriquesList',
            'attributes' => array(
                'id' => 'rubriqueSelectIdTag',
                'class' => 'rubriqueSelectIdClass'
            ),
            'options' => array(
                //'label' => 'Choisir la rubrique',
                'empty_option' => $this->utils->translate('Sélectionner une rubrique'),
                //'class' => 'input-medium',
                'value_options' => $this->getRubriques(),
                'disable_inarray_validator' => true
            ),
        ));
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'contenusList',
			'attributes'=>array(
				'id'   => 'contenuSelectIdTag',
				'class'	   => 'contenuSelectIdClass'
			),
			'options' => array(
				//'label' => 'Choisir la rubrique',
				'empty_option' => $this->utils->translate('Sélectionner un contenu'),
                                'disable_inarray_validator' => true
                
            ),
			
        ));
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'statusList',
			'attributes'=>array(
				'id'   => 'statusSelectIdTag',
				'class'	   => 'statusSelectIdClass'
			),
			'options' => array(
				//'label' => 'Choisir la rubrique',
				'empty_option' => $this->utils->translate('Sélectionner un statut'),
                                'value_options' => array(0 =>$this->utils->translate('non validé'), 1=>$this->utils->translate("validé")),
                                'disable_inarray_validator' => true
                
            ),
			
        ));
        /*
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'typeList',
			'attributes'=>array(
				'id'   => 'typeSelectIdTag',
				'class'	   => 'typeSelectIdClass'
			),
			'options' => array(
				//'label' => 'Choisir la rubrique',
				'empty_option' => 'Sélectionner le type de commentaire',
                                'value_options' => array(
                                    TypeMessage::$blog =>TypeMessage::$blog, 
                                    TypeMessage::$contact=>TypeMessage::$contact,
                                    TypeMessage::$goldenbook=>TypeMessage::$goldenbook),
                                'disable_inarray_validator' => true
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
            'type' => 'Zend\Form\Element\Textarea',
            'name' => 'msg',
            'attributes' => array(
                'id' => 'msgId',
                'class' => 'msgClass'
            ),
            'options' => array(
                'label' => $this->utils->translate('Contenu du commentaire'),
            )
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Button',
            'name' => 'submitbutton',
            'options' => array(
                'label' => $this->utils->translate('Valider'),
            ),
            'attributes' => array(
                'value' => 'Valider',
                'id' => 'submitbutton',
            ),
        ));
    }

}
