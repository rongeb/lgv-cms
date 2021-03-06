<?php

namespace Message\Form;

use Laminas\InputFilter\InputFilter;
use ExtLib\Utils;

/**
 * Class MessageInputFilter
 * @package Message\Form
 */
class MessageInputFilter extends InputFilter {

    protected $translator;

    /**
     * MessageInputFilter constructor.
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
            'name' => 'row1',
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
            'name' => 'row2',
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
            'name' => 'row3',
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
            'name' => 'row4',
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
            'name' => 'timestamp',
            'required' => true,
            'filters' => array(
                array('name' => 'Laminas\Filter\StripTags'),
                array('name' => 'Laminas\Filter\StringTrim')
            ),
            'validators' => array(
                array(
                    'name' => 'Regex',
                    'options' => array(
                        'pattern' => '/\\A(?:^((\\d{2}(([02468][048])|([13579][26]))[\\-\\/\\s]?((((0?[13578])|(1[02]))[\\-\\/\\s]?((0?[1-9])|([1-2][0-9])|(3[01])))|(((0?[469])|(11))[\\-\\/\\s]?((0?[1-9])|([1-2][0-9])|(30)))|(0?2[\\-\\/\\s]?((0?[1-9])|([1-2][0-9])))))|(\\d{2}(([02468][1235679])|([13579][01345789]))[\\-\\/\\s]?((((0?[13578])|(1[02]))[\\-\\/\\s]?((0?[1-9])|([1-2][0-9])|(3[01])))|(((0?[469])|(11))[\\-\\/\\s]?((0?[1-9])|([1-2][0-9])|(30)))|(0?2[\\-\\/\\s]?((0?[1-9])|(1[0-9])|(2[0-8]))))))(\\s(((0?[0-9])|(1[0-9])|(2[0-3]))\\:([0-5][0-9])((\\s)|(\\:([0-5][0-9])))?))?$)\\z/',
                        'messages' => array(
                             \Laminas\Validator\Regex::NOT_MATCH => $this->translator->translate('La date n\'est pas valide')
                        )
                    )
             ),
                array(
                    'name' => 'NotEmpty',
                    'options' => array(
                        'messages' => array(
                            \Laminas\Validator\NotEmpty::IS_EMPTY => $this->translator->translate('Vous devez saisir une date')
                        ),
                    ),
                ),
                )
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
            'name' => 'type',
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

    }

}
