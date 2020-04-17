<?php
namespace Fichiers\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

/**
 * Class FichiersinputFilter
 * @package Fichiers\Form
 */
class FichiersinputFilter extends InputFilter{

    /**
     * FichiersinputFilter constructor.
     */
    public function __construct(){
	
		$this->add(array(
			'name' => 'id',
			'required' => true,
			'filters' => array(
				array('name' => 'Int'),),
		));
		/*
		$this->add(array(
			'name' => 'rubriques_id',
			'required' => true,
			'filters' => array(
				array('name' => 'Int'),),
		));
		*/
		$this->add(array(
			'name' => 'libelle',
			'required' => true,
			'filters' => array(
					array('name' => 'StripTags'),
					array('name' => 'StringTrim'),),
			'validators' => array(
					array(
						'name' => 'StringLength',
						'options' => array(
						'encoding' => 'UTF-8',
						'min' => 1,
						'max' => 100,),),
				),
		));
		
	
	}

}
