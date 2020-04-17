<?php

namespace Contenu\Controller;

use Contenu\Model\Mapper\ContenuMapper;
use Linktocontenu\Model\LinktocontenuDao;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
//use Zend\Validator\File\Size;
//use Zend\Validator\File\Extension;
use Contenu\Model\Contenu;
use Contenu\Model\ContenuType;
use Contenu\Form\ContenuForm;
use Contenu\Form\ContenuInputFilter;
use Contenu\Model\ContenuDao;
use Sousrubrique\Model\Sousrubriquedao;
use Rubrique\Model\RubriqueDao;
use Fichiers\Model\Fichiersdao;
use ExtLib\Utils;
use Application\Factory\CacheKeys;
use Application\Factory\CacheDataListener;
use Zend\Mvc\I18n\Translator;

/**
 * Class ContenuController
 * @package Contenu\Controller
 */
class ContenuController extends AbstractActionController {

    private $cache;
    private $translator;

    /**
     * ContenuController constructor.
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
    public function indexAction() {

        $contenuDao = new ContenuDao();
        //print_r($contenuDao->getAllContenus("object"));
        return new ViewModel(array(
            'contenus' => $contenuDao->getAllContentsByType(ContenuType::$htmlcontent, "object")
        ));
    }

    /**
     * @return ViewModel
     */
    public function indexalltypesAction() {

        $contenuDao = new ContenuDao();

        return new ViewModel(array(
            'contenus' => $contenuDao->getAllContentsOrderByPage("object")
        ));
    }

