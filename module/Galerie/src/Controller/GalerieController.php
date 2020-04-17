<?php

namespace Galerie\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Contenu\Model\Contenu;
use Galerie\Form\GalerieForm;
use Galerie\Form\GalerieInputFilter;
use Galerie\Model\GalerieDao;
use Contenu\Model\ContenuType;
use Sousrubrique\Model\Sousrubriquedao;
use Rubrique\Model\RubriqueDao;
use Fichiers\Model\Fichiersdao;
use ExtLib\Utils;
use Application\Factory\CacheKeys;
use Application\Factory\CacheDataListener;
use Zend\Mvc\I18n\Translator;

/**
 * Class GalerieController
 * @package Galerie\Controller
 */
class GalerieController extends AbstractActionController
{
    private $cache;
    private $translator;

    /**
     * GalerieController constructor.
     * @param CacheDataListener $cacheDataListener
     * @param Translator $translator
     */
    public function __construct(CacheDataListener $cacheDataListener, Translator $translator)
    {
        $this->cache = $cacheDataListener;
        $this->translator = $translator;
    }

    /**
     * @return ViewModel
     */
    public function indexAction()
    {

        $galerieDao = new GalerieDao();

        return new ViewModel(array(

            'contenus' => $galerieDao->getAllGaleries("object")
        ));
    }

    /**
     * @return array|\Zend\Http\Response
     */
    public function addAction()
    {

        $form = new GalerieForm();
        $galerieDao = new GalerieDao();
        $rubriqueDao = new RubriqueDao();
        $sousrubriqueDao = new Sousrubriquedao();
        $fichiersdao = new Fichiersdao();

        $allFichiers = array();

        // $this->translator=$this->getServiceLocator()->get('translator');
        $form->get('submitbutton')->setAttribute('value', $this->translator->translate('Ajouter'));

        //get cache
        $result = $this->cache->getCacheDataItem(CacheKeys::$CacheKeyFichiersAll);

        //if there's no cache for files
        if (!$result) {
            $allFichiers = $fichiersdao->getAllFichiers("object");
            $this->cache->setCacheDataItem(CacheKeys::$CacheKeyFichiersAll, array('fichiers' => $allFichiers));
        } else {
            $allFichiers = $result['fichiers'];
        }

        $request = $this->getRequest();

        if ($request->isPost()) {
            //trigger data controls
            $form->setInputFilter(new GalerieInputFilter());
            $form->setData($request->getPost());
            //$form->setUseInputFilterDefaults(false);
            //var_dump($_POST);
            //exit;

            if ($form->isValid()) {
                /* Save contenu from filled form -> must add image path */
                $contenu = new Contenu();
                $filterData = new Utils();

                $contenu->setSousRubrique($sousrubriqueDao->getSousrubrique($filterData->stripTags_replaceHtmlChar_trim($request->getPost('sousrubriquesList'), true, true, true)));
                $contenu->setId($filterData->stripTags_replaceHtmlChar_trim($request->getPost('id'), true, false, true));
                $contenu->setTitre($filterData->stripTags_replaceHtmlChar_trim($request->getPost('titre'), false, false, true));
                $contenu->setRang($filterData->stripTags_replaceHtmlChar_trim($request->getPost('position'), true, false, true));
                $contenu->setSousTitre($filterData->stripTags_replaceHtmlChar_trim($request->getPost('soustitre'), false, false, true));
                $contenu->setImage($filterData->stripTags_replaceHtmlChar_trim($request->getPost('imagepath'), true, false, true));
                $contenu->setImage2($filterData->stripTags_replaceHtmlChar_trim($request->getPost('imagepath2'), true, false, true));
                $contenu->setContenuHtml($request->getPost('contenu'));
                $contenu->setType(ContenuType::$galleryItem);

                $galerieDao->saveGalerieContenu($contenu);

                //flush cache
                $this->cache->getCacheService()->flush();

                return $this->redirect()->toRoute('Galerie');
            } else {

                //print_r($form->getMessages()); //error messages
                //exit;

                return array(
                    'form' => $form,
                    'fichiers' => $allFichiers,
                    'error' => $form->getMessages());
            }

        }

        return array(
            'form' => $form,
            'fichiers' => $allFichiers,
            'error' => "no error");
    }

