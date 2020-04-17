<?php
 namespace Mapcontent\Form;

 use ExtLib\Utils;
 use Zend\Form\Element;
 use Zend\Form\Fieldset;

 /**
  * Class Mapcontentcollectionfieldset
  * @package Mapcontent\Form
  */
 class Mapcontentcollectionfieldset extends Fieldset
 {
     /**
      * Mapcontentcollectionfieldset constructor.
      */
     public function __construct()
     {
         parent::__construct('Mapcontentcollectionfieldset');
         $utils = new Utils();

         $this->add([
             'type' => Element\Collection::class,
             'name' => 'gpsCoordinates',
             'options' => [
                 'label' => $utils->translate('Noter les coordonnées GPS et un descriptif'),
                 'count' => 1,
                 'should_create_template' => true,
                 'allow_add' => true,
                 'target_element' => [
                     'type' => Mapcontentlocationfiedset::class,
                 ],
             ],
         ]);
     }

 }