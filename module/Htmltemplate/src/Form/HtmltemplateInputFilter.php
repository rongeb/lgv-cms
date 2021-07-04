<?php

namespace Htmltemplate\Form;


use Laminas\InputFilter\InputFilter;
use ExtLib\Utils;

/**
 * Class HtmltemplateInputFilter
 * @package Htmltemplate\Form
 */
class HtmltemplateInputFilter extends InputFilter
{

    protected $translator;

    /**
     * HtmltemplateInputFilter constructor.
     */
    public function __construct()
    {

        $this->translator = new Utils();

        $this->add(array(
            'name' => 'id',
            'required' => true,
            'filters' => array(
                array('name' => 'Int'),),
        ));

        $this->add(array(
            'name' => 'label',
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
            'name' => 'template',
            'required' => false
        ));
    }

}
