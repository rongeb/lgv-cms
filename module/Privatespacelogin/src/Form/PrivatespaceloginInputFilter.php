<?php

namespace Privatespacelogin\Form;

use Laminas\Form\Form;
use Laminas\InputFilter\InputFilter;
use Laminas\InputFilter\InputFilterAwareInterface;
use Laminas\InputFilter\InputFilterInterface;
use ExtLib\Utils;

/**
 * Class PrivatespaceloginInputFilter
 * @package Privatespacelogin\Form
 */
class PrivatespaceloginInputFilter extends InputFilter {
    
    protected $translator;

    /**
     * PrivatespaceloginInputFilter constructor.
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
                array('name' => 'Laminas\Filter\StripTags'),
                array('name' => 'Laminas\Filter\StringTrim'),),
            'validators' => array(
                array(
                    'name' => 'Regex',
                    'options' => array(
                        'pattern' => '/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/',
                        'messages' => array(
                            \Laminas\Validator\Regex::NOT_MATCH => $this->translator->translate("L'email est invalide"),
                        ),
                    ),
                ),
        )));
        
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
                        'max' => 128,
                        'messages' => array(
                            \Laminas\Validator\StringLength::TOO_SHORT => $this->translator->translate('La taille minimum du mot de passe est de 5 caractères'),
                            \Laminas\Validator\StringLength::TOO_LONG => $this->translator->translate('La taille du mot de passe doit pas dépasser 128 caractères'),
                            \Laminas\Validator\StringLength::INVALID => $this->translator->translate('La taille du mot de passe ne doit pas dépasser 128 caractères'),
                        ),),),
                array(
                    'name' => 'NotEmpty',
                    'options' => array(
                        'messages' => array(
                            \Laminas\Validator\NotEmpty::IS_EMPTY => $this->translator->translate('Vous devez saisir un mot de passe de 5 caractères minimum')
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
                            \Laminas\Validator\StringLength::TOO_SHORT => $this->translator->translate('La taille minimum du nom est de 3 caractères minimum'),
                            \Laminas\Validator\StringLength::TOO_LONG => $this->translator->translate('La taille du nom doit pas dépasser 128 caractères'),
                            \Laminas\Validator\StringLength::INVALID => $this->translator->translate('La taille du nom ne doit pas dépasser 128 caractères'),
                        ),),),
                array(
                    'name' => 'NotEmpty',
                    'options' => array(
                        'messages' => array(
                            \Laminas\Validator\NotEmpty::IS_EMPTY => $this->translator->translate('Vous devez saisir un nom')
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
                            \Laminas\Validator\StringLength::TOO_SHORT => $this->translator->translate('La taille minimum du nom est de 3 caractères minimum'),
                            \Laminas\Validator\StringLength::TOO_LONG => $this->translator->translate('La taille du nom doit pas dépasser 128 caractères'),
                            \Laminas\Validator\StringLength::INVALID => $this->translator->translate('La taille du nom ne doit pas dépasser 128 caractères'),
                        ),),),
                array(
                    'name' => 'NotEmpty',
                    'options' => array(
                        'messages' => array(
                            \Laminas\Validator\NotEmpty::IS_EMPTY => $this->translator->translate('Vous devez saisir un nom')
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
                            \Laminas\Validator\StringLength::TOO_SHORT => $this->translator->translate('La taille minimum du nom est de 3 caractères minimum'),
                            \Laminas\Validator\StringLength::TOO_LONG => $this->translator->translate('La taille du nom doit pas dépasser 128 caractères'),
                            \Laminas\Validator\StringLength::INVALID => $this->translator->translate('La taille du nom ne doit pas dépasser 128 caractères'),
                        ),),),
                array(
                    'name' => 'NotEmpty',
                    'options' => array(
                        'messages' => array(
                            \Laminas\Validator\NotEmpty::IS_EMPTY => $this->translator->translate('Vous devez saisir un nom')
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
                            \Laminas\Validator\StringLength::TOO_SHORT => $this->translator->translate('La taille minimum du nom est de 3 caractères minimum'),
                            \Laminas\Validator\StringLength::TOO_LONG => $this->translator->translate('La taille du nom doit pas dépasser 128 caractères'),
                            \Laminas\Validator\StringLength::INVALID => $this->translator->translate('La taille du nom ne doit pas dépasser 128 caractères'),
                        ),),),
                array(
                    'name' => 'NotEmpty',
                    'options' => array(
                        'messages' => array(
                            \Laminas\Validator\NotEmpty::IS_EMPTY => $this->translator->translate('Vous devez saisir un nom')
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
                            \Laminas\Validator\StringLength::TOO_SHORT => $this->translator->translate('La taille minimum du nom est de 3 caractères minimum'),
                            \Laminas\Validator\StringLength::TOO_LONG => $this->translator->translate('La taille du nom doit pas dépasser 128 caractères'),
                            \Laminas\Validator\StringLength::INVALID => $this->translator->translate('La taille du nom ne doit pas dépasser 128 caractères'),
                        ),),),
                array(
                    'name' => 'NotEmpty',
                    'options' => array(
                        'messages' => array(
                            \Laminas\Validator\NotEmpty::IS_EMPTY => $this->translator->translate('Vous devez saisir un nom')
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
                            \Laminas\Validator\StringLength::TOO_SHORT => $this->translator->translate('La taille minimum du nom est de 3 caractères minimum'),
                            \Laminas\Validator\StringLength::TOO_LONG => $this->translator->translate('La taille du nom doit pas dépasser 128 caractères'),
                            \Laminas\Validator\StringLength::INVALID => $this->translator->translate('La taille du nom ne doit pas dépasser 128 caractères'),
                        ),),),
                array(
                    'name' => 'NotEmpty',
                    'options' => array(
                        'messages' => array(
                            \Laminas\Validator\NotEmpty::IS_EMPTY => $this->translator->translate('Vous devez saisir un nom')
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
                            \Laminas\Validator\StringLength::TOO_SHORT => $this->translator->translate('La taille minimum du nom est de 3 caractères minimum'),
                            \Laminas\Validator\StringLength::TOO_LONG => $this->translator->translate('La taille du nom doit pas dépasser 128 caractères'),
                            \Laminas\Validator\StringLength::INVALID => $this->translator->translate('La taille du nom ne doit pas dépasser 128 caractères'),
                        ),),),
                array(
                    'name' => 'NotEmpty',
                    'options' => array(
                        'messages' => array(
                            \Laminas\Validator\NotEmpty::IS_EMPTY => $this->translator->translate('Vous devez saisir un nom')
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
                            \Laminas\Validator\StringLength::TOO_SHORT => $this->translator->translate('La taille minimum du nom est de 3 caractères minimum'),
                            \Laminas\Validator\StringLength::TOO_LONG => $this->translator->translate('La taille du nom doit pas dépasser 128 caractères'),
                            \Laminas\Validator\StringLength::INVALID => $this->translator->translate('La taille du nom ne doit pas dépasser 128 caractères'),
                        ),),),
                array(
                    'name' => 'NotEmpty',
                    'options' => array(
                        'messages' => array(
                            \Laminas\Validator\NotEmpty::IS_EMPTY => $this->translator->translate('Vous devez saisir un nom')
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
                            \Laminas\Validator\StringLength::TOO_SHORT => $this->translator->translate('La taille minimum du nom est de 3 caractères minimum'),
                            \Laminas\Validator\StringLength::TOO_LONG => $this->translator->translate('La taille du nom doit pas dépasser 128 caractères'),
                            \Laminas\Validator\StringLength::INVALID => $this->translator->translate('La taille du nom ne doit pas dépasser 128 caractères'),
                        ),),),
                array(
                    'name' => 'NotEmpty',
                    'options' => array(
                        'messages' => array(
                            \Laminas\Validator\NotEmpty::IS_EMPTY => $this->translator->translate('Vous devez saisir un nom')
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
                            \Laminas\Validator\StringLength::TOO_SHORT => $this->translator->translate('La taille minimum du nom est de 3 caractères minimum'),
                            \Laminas\Validator\StringLength::TOO_LONG => $this->translator->translate('La taille du nom doit pas dépasser 128 caractères'),
                            \Laminas\Validator\StringLength::INVALID => $this->translator->translate('La taille du nom ne doit pas dépasser 128 caractères'),
                        ),),),
                array(
                    'name' => 'NotEmpty',
                    'options' => array(
                        'messages' => array(
                            \Laminas\Validator\NotEmpty::IS_EMPTY => $this->translator->translate('Vous devez saisir un nom')
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
                            \Laminas\Validator\StringLength::TOO_SHORT => $this->translator->translate('La taille minimum du nom est de 3 caractères minimum'),
                            \Laminas\Validator\StringLength::TOO_LONG => $this->translator->translate('La taille du nom doit pas dépasser 128 caractères'),
                            \Laminas\Validator\StringLength::INVALID => $this->translator->translate('La taille du nom ne doit pas dépasser 128 caractères'),
                        ),),),
                array(
                    'name' => 'NotEmpty',
                    'options' => array(
                        'messages' => array(
                            \Laminas\Validator\NotEmpty::IS_EMPTY => $this->translator->translate('Vous devez saisir un nom')
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
                            \Laminas\Validator\StringLength::TOO_SHORT => $this->translator->translate('La taille minimum du nom est de 3 caractères minimum'),
                            \Laminas\Validator\StringLength::TOO_LONG => $this->translator->translate('La taille du nom doit pas dépasser 128 caractères'),
                            \Laminas\Validator\StringLength::INVALID => $this->translator->translate('La taille du nom ne doit pas dépasser 128 caractères'),
                        ),),),
                array(
                    'name' => 'NotEmpty',
                    'options' => array(
                        'messages' => array(
                            \Laminas\Validator\NotEmpty::IS_EMPTY => $this->translator->translate('Vous devez saisir un nom')
                        ),
                    ),
                ),
            ),
        ));
        
        $this->add(array(
            'name' => 'sweethoney',
            'required' => true,
            'allow_empty' => true,
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),),
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'min' => 0,
                        'max' => 0,),),
            ),
        ));
        
        $this->add(array(
            'name' => 'spacesList',
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
                            \Laminas\Validator\NotEmpty::IS_EMPTY => $this->translator->translate('Vous devez choisir un espace privé')
                        ),
                    ),
                ),
            ),
        ));
        
        $this->add(array(
            'name' => 'validate',
            'required' => true,
            'filters' => array(
                array('name' => 'Int'),),
            'validators' => array(
               array(
                    'name' => 'NotEmpty',
                    'options' => array(
                        'messages' => array(
                            \Laminas\Validator\NotEmpty::IS_EMPTY => $this->translator->translate('Vous devez préciser si vous validez l\'inscription')
                        ),
                    ),
                ),
            ),
        ));
        
    }

}
