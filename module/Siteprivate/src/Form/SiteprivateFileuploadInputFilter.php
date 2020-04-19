<?php
namespace Siteprivate\Form;

use Laminas\Form\Form;
use Laminas\InputFilter\InputFilter;
use Laminas\InputFilter\InputFilterAwareInterface;
use Laminas\InputFilter\InputFilterInterface;

/**
 * Class SiteprivateFileuploadInputFilter
 * @package Siteprivate\Form
 */
class SiteprivateFileuploadInputFilter extends InputFilter{

    /**
     * SiteprivateFileuploadInputFilter constructor.
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
			'name' => 'author',
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
						'max' => 256,),),
				),
		));

        $this->add(array(
            'name' => 'lat',
            'required' => false,
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),),
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'min' => 1,
                        'max' => 128,),),
            ),
        ));

        $this->add(array(
            'name' => 'lng',
            'required' => false,
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),),
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'min' => 1,
                        'max' => 128,),),
            ),
        ));
		
	
	}

}
