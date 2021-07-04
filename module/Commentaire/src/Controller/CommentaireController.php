<?php

namespace Commentaire\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Laminas\View\Model\JsonModel;
use Commentaire\Model\Commentaire;
use Commentaire\Form\CommentaireForm;
use Commentaire\Form\CommentaireInputFilter;
use Commentaire\Model\CommentaireDao;
use Contenu\Model\ContenuDao;
use Contenu\Model\Contenu;
use ExtLib\Utils;
use Application\Factory\CacheDataListener;
use Laminas\Mvc\I18n\Translator;

/**
 * Class CommentaireController
 * @package Commentaire\Controller
 */
class CommentaireController extends AbstractActionController {

    private $cache;
    private $translator;

    /**
     * CommentaireController constructor.
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

        $commentaireDao = new CommentaireDao();
        //print_r($commentaireDao->getAllCommentaires("object"));
        return new ViewModel(array(
            'commentaires' => $commentaireDao->getAllCommentaires("object")
        ));
    }

    /**
     * @return array|\Laminas\Http\Response
     */
    public function addAction() {

        $form = new CommentaireForm();
        $commentaireDao = new CommentaireDao();
        //$this->translator=$this->getServiceLocator()->get('translator');
        $form->get('submitbutton')->setAttribute('value', $this->translator->translate('Ajouter'));
        $request = $this->getRequest();

        if ($request->isPost()) {
            //trigger data controls
            $commentaire = new Commentaire();
            $form->setInputFilter(new CommentaireInputFilter());
            $form->setData($request->getPost());
            //$form->setUseInputFilterDefaults(false);
            
            if ($form->isValid()) {
                /* Save commentaire from filled form -> must add image path */
                $commentaire = new Commentaire();
                $filterData = new Utils();
                
                $contenuDao = new ContenuDao();
                
                $commentaire->setCommentaireStatut($filterData->stripTags_replaceHtmlChar_trim($request->getPost('statusList'), true, false, true));
                $commentaire->setContenuId($filterData->stripTags_replaceHtmlChar_trim($request->getPost('contenusList'), true, false, true));
                
                $contenu = $contenuDao->getContenu($commentaire->getContenuId());
                
                $commentaire->setType($contenu->getType());
                
                $commentaire->setDate($filterData->stripTags_replaceHtmlChar_trim($request->getPost('timestamp'), true, false, true));
                $commentaire->setMessage($filterData->stripTags_replaceHtmlChar_trim($request->getPost('msg'), true, false, true));
                $commentaire->setRow1($filterData->stripTags_replaceHtmlChar_trim($request->getPost('row1'), true, false, true));
                $commentaire->setRow2($filterData->stripTags_replaceHtmlChar_trim($request->getPost('row2'), true, false, true));
                $commentaire->setRow3($filterData->stripTags_replaceHtmlChar_trim($request->getPost('row3'), true, false, true));
                $commentaire->setRow4($filterData->stripTags_replaceHtmlChar_trim($request->getPost('row4'), true, false, true));

                $commentaireDao->saveCommentaire($commentaire);
                
                //flush cash
                $this->cache->getCacheService()->flush();
                
                return $this->redirect()->toRoute('Commentaire');
            }
            else{
                //var_dump($form->getMessages());
                //exit;
                return array(
                    'form' => $form,
                    'error' => $form->getMessages());
            }
            
        }
        
        return array(
            'form' => $form,
            'error' => "no error");
    }

