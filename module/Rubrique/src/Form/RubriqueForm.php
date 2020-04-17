<?php

namespace Rubrique\Form;

use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods;
use ExtLib\Utils;
use Privatespace\Model\PrivatespaceDao;

/**
 * Class RubriqueForm
 * @package Rubrique\Form
 */
class RubriqueForm extends Form
{

    private $translator;

    /**
     * @return array
     */
    protected function getSpaces()
    {

        $spaceDao = new PrivatespaceDao();
        $spaces = $spaceDao->getAllSpaces("array");

        $spaceArray = array();
        $spaceArray['-1'] = 'Sélectionner un Espace';

        foreach ($spaces as $value) {
            $spaceArray[$value['space_id']] = $value['space_name'];
        }

        return $spaceArray;
    }

    /**
     * RubriqueForm constructor.
     * @param null $name
     */
    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('rubrique');
        //$this->setHydrator(new ClassMethods);
        $this->setAttribute('method', 'post');

        $this->translator = new Utils();

        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type' => 'hidden',
            ),
        ));
        $this->add(array(
            'name' => 'libelle',
            'attributes' => array(
                'type' => 'text',
            ),
            'options' => array(
                'label' => $this->translator->translate('Libellé'),
            ),
        ));
        $this->add(array(
            'name' => 'rang',
            'attributes' => array(
                'type' => 'text',
            ),
            'options' => array(
                'label' => $this->translator->translate('Position'),
            ),
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'scope',
            'attributes' => array(
                'id' => 'scopeId',
                'class' => 'scopeClass'
            ),
            'options' => array(
                'value_options' => array('public' => $this->translator->translate('public'), 'private' => $this->translator->translate("privé"))
            ),
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'contactForm',
            'attributes' => array(
                'id' => 'hasContactFormId',
                'class' => 'hasContactFormClass'
            ),
            'options' => array(
                'value_options' => array(1 => $this->translator->translate('Oui'), 0 => $this->translator->translate("Non"))
            ),
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'messageForm',
            'attributes' => array(
                'id' => 'hasMessageFormId',
                'class' => 'hasMessageFormClass'
            ),
            'options' => array(
                'value_options' => array(1 => $this->translator->translate('Oui'), 0 => $this->translator->translate("Non"))
            ),
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'updateForm',
            'attributes' => array(
                'id' => 'hasUpdateFormId',
                'class' => 'hasUpdateFormClass'
            ),
            'options' => array(
                'value_options' => array(1 => $this->translator->translate('Oui'), 0 => $this->translator->translate("Non"))
            ),
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'fileuploadForm',
            'attributes' => array(
                'id' => 'fileuploadFormId',
                'class' => 'fileuploadFormClass'
            ),
            'options' => array(
                'value_options' => array(1 => $this->translator->translate('Oui'), 0 => $this->translator->translate("Non"))
            ),
        ));

        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'spaceId',
            'attributes' => array(
                'id' => 'spacesListId',
                'class' => 'spacesListClass'
            ),
            'options' => array(
                //'label' => 'Choisir la rubrique',
                //'empty_option' => $this->translator->translate('Sélectionner un Espace'),

                //'class' => 'input-medium',
                'value_options' => $this->getSpaces()
            ),
        ));

        $this->add(array(
            'name' => 'filename',
            'attributes' => array(
                'type' => 'text',
                'id' => 'filenameId'
            ),
            'options' => array(
                'label' => $this->translator->translate('nom du fichier phtml associé, ajouter .phtml (ex: mapage.phtml)'),
            ),
        ));

        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => $this->translator->translate('Valider'),
                'id' => 'submitbutton',
            ),
        ));
    }

}
