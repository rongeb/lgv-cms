<?php

namespace Linktocontenu\Form;


use Laminas\InputFilter\InputFilter;
use ExtLib\Utils;

/**
 * Class LinktocontenuInputFilter
 * @package Linktocontenu\Form
 */
class LinktocontenuInputFilter extends InputFilter {

    protected $translator;
    
    public function __construct() {
        
        $this->translator = new Utils();

        $this->add(array(
            'name' => 'id',
            'required' => true,
            'filters' => array(
                array('name' => 'Int'),),
        ));
/*
        $this->add(array(
            'name' => 'sousrubriques_id',
            'required' => true,
            'filters' => array(
                array('name' => 'Int'),
            )
        ));
*/
        $this->add(array(
            'name' => 'titre',
            'required' => false,
            'filters' => array(
                array('name' => 'Laminas\Filter\StripTags'),
                array('name' => 'Laminas\Filter\StringTrim')
            ),
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'min' => 0,
                        'max' => 128,
                        'messages' => array(
                            \Laminas\Validator\StringLength::TOO_LONG => $this->translator->translate('La taille ne doit pas dépasser 128 caractères'),
                            \Laminas\Validator\StringLength::INVALID => $this->translator->translate('La taille ne doit pas dépasser 128 caractères'),
                        )),),
            ),
        ));
        
        $this->add(array(
            'name' => 'html',
            'required' => false
        ));

        $this->add(array(
            'name' => 'soustitre',
            'required' => false,
            'filters' => array(
                array('name' => 'Laminas\Filter\StripTags'),
                array('name' => 'Laminas\Filter\StringTrim'),),
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'min' => 0,
                        'max' => 128,
                        'messages' => array(
                            \Laminas\Validator\StringLength::TOO_LONG => $this->translator->translate('La taille ne doit pas dépasser 128 caractères'),
                            \Laminas\Validator\StringLength::INVALID => $this->translator->translate('La taille ne doit pas dépasser 128 caractères'),
                        ),),),
            ),
        ));

        $this->add(array(
            'name' => 'position',
            'required' => false,
            'filters' => array(
                array('name' => 'Laminas\Filter\StripTags'),
                array('name' => 'Laminas\Filter\StringTrim'),),
            'validators' => array(
                array(
                    'name' => 'Regex',
                    'options' => array(
                        'pattern' => '/^[-]?[0-9]*$/',
                        'messages' => array(
                            \Laminas\Validator\Regex::NOT_MATCH => $this->translator->translate('La position doit être vide ou doit être un nombre'),
                        ),
                    ),
                ),
        )));
        
        $this->add(array(
            'name' => 'imagepath',
            'required' => false,
            'filters' => array(
                array('name' => 'Laminas\Filter\StripTags'),
                array('name' => 'Laminas\Filter\StringTrim')
            ),
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'min' => 0,
                        'max' => 256,
                        'messages' => array(
                            \Laminas\Validator\StringLength::TOO_LONG => $this->translator->translate('La taille ne doit pas dépasser 256 caractères'),
                            \Laminas\Validator\StringLength::INVALID => $this->translator->translate('La taille ne doit pas dépasser 256 caractères'),
                        )),),
            ),
        ));

        $this->add(array(
            'name' => 'imagepath2',
            'required' => false,
            'filters' => array(
                array('name' => 'Laminas\Filter\StripTags'),
                array('name' => 'Laminas\Filter\StringTrim')
            ),
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'min' => 0,
                        'max' => 256,
                        'messages' => array(
                            \Laminas\Validator\StringLength::TOO_LONG => $this->translator->translate('La taille ne doit pas dépasser 256 caractères'),
                            \Laminas\Validator\StringLength::INVALID => $this->translator->translate('La taille ne doit pas dépasser 256 caractères'),
                        )),),
            ),
        ));

        $this->add(array(
            'name' => 'rubriquesList',
            'required' => true,
            'filters' => array(
                array('name' => 'Laminas\Filter\StripTags'),
                array('name' => 'Laminas\Filter\StringTrim'),),
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'min' => 0,
                        'max' => 128,
                        'messages' => array(
                            \Laminas\Validator\StringLength::TOO_LONG => $this->translator->translate('La taille ne doit pas dépasser 128 caractères'),
                            \Laminas\Validator\StringLength::INVALID => $this->translator->translate('La taille ne doit pas dépasser 128 caractères'),
                        ),),),
                array(
                    'name' => 'NotEmpty',
                    'options' => array(
                        'messages' => array(
                            \Laminas\Validator\NotEmpty::IS_EMPTY => $this->translator->translate('Vous devez choisir une rubrique')
                        ),
                    ),
                ),
            ),
        ));

        $this->add(array(
            'name' => 'sousrubriquesList',
            'required' => true,
            'filters' => array(
                array('name' => 'Laminas\Filter\StripTags'),
                array('name' => 'Laminas\Filter\StringTrim'),),
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'min' => 0,
                        'max' => 128,
                        'messages' => array(
                            \Laminas\Validator\StringLength::TOO_LONG => $this->translator->translate('La taille ne doit pas dépasser 128 caractères'),
                            \Laminas\Validator\StringLength::INVALID => $this->translator->translate('La taille ne doit pas dépasser 128 caractères'),
                        ),),),
                array(
                    'name' => 'NotEmpty',
                    'options' => array(
                        'messages' => array(
                            \Laminas\Validator\NotEmpty::IS_EMPTY => $this->translator->translate('Vous devez choisir une sous-rubrique')
                        ),
                    ),
                ),
            ),
        ));
        
        $this->add(array(
            'name' => 'contenusList',
            'required' => true,
            'filters' => array(
                array('name' => 'Laminas\Filter\StripTags'),
                array('name' => 'Laminas\Filter\StringTrim'),),
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'min' => 0,
                        'max' => 128,
                        'messages' => array(
                            \Laminas\Validator\StringLength::TOO_LONG => $this->translator->translate('La taille ne doit pas dépasser 128 caractères'),
                            \Laminas\Validator\StringLength::INVALID => $this->translator->translate('La taille ne doit pas dépasser 128 caractères'),
                        ),),),
                array(
                    'name' => 'NotEmpty',
                    'options' => array(
                        'messages' => array(
                            \Laminas\Validator\NotEmpty::IS_EMPTY => $this->translator->translate('Vous devez choisir une sous-rubrique')
                        ),
                    ),
                ),
            ),
        ));
        
        $this->add(array(
            'name' => 'rubriqueswhereislinkList',
            'required' => true,
            'filters' => array(
                array('name' => 'Laminas\Filter\StripTags'),
                array('name' => 'Laminas\Filter\StringTrim'),),
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'min' => 0,
                        'max' => 128,
                        'messages' => array(
                            \Laminas\Validator\StringLength::TOO_LONG => $this->translator->translate('La taille ne doit pas dépasser 128 caractères'),
                            \Laminas\Validator\StringLength::INVALID => $this->translator->translate('La taille ne doit pas dépasser 128 caractères'),
                        ),),),
                array(
                    'name' => 'NotEmpty',
                    'options' => array(
                        'messages' => array(
                            \Laminas\Validator\NotEmpty::IS_EMPTY => $this->translator->translate('Vous devez choisir une rubrique')
                        ),
                    ),
                ),
            ),
        ));
        
       $this->add(array(
            'name' => 'sousrubriqueswhereislinkList',
            'required' => true,
            'filters' => array(
                array('name' => 'Laminas\Filter\StripTags'),
                array('name' => 'Laminas\Filter\StringTrim'),),
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'min' => 0,
                        'max' => 128,
                        'messages' => array(
                            \Laminas\Validator\StringLength::TOO_LONG => $this->translator->translate('La taille ne doit pas dépasser 128 caractères'),
                            \Laminas\Validator\StringLength::INVALID => $this->translator->translate('La taille ne doit pas dépasser 128 caractères'),
                        ),),),
                array(
                    'name' => 'NotEmpty',
                    'options' => array(
                        'messages' => array(
                            \Laminas\Validator\NotEmpty::IS_EMPTY => $this->translator->translate('Vous devez choisir une sous-rubrique')
                        ),
                    ),
                ),
            ),
        ));
        
    }

}