    /**
     * @return array|\Laminas\Http\Response
     */
    public function editAction() {

        $form = new CommentaireForm();
        
        $commentaireDao = new CommentaireDao();
        $contenuDao = new ContenuDao();
        
        $contenu = new Contenu();
        //$this->translator=$this->getServiceLocator()->get('translator');
        $form->get('submitbutton')->setAttribute('value', $this->translator->translate('Modifier'));
        $id = (int) $this->params()->fromRoute('id', 0);
        
        /*
        if ($id == 0) {
            return $this->redirect()->toRoute('Commentaire', array(
                        'action' => 'add'
            ));
        }
        */
        $commentaire = new Commentaire();
        $commentaire = $commentaireDao->getCommentaire($id);
        
        if(!empty($id)){
            $commentaireId = $commentaire->getId();

            if (empty($commentaireId)) {
                //return $this->getResponse()->setStatusCode(404);
                return $this->notFoundAction();
            }
        }
        
        $contenu = $contenuDao->getContenu($commentaire->getContenuId());
         
        $form->get('id')->setAttribute('value', $commentaire->getId());
        $form->get('row1')->setAttribute('value', $commentaire->getRow1());
        $form->get('row2')->setAttribute('value', $commentaire->getRow2());
        $form->get('row3')->setAttribute('value', $commentaire->getRow3());
        $form->get('row4')->setAttribute('value', $commentaire->getRow4());
        $form->get('contenusList')->setAttribute('value', $commentaire->getContenuId());
        $form->get('statusList')->setAttribute('value', $commentaire->getCommentaireStatut());
        $form->get('msg')->setAttribute('value', $commentaire->getMessage());
        $form->get('timestamp')->setAttribute('value', $commentaire->getDate());
        
        $request = $this->getRequest();

        if ($request->isPost()) {
            //trigger data controls
            $commentaire = new Commentaire();
            $form->setInputFilter(new CommentaireInputFilter());
            $form->setData($request->getPost());
            
            if ($form->isValid()) {
                
                $filterData = new Utils();
                
                $commentaire->setId($filterData->stripTags_replaceHtmlChar_trim($request->getPost('id'), true, false, true));
                $commentaire->setCommentaireStatut($filterData->stripTags_replaceHtmlChar_trim($request->getPost('statusList'), true, false, true));
                $commentaire->setContenuId($filterData->stripTags_replaceHtmlChar_trim($request->getPost('contenusList'), true, false, true));
                
                $contenu = new Contenu();
                $contenu = $contenuDao->getContenu($commentaire->getContenuId());
                
                $commentaire->setType($contenu->getType());
                $commentaire->setDate($filterData->stripTags_replaceHtmlChar_trim($request->getPost('timestamp'), true, false, true));
                $commentaire->setMessage($filterData->stripTags_replaceHtmlChar_trim($request->getPost('msg'), true, false, true));
                $commentaire->setRow1($filterData->stripTags_replaceHtmlChar_trim($request->getPost('row1'), true, false, true));
                $commentaire->setRow2($filterData->stripTags_replaceHtmlChar_trim($request->getPost('row2'), true, false, true));
                $commentaire->setRow3($filterData->stripTags_replaceHtmlChar_trim($request->getPost('row3'), true, false, true));
                $commentaire->setRow4($filterData->stripTags_replaceHtmlChar_trim($request->getPost('row4'), true, false, true));
                $commentaireDao->saveCommentaire($commentaire);
                
                //flush cash
                $this->cache->getCacheService()->flush();
                
                return $this->redirect()->toRoute('Commentaire');
            } else {
                return array(
                    'id' => $id,
                    'form' => $form,
                    'rubriqueid' => $contenu->getSousRubrique()->getRubrique()->getId(),
                    'contenuid'=> $commentaire->getContenuId(),
                    'type' => $commentaire->getType(),
                    'status' => $commentaire->getCommentaireStatut(),
                    'error' => $form->getMessages()
                );
            }
        }
        
        return array(
            'id' => $id,
            'form' => $form,
            'rubriqueid' => $contenu->getSousRubrique()->getRubrique()->getId(),
            'contenuid'=> $commentaire->getContenuId(),
            'type' =>$commentaire->getType(),
            'status' => $commentaire->getCommentaireStatut(),
            'error' => "no error"
        );
    }

    /**
     * @return array|\Laminas\Http\Response
     */
    public function deleteAction() {

        //$this->translator=$this->getServiceLocator()->get('translator');
        
        $commentaireDao = new CommentaireDao();

        $id = (int) $this->params()->fromRoute('id', 0);

        if (!$id) {
            return $this->redirect()->toRoute('Commentaire');
        }

        $request = $this->getRequest();

        if ($request->isPost()) {

            $del = $request->getPost('del', $this->translator->translate('Non'));

            if ($del == $this->translator->translate('Oui')) {
                $id = (int) $request->getPost('id');
                
                //flush cash
                $this->cache->getCacheService()->flush();
                
                $commentaireDao->deleteCommentaire($id);
            }

            // Redirect to list of commentaires
            return $this->redirect()->toRoute('Commentaire');
        }

        $commentaire = $commentaireDao->getCommentaire($id);

        return array(
            'id' => $id,
            'commentaire' => $commentaire
        );
    }

    /**
     * @return JsonModel
     */
    public function contenuajaxAction() {

        $request = $this->getRequest();

        if ($request->isPost()) {
            
            $rubid = $request->getPost('rubid');
            
            $contenuDao = new ContenuDao();

            $result = $contenuDao->getAllContentsByRubrique($rubid, "array");
            
            return new JsonModel(array(
                'contenusList' => $result
            ));
        }
    }

}
