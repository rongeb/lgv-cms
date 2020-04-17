<?php

// module/SousRubrique/src/SousRubrique/Form/SousRubriqueForm.php:

namespace Mapcontent\Form;

use Contenu\Form\ContenuForm;
use Zend\Form\Form;
use Zend\Form\Element;
use Rubrique\Model\RubriqueDao;
use ExtLib\Utils;
use Mapcontent\Form\Mapcontentlocationfiedset;

/**
 * Class MapcontentForm
 * @package Mapcontent\Form
 */
class MapcontentForm extends ContenuForm
{
    /**
     * MapcontentForm constructor.
     * @param null $name
     */
    public function __construct($name = null)
    {
        parent::__construct('mapcontentForm');
        $this->add(array(
            'type' => Mapcontentcollectionfieldset::class,
            'name' => 'gps',
            'attributes' => array(
                'class' => 'gpsInfoClass'
            ),
            'options' => array(
                'use_as_base_fieldset' => true,
            ),
        ));

    }

}