    /**
     * @return array|\Zend\Http\Response
     */
    public function editAction()
    {

        $form = new GalerieForm();

        $galerieDao = new GalerieDao();
        $rubriqueDao = new RubriqueDao();
        $sousrubriqueDao = new Sousrubriquedao();
        $fichiersdao = new Fichiersdao();

        $allFichiers = array();

        //get cache
        // $cache = $this->getServiceLocator()->get('CacheDataListener');
        $result = $this->cache->getCacheDataItem(CacheKeys::$CacheKeyFichiersAll);

        //if there's no cache for files
        if (!$result) {
            $allFichiers = $fichiersdao->getAllFichiers("object");
            $this->cache->setCacheDataItem(CacheKeys::$CacheKeyFichiersAll, array('fichiers' => $allFichiers));
        } else {
            $allFichiers = $result['fichiers'];
        }


        $id = (int)$this->params()->fromRoute('id', 0);
        //print_r($id);
        if (!$id) {
            return $this->redirect()->toRoute('Galerie', array(
                'action' => 'add'
            ));
        }

        $contenu = $galerieDao->getGalerieContenu($id);

        $contenuId = $contenu->getId();

        if (!empty($id)) {
            if (empty($contenuId)) {
                //return $this->getResponse()->setStatusCode(404);
                return $this->notFoundAction();
            }
        }

        // $rubrique = $rubriqueDao->getAllRubriques("array");
        $form = new GalerieForm();

        $form->get('id')->setAttribute('value', $contenu->getId());
        $form->get('titre')->setAttribute('value', $contenu->getTitre());
        $form->get('soustitre')->setAttribute('value', $contenu->getSousTitre());
        $form->get('position')->setAttribute('value', $contenu->getRang());
        $form->get('imagepath')->setAttribute('value', $contenu->getImage());
        $form->get('imagepath2')->setAttribute('value', $contenu->getImage2());
        $form->get('contenu')->setAttribute('value', $contenu->getContenuHtml());
        //$form->get('rubriques_id')->setAttribute('value', $contenu->getSousRubrique()->getRubrique()->getId());
        //$form->get('sousrubriques_id')->setAttribute('value', $contenu->getSousRubrique()->getId());
        // $this->translator=$this->getServiceLocator()->get('translator');
        $form->get('submitbutton')->setAttribute('value', $this->translator->translate('Ajouter'));

        $request = $this->getRequest();

        if ($request->isPost()) {

            $contenu = new Contenu();

            //trigger data controls
            $form->setInputFilter(new GalerieInputFilter());
            $form->setData($request->getPost());
            //$form->setUseInputFilterDefaults(false);
            if ($form->isValid()) {

                $contenu = new Contenu();
                $filterData = new Utils();

                $contenu->setSousRubrique($sousrubriqueDao->getSousrubrique($filterData->stripTags_replaceHtmlChar_trim($request->getPost('sousrubriquesList'), true, true, true)));
                $contenu->setId($filterData->stripTags_replaceHtmlChar_trim($request->getPost('id'), true, false, true));
                $contenu->setTitre($filterData->stripTags_replaceHtmlChar_trim($request->getPost('titre'), false, false, true));
                $contenu->setRang($filterData->stripTags_replaceHtmlChar_trim($request->getPost('position'), true, false, true));
                $contenu->setSousTitre($filterData->stripTags_replaceHtmlChar_trim($request->getPost('soustitre'), false, false, true));
                $contenu->setImage($filterData->stripTags_replaceHtmlChar_trim($request->getPost('imagepath'), true, false, true));
                $contenu->setImage2($filterData->stripTags_replaceHtmlChar_trim($request->getPost('imagepath2'), true, false, true));
                $contenu->setContenuHtml($request->getPost('contenu'));
                $contenu->setType(ContenuType::$galleryItem);

                $galerieDao->saveGalerieContenu($contenu);

                //flush cache
                $this->cache->getCacheService()->flush();

                return $this->redirect()->toRoute('Galerie');
            } else {
                return array(
                    'id' => $id,
                    'form' => $form,
                    'rubrique_id' => $contenu->getSousRubrique()->getRubrique()->getId(),
                    'sousrubrique_id' => $contenu->getSousRubrique()->getId(),
                    'fichiers' => $allFichiers,
                    'error' => $form->getMessages()
                );
            }
        }

        return array(
            'id' => $id,
            'form' => $form,
            'rubrique_id' => $contenu->getSousRubrique()->getRubrique()->getId(),
            'sousrubrique_id' => $contenu->getSousRubrique()->getId(),
            'fichiers' => $allFichiers,
            'error' => "no error"
        );
    }

    /**
     * @return array|\Zend\Http\Response
     */
    public function deleteAction()
    {

        $galerieDao = new GalerieDao();
        // $this->translator=$this->getServiceLocator()->get('translator');

        $id = (int)$this->params()->fromRoute('id', 0);

        if (!$id) {
            return $this->redirect()->toRoute('Galerie');
        }

        $request = $this->getRequest();

        if ($request->isPost()) {

            $del = $request->getPost('del', $this->translator->translate('Non'));

            if ($del == $this->translator->translate('Oui')) {
                $id = (int)$request->getPost('id');

                //flush cache
                $this->cache->getCacheService()->flush();

                $galerieDao->deleteGalerieContenu($id);
            }

            // Redirect to list of contenus
            return $this->redirect()->toRoute('Galerie');
        }

        $contenu = $galerieDao->getGalerieContenu($id);

        return array(
            'id' => $id,
            'contenu' => $contenu
        );
    }

    /**
     * @return JsonModel
     */
    public function sousrubriqueajaxAction()
    {

        $request = $this->getRequest();

        if ($request->isPost()) {
            //if ($request->isGet()){
            $rubid = $request->getPost('rubid');

            $sousrubriqueDao = new Sousrubriquedao();

            $result = $sousrubriqueDao->getSousrubriquesByRubrique($rubid, "array");

            return new JsonModel(array(
                'sousrubriquesList' => $result
            ));
        }
    }

}
