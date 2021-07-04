<?php

namespace Mapcontent\Form;


use Laminas\Form\Fieldset;
use Laminas\Form\Element;
use ExtLib\Utils;
use Laminas\InputFilter\InputFilterProviderInterface;

/**
 * Class Mapcontentlocationfiedset
 * @package Mapcontent\Form
 */
class Mapcontentlocationfiedset extends Fieldset
{
    /**
     * Mapcontentlocationfiedset constructor.
     * @param null $name
     * @param array $options
     */
    public function __construct($name = null, array $options = [])
    {
        parent::__construct('locationfieldset');
        $utils = new Utils();

        $this->setLabel($utils->translate('Géolocalisation'));
        $this->add([
            'name' => 'gpspointLat',
            'type' => Element\Text::class,
            'options' => [
                'label' => $utils->translate('Latitude')
            ],
            'attributes' => [
                'maxlength' => 10,
                'required' => 'required',
                'pattern' => '^(-)?\d+(\.\d{1,7})?$'
            ]
        ]);

        $this->add([
            'name' => 'gpspointLong',
            'type' => Element\Text::class,
            'options' => [
                'label' => $utils->translate('Longitude')
            ],
            'attributes' => [
                'maxlength' => 11,
                'required' => 'required',
                'pattern' => '^(-)?\d+(\.\d{1,8})?$'

            ]
        ]);

        $this->add([
            'name' => 'gpspInfo',
            'type' => Element\Textarea::class,
            'options' => [
                'label' => $utils->translate('Détails concernant les coordonnées')
            ],
            'attributes' => [
                'class' => 'gpsInfoTextarea'
            ]
        ]);

    }
}