<?php

// module/SousRubrique/src/SousRubrique/Form/SousRubriqueForm.php:

namespace Galerie\Form;

use Zend\Form\Form;
use Zend\Form\Element;
use Rubrique\Model\RubriqueDao;
use Contenu\Form\ContenuForm;

/**
 * Class GalerieForm
 * @package Galerie\Form
 */
class GalerieForm extends ContenuForm {

    /**
     * @return array
     */
    protected function getRubriques() {

        $rubriquesDao = new RubriqueDao();

        $rubriques = $rubriquesDao->getAllRubriques("array");

        $rubriqueArray = array();

        foreach ($rubriques as $value) {

            $rubriqueArray[$value['id']] = $value['libelle'];
        }

        return $rubriqueArray;
    }

    /*
      protected function getSousRubriques($rubid){

      $sousrubriquesDao=  new SousRubriqueDao();

      $sousrubriques = $sousrubriquesDao->getSousrubriquesByRubrique($rubid,"array");

      $sousrubriqueArray = array();

      foreach($sousrubriques as $value){

      $sousrubriqueArray[$value['id']]=$value['libelle'];

      }

      return $sousrubriqueArray;
      }
     */

    /**
     * GalerieForm constructor.
     * @param null $name
     */
    public function __construct($name = null) {
        // we want to ignore the name passed
        parent::__construct('galerieform');
        //$this->setHydrator(new ClassMethods);
        $this->add(array(
            'name' => 'imagepath',
            'attributes' => array(
                'type' => 'text'
            ),
            'options' => array(
                'label' => $this->utils->translate('Image')
            ),
        ));
        
        $this->add(array(
            'name' => 'imagepath2',
            'attributes' => array(
                'type' => 'text'
            ),
            'options' => array(
                'label' => $this->utils->translate('Image 2')
            ),
        ));
    }

}
