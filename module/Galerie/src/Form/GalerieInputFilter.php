<?php

namespace Galerie\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Contenu\Form\ContenuInputFilter;
use ExtLib\Utils;

/**
 * Class GalerieInputFilter
 * @package Galerie\Form
 */
class GalerieInputFilter extends ContenuInputFilter {

    /**
     * GalerieInputFilter constructor.
     */
    public function __construct() {

        parent::__construct();
        
        $this->translator=new Utils();

        $this->add(array(
            'name' => 'imagepath',
            'required' => false,
            'filters' => array(
                array('name' => 'Zend\Filter\StripTags'),
                array('name' => 'Zend\Filter\StringTrim')
            ),
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'min' => 0,
                        'max' => 256,
                        'messages' => array(
                            \Zend\Validator\StringLength::TOO_LONG => $this->translator->translate('La taille ne doit pas dépasser 256 caractères'),
                            \Zend\Validator\StringLength::INVALID => $this->translator->translate('La taille ne doit pas dépasser 256 caractères'),
                        )),),
            ),
        ));

        $this->add(array(
            'name' => 'imagepath2',
            'required' => false,
            'filters' => array(
                array('name' => 'Zend\Filter\StripTags'),
                array('name' => 'Zend\Filter\StringTrim')
            ),
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'min' => 0,
                        'max' => 256,
                        'messages' => array(
                            \Zend\Validator\StringLength::TOO_LONG => $this->translator->translate('La taille ne doit pas dépasser 256 caractères'),
                            \Zend\Validator\StringLength::INVALID => $this->translator->translate('La taille ne doit pas dépasser 256 caractères'),
                        )),),
            ),
        ));
    }

}
