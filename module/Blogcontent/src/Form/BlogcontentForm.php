<?php

// module/SousRubrique/src/SousRubrique/Form/SousRubriqueForm.php:
namespace Blogcontent\Form;

use Laminas\Form\Form;
use Laminas\Form\Element;
use Rubrique\Model\RubriqueDao;
use Galerie\Form\GalerieForm;

/**
 * Class BlogcontentForm
 * @package Blogcontent\Form
 * form that manage blog content
 */
class BlogcontentForm extends GalerieForm {

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
     * BlogcontentForm constructor.
     * @param null $name
     */
    public function __construct($name = null) {
        // we want to ignore the name passed
        parent::__construct('blogcontentform');
        //$this->setHydrator(new ClassMethods);
        $this->add(array(
            'name' => 'themes',
            'attributes' => array(
                'type' => 'text'
            ),
            'options' => array(
                'label' => $this->utils->translate('Themes abordés')
            ),
        ));
        
        $this->add(array(
            'name' => 'author',
            'attributes' => array(
                'type' => 'text'
            ),
            'options' => array(
                'label' => $this->utils->translate('Auteur')
            ),
        ));
        
        $this->add(array(
            'name' => 'blogdate',
            'attributes' => array(
                'type' => 'text'
            ),
            'options' => array(
                'label' => 'Date format yyyy-mm-dd hh:ii:ss'
            )
        ));
        
        $this->add(array(
            'name' => 'text1',
            'attributes' => array(
                'type' => 'text'
            ),
            'options' => array(
                'label' => $this->utils->translate('Autre texte ligne 1')
            ),
        ));
        
        $this->add(array(
            'name' => 'text2',
            'attributes' => array(
                'type' => 'text'
            ),
            'options' => array(
                'label' => $this->utils->translate('Autre texte ligne 2')
            ),
        ));
        
        $this->add(array(
            'name' => 'text3',
            'attributes' => array(
                'type' => 'text'
            ),
            'options' => array(
                'label' => $this->utils->translate('Autre texte ligne 3')
            ),
        ));
    }

}
