<?php

namespace Pagews\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\JsonModel;
use Rubrique\Model\RubriqueDao;
use Sousrubrique\Model\Sousrubriquedao;
use Pagearrangement\Model\PagearrangementDao;

/**
 * Class PagewsController
 * @package Pagews\Controller
 */
class PagewsController extends AbstractActionController
{

    /**
     * @return JsonModel
     */
    public function getallpagesAction()
    {
        $rubriqueDao = new RubriqueDao();
        $allPagesBySpace = $rubriqueDao->getAllRubriques("array");

        return new JsonModel(array(
            'data' => $allPagesBySpace
        ));
    }

    /**
     * @return JsonModel
     */
    public function getallpagesbyspaceidAction()
    {
        $spaceId = $this->params()->fromRoute('id');
        $rubriqueDao = new RubriqueDao();
        $allPagesBySpace = $rubriqueDao->getAllRubriquesBySpaceId($spaceId, "array");

        return new JsonModel(array(
            'data' => $allPagesBySpace
        ));
    }

    /*
        public function getallsectionsbypageidAction() {
            $pageId = $this->params()->fromRoute('id');
            $sousrubriqueDao = new Sousrubriquedao();
            $sousrubriques = $sousrubriqueDao->getSousrubriquesByRubrique($pageId, "array");
            return new JsonModel(array(
                'data' => $sousrubriques
            ));
        }
    */
    /**
     * @return JsonModel
     */
    public function getpagearrangementbypagenameAction()
    {
        $filename = $this->params()->fromRoute('id');
        // var_dump($filename);
        $rubriqueDao = new RubriqueDao();
        $rubrique = $rubriqueDao->getRubriqueByFilename($filename, "array");
        // var_dump($rubrique);
        $rubriqueId = (int)$rubrique['id'];
        // var_dump($rubriqueId);
        // exit;
        $pageArrangementDao = new PagearrangementDao();
        $pageArrangement = $pageArrangementDao->getPage($rubriqueId, "asc", "array");

        return new JsonModel(array(
            'data' => $pageArrangement
        ));
    }

    /**
     * @return JsonModel
     */
    public function getpagearrangementbypageidAction()
    {
        $id = (int)$this->params()->fromRoute('id');
        $pageArrangementDao = new PagearrangementDao();
        $pageArrangement = $pageArrangementDao->getPage($id, "asc", "array");

        return new JsonModel(array(
            'data' => $pageArrangement
        ));
    }

}
