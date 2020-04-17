<?php

namespace Siteprivate\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use ExtLib\Utils;

/**
 * Class SiteprivateupdateInfoInputFilter
 * @package Siteprivate\Form
 */
class SiteprivateupdateInfoInputFilter extends InputFilter {
    
    protected $translator;

    /**
     * SiteprivateupdateInfoInputFilter constructor.
     */
    public function __construct() {
        
        $this->translator = new Utils();

        $this->add(array(
            'name' => 'id',
            'required' => true,
            'filters' => array(
                array('name' => 'Int'),),
        ));
                
        $this->add(array(
            'name' => 'email',
            'required' => true,
            'filters' => array(
                array('name' => 'Zend\Filter\StripTags'),
                array('name' => 'Zend\Filter\StringTrim'),)
        ));
        
        $this->add(array(
            'name' => 'pwd',
            'required' => true,
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),),
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'min' => 5,
                        'max' => 512,
                        'messages' => array(
                            \Zend\Validator\StringLength::TOO_SHORT => $this->translator->translate('La taille minimum du mot de passe est de 5 caractères'),
                            \Zend\Validator\StringLength::TOO_LONG => $this->translator->translate('La taille du mot de passe doit pas dépasser 128 caractères'),
                            \Zend\Validator\StringLength::INVALID => $this->translator->translate('La taille du mot de passe ne doit pas dépasser 128 caractères'),
                        ),),),
                array(
                    'name' => 'NotEmpty',
                    'options' => array(
                        'messages' => array(
                            \Zend\Validator\NotEmpty::IS_EMPTY => $this->translator->translate('Vous devez saisir un mot de passe de 5 caractères minimum')
                        ),
                    ),
                ),
            ),
        ));
        
        $this->add(array(
            'name' => 'firstname',
            'required' => true,
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),),
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'min' => 2,
                        'max' => 128,
                        'messages' => array(
                            \Zend\Validator\StringLength::TOO_SHORT => $this->translator->translate('La taille minimum du nom est de 3 caractères minimum'),
                            \Zend\Validator\StringLength::TOO_LONG => $this->translator->translate('La taille du nom doit pas dépasser 128 caractères'),
                            \Zend\Validator\StringLength::INVALID => $this->translator->translate('La taille du nom ne doit pas dépasser 128 caractères'),
                        ),),),
                array(
                    'name' => 'NotEmpty',
                    'options' => array(
                        'messages' => array(
                            \Zend\Validator\NotEmpty::IS_EMPTY => $this->translator->translate('Vous devez saisir un nom')
                        ),
                    ),
                ),
            ),
        ));
        
        $this->add(array(
            'name' => 'lastname',
            'required' => true,
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),),
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'min' => 2,
                        'max' => 128,
                        'messages' => array(
                            \Zend\Validator\StringLength::TOO_SHORT => $this->translator->translate('La taille minimum du nom est de 3 caractères minimum'),
                            \Zend\Validator\StringLength::TOO_LONG => $this->translator->translate('La taille du nom doit pas dépasser 128 caractères'),
                            \Zend\Validator\StringLength::INVALID => $this->translator->translate('La taille du nom ne doit pas dépasser 128 caractères'),
                        ),),),
                array(
                    'name' => 'NotEmpty',
                    'options' => array(
                        'messages' => array(
                            \Zend\Validator\NotEmpty::IS_EMPTY => $this->translator->translate('Vous devez saisir un nom')
                        ),
                    ),
                ),
            ),
        ));
        
        $this->add(array(
            'name' => 'company',
            'required' => false,
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),),
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'min' => 2,
                        'max' => 128,
                        'messages' => array(
                            \Zend\Validator\StringLength::TOO_SHORT => $this->translator->translate('La taille minimum du nom est de 3 caractères minimum'),
                            \Zend\Validator\StringLength::TOO_LONG => $this->translator->translate('La taille du nom doit pas dépasser 128 caractères'),
                            \Zend\Validator\StringLength::INVALID => $this->translator->translate('La taille du nom ne doit pas dépasser 128 caractères'),
                        ),),),
                array(
                    'name' => 'NotEmpty',
                    'options' => array(
                        'messages' => array(
                            \Zend\Validator\NotEmpty::IS_EMPTY => $this->translator->translate('Vous devez saisir un nom')
                        ),
                    ),
                ),
            ),
        ));
        
        $this->add(array(
            'name' => 'streetnumber',
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
                        'max' => 16,
                        'messages' => array(
                            \Zend\Validator\StringLength::TOO_SHORT => $this->translator->translate('La taille minimum du nom est de 3 caractères minimum'),
                            \Zend\Validator\StringLength::TOO_LONG => $this->translator->translate('La taille du nom doit pas dépasser 128 caractères'),
                            \Zend\Validator\StringLength::INVALID => $this->translator->translate('La taille du nom ne doit pas dépasser 128 caractères'),
                        ),),),
                array(
                    'name' => 'NotEmpty',
                    'options' => array(
                        'messages' => array(
                            \Zend\Validator\NotEmpty::IS_EMPTY => $this->translator->translate('Vous devez saisir un nom')
                        ),
                    ),
                ),
            ),
        ));
        
        $this->add(array(
            'name' => 'streetline_1',
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
                        'max' => 128,
                        'messages' => array(
                            \Zend\Validator\StringLength::TOO_SHORT => $this->translator->translate('La taille minimum du nom est de 3 caractères minimum'),
                            \Zend\Validator\StringLength::TOO_LONG => $this->translator->translate('La taille du nom doit pas dépasser 128 caractères'),
                            \Zend\Validator\StringLength::INVALID => $this->translator->translate('La taille du nom ne doit pas dépasser 128 caractères'),
                        ),),),
                array(
                    'name' => 'NotEmpty',
                    'options' => array(
                        'messages' => array(
                            \Zend\Validator\NotEmpty::IS_EMPTY => $this->translator->translate('Vous devez saisir un nom de rue')
                        ),
                    ),
                ),
            ),
        ));
        
        $this->add(array(
            'name' => 'streetline_2',
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
                        'max' => 128,
                        'messages' => array(
                            \Zend\Validator\StringLength::TOO_SHORT => $this->translator->translate('La taille minimum du nom est de 3 caractères minimum'),
                            \Zend\Validator\StringLength::TOO_LONG => $this->translator->translate('La taille du nom doit pas dépasser 128 caractères'),
                            \Zend\Validator\StringLength::INVALID => $this->translator->translate('La taille du nom ne doit pas dépasser 128 caractères'),
                        ),),),
                array(
                    'name' => 'NotEmpty',
                    'options' => array(
                        'messages' => array(
                            \Zend\Validator\NotEmpty::IS_EMPTY => $this->translator->translate('Vous devez saisir un nom de rue')
                        ),
                    ),
                ),
            ),
        ));
        
        $this->add(array(
            'name' => 'streetline_3',
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
                        'max' => 128,
                        'messages' => array(
                            \Zend\Validator\StringLength::TOO_SHORT => $this->translator->translate('La taille minimum du nom est de 3 caractères minimum'),
                            \Zend\Validator\StringLength::TOO_LONG => $this->translator->translate('La taille du nom doit pas dépasser 128 caractères'),
                            \Zend\Validator\StringLength::INVALID => $this->translator->translate('La taille du nom ne doit pas dépasser 128 caractères'),
                        ),),),
                array(
                    'name' => 'NotEmpty',
                    'options' => array(
                        'messages' => array(
                            \Zend\Validator\NotEmpty::IS_EMPTY => $this->translator->translate('Vous devez saisir un nom de rue')
                        ),
                    ),
                ),
            ),
        ));
        
        $this->add(array(
            'name' => 'zipcode',
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
                        'max' => 32,
                        'messages' => array(
                            \Zend\Validator\StringLength::TOO_SHORT => $this->translator->translate('La taille minimum est de 3 caractères minimum'),
                            \Zend\Validator\StringLength::TOO_LONG => $this->translator->translate('La taille doit pas dépasser 128 caractères'),
                            \Zend\Validator\StringLength::INVALID => $this->translator->translate('La taille ne doit pas dépasser 128 caractères'),
                        ),),),
                array(
                    'name' => 'NotEmpty',
                    'options' => array(
                        'messages' => array(
                            \Zend\Validator\NotEmpty::IS_EMPTY => $this->translator->translate('Vous devez saisir un code postal')
                        ),
                    ),
                ),
            ),
        ));
        
        $this->add(array(
            'name' => 'city',
            'required' => true,
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),),
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'min' => 2,
                        'max' => 128,
                        'messages' => array(
                            \Zend\Validator\StringLength::TOO_SHORT => $this->translator->translate('La taille minimum du nom est de 3 caractères minimum'),
                            \Zend\Validator\StringLength::TOO_LONG => $this->translator->translate('La taille du nom doit pas dépasser 128 caractères'),
                            \Zend\Validator\StringLength::INVALID => $this->translator->translate('La taille du nom ne doit pas dépasser 128 caractères'),
                        ),),),
                array(
                    'name' => 'NotEmpty',
                    'options' => array(
                        'messages' => array(
                            \Zend\Validator\NotEmpty::IS_EMPTY => $this->translator->translate('Vous devez saisir un nom de ville')
                        ),
                    ),
                ),
            ),
        ));

        $this->add(array(
            'name' => 'mobilephone',
            'required' => false,
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),),
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'min' => 2,
                        'max' => 128,
                        'messages' => array(
                            \Zend\Validator\StringLength::TOO_SHORT => $this->translator->translate('La taille minimum du nom est de 3 caractères minimum'),
                            \Zend\Validator\StringLength::TOO_LONG => $this->translator->translate('La taille du nom doit pas dépasser 128 caractères'),
                            \Zend\Validator\StringLength::INVALID => $this->translator->translate('La taille du nom ne doit pas dépasser 128 caractères'),
                        ),),),
                array(
                    'name' => 'NotEmpty',
                    'options' => array(
                        'messages' => array(
                            \Zend\Validator\NotEmpty::IS_EMPTY => $this->translator->translate('Vous devez saisir un numéro de téléphone')
                        ),
                    ),
                ),
            ),
        ));
        
        $this->add(array(
            'name' => 'homephone',
            'required' => false,
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),),
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'min' => 2,
                        'max' => 128,
                        'messages' => array(
                            \Zend\Validator\StringLength::TOO_SHORT => $this->translator->translate('La taille minimum du nom est de 3 caractères minimum'),
                            \Zend\Validator\StringLength::TOO_LONG => $this->translator->translate('La taille du nom doit pas dépasser 128 caractères'),
                            \Zend\Validator\StringLength::INVALID => $this->translator->translate('La taille du nom ne doit pas dépasser 128 caractères'),
                        ),),),
                array(
                    'name' => 'NotEmpty',
                    'options' => array(
                        'messages' => array(
                            \Zend\Validator\NotEmpty::IS_EMPTY => $this->translator->translate('Vous devez saisir un numéro de téléphone')
                        ),
                    ),
                ),
            ),
        ));
        
        $this->add(array(
            'name' => 'website',
            'required' => false,
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),),
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'min' => 4,
                        'max' =>256,
                        'messages' => array(
                            \Zend\Validator\StringLength::TOO_SHORT => $this->translator->translate('La taille minimum du nom est de 3 caractères minimum'),
                            \Zend\Validator\StringLength::TOO_LONG => $this->translator->translate('La taille du nom doit pas dépasser 128 caractères'),
                            \Zend\Validator\StringLength::INVALID => $this->translator->translate('La taille du nom ne doit pas dépasser 128 caractères'),
                        ),),),
                array(
                    'name' => 'NotEmpty',
                    'options' => array(
                        'messages' => array(
                            \Zend\Validator\NotEmpty::IS_EMPTY => $this->translator->translate('Vous devez saisir un nom de site internet')
                        ),
                    ),
                ),
            ),
        ));
    }

}