    /**
     * @return array|\Zend\Http\Response
     */
    public function addAction() {

        $form = new ContenuForm();
        // $this->translator=$this->getServiceLocator()->get('translator');
        $form->get('submitbutton')->setAttribute('value', $this->translator->translate('Ajouter'));
        $contenuDao = new ContenuDao();
        $rubriqueDao = new RubriqueDao();
        $this->sousrubriqueDao = new Sousrubriquedao();
        $fichiersdao = new Fichiersdao();
        
        $request = $this->getRequest();

        $allFichiers = array();

        //get cache
        //$cache = $this->getServiceLocator()->get('CacheDataListener');
        $result = $this->cache->getCacheDataItem(CacheKeys::$CacheKeyFichiersAll);
        
        //if there's no cache for files
        if(!$result){
            $allFichiers = $fichiersdao->getAllFichiers("object");
            $this->cache->setCacheDataItem(CacheKeys::$CacheKeyFichiersAll, array('fichiers'=>$allFichiers));
        }
        else{
            $allFichiers = $result['fichiers'];
        }
        
        if ($request->isPost()) {
            //trigger data controls
            $contenu = new Contenu();
            $form->setInputFilter(new ContenuInputFilter());
            $form->setData($request->getPost());
            //$form->setUseInputFilterDefaults(false);
            
            if ($form->isValid()) {
                /* Save contenu from filled form -> must add image path */
                $filterData = new Utils();
                
                $contenu->setSousRubrique($this->sousrubriqueDao->getSousrubrique($filterData->stripTags_replaceHtmlChar_trim($request->getPost('sousrubriquesList'), true, false, true)));
                $contenu->setId($filterData->stripTags_replaceHtmlChar_trim($request->getPost('id'), true, false, true));
                $contenu->setTitre($filterData->stripTags_replaceHtmlChar_trim($request->getPost('titre'), false, false, true));
                $contenu->setRang($filterData->stripTags_replaceHtmlChar_trim($request->getPost('position'), true, false, true));
                $contenu->setSousTitre($filterData->stripTags_replaceHtmlChar_trim($request->getPost('soustitre'), false, false, true));
                $contenu->setContenuHtml($request->getPost('contenu'));
                $contenu->setType(ContenuType::$htmlcontent);

                $contenuDao->saveContenu($contenu);
                
                //flush cache
                $this->cache->getCacheService()->flush();
                
                return $this->redirect()->toRoute('Contenu');
            }
            else{
                
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
    public function editAction() {
 
        $form = new ContenuForm();
        
        $contenuDao = new ContenuDao();
        $rubriqueDao = new RubriqueDao();
        $this->sousrubriqueDao = new Sousrubriquedao();
        $fichiersdao = new Fichiersdao();
        
        $allFichiers = array();

        //get cache
        //$cache = $this->getServiceLocator()->get('CacheDataListener');
        $result = $this->cache->getCacheDataItem(CacheKeys::$CacheKeyFichiersAll);
        
        //if there's no cache for files
        if(!$result){
            $allFichiers = $fichiersdao->getAllFichiers("object");
        }
        else{
            $allFichiers = $result['fichiers'];
            $this->cache->setCacheDataItem(CacheKeys::$CacheKeyFichiersAll, array('fichiers'=>$allFichiers));
        }
        
        $id = (int) $this->params()->fromRoute('id', 0);
        //print_r($id);
        if (!$id) {
            return $this->redirect()->toRoute('Contenu', array(
                        'action' => 'add'
            ));
        }

        $contenu = $contenuDao->getContenu($id);
        
        $contenuId = $contenu->getId();
        
        if(!empty($id)){
            if (empty($contenuId)) {
                //return $this->getResponse()->setStatusCode(404);
                return $this->notFoundAction();
            }
        }
        
        $rubrique = $rubriqueDao->getAllRubriques("array");
        $form = new ContenuForm();

        $form->get('id')->setAttribute('value', $contenu->getId());
        $form->get('titre')->setAttribute('value', $contenu->getTitre());
        $form->get('soustitre')->setAttribute('value', $contenu->getSousTitre());
        $form->get('position')->setAttribute('value', $contenu->getRang());
        $form->get('contenu')->setAttribute('value', $contenu->getContenuHtml());
        //$form->get('rubriques_id')->setAttribute('value', $contenu->getSousRubrique()->getRubrique()->getId());
        //$form->get('sousrubriques_id')->setAttribute('value', $contenu->getSousRubrique()->getId());
        //$this->translator=$this->getServiceLocator()->get('translator');
        $form->get('submitbutton')->setAttribute('value', $this->translator->translate('Ajouter'));
        $request = $this->getRequest();

        if ($request->isPost()) {
            
            $contenu = new Contenu();
            
            //trigger data controls
            $form->setInputFilter(new ContenuInputFilter());
            $form->setData($request->getPost());
            $form->setUseInputFilterDefaults(false);
            if ($form->isValid()) {
                
                $filterData = new Utils();
               
                $contenu->setSousRubrique($this->sousrubriqueDao->getSousrubrique($filterData->stripTags_replaceHtmlChar_trim($request->getPost('sousrubriquesList'), true, false, true)));
                $contenu->setId($filterData->stripTags_replaceHtmlChar_trim($request->getPost('id'), true, false, true));
                $contenu->setTitre($filterData->stripTags_replaceHtmlChar_trim($request->getPost('titre'), false, false, true));
                $contenu->setRang($filterData->stripTags_replaceHtmlChar_trim($request->getPost('position'), true, false, true));
                $contenu->setSousTitre($filterData->stripTags_replaceHtmlChar_trim($request->getPost('soustitre'), false, false, true));
                $contenu->setContenuHtml($request->getPost('contenu'));
                
                $contenuDao->saveContenu($contenu);
                
                //flush cache
                $this->cache->getCacheService()->flush();
                
                return $this->redirect()->toRoute('Contenu');
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
    public function deleteAction() {

        $contenuDao = new ContenuDao();
        //$this->translator=$this->getServiceLocator()->get('translator');
        
        $id = (int) $this->params()->fromRoute('id', 0);

        if (!$id) {
            return $this->redirect()->toRoute('Contenu');
        }

        $request = $this->getRequest();

        if ($request->isPost()) {

            $del = $request->getPost('del', $this->translator->translate('Non'));

            if ($del == $this->translator->translate('Oui')) {
                $id = (int) $request->getPost('id');
                
                //flush cash
                $this->cache->getCacheService()->flush();
                
                $contenuDao->deleteContenu($id);
            }

            // Redirect to list of contenus
            return $this->redirect()->toRoute('Contenu');
        }

        $contenu = $contenuDao->getContenu($id);

        return array(
            'id' => $id,
            'contenu' => $contenu
        );
    }

    /**
     * @return JsonModel
     */
    public function sousrubriqueajaxAction() {

        $request = $this->getRequest();

        if ($request->isPost()) {
            
            $rubid = $request->getPost('rubid');
            
            $this->sousrubriqueDao = new Sousrubriquedao();

            $result = $this->sousrubriqueDao->getSousrubriquesByRubrique($rubid, "array");
            
            return new JsonModel(array(
                'sousrubriquesList' => $result
            ));
        }
    }

}
