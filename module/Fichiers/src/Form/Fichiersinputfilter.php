<?php
namespace Fichiers\Form;

use Laminas\Form\Form;
use Laminas\InputFilter\InputFilter;
use Laminas\InputFilter\InputFilterAwareInterface;
use Laminas\InputFilter\InputFilterInterface;

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
