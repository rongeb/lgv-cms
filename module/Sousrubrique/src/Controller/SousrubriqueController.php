<?php

namespace Sousrubrique\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Sousrubrique\Model\Sousrubrique;
use Sousrubrique\Form\SousrubriqueForm;
use Sousrubrique\Form\SousrubriqueInputFilter as InputFilter;
use Sousrubrique\Model\Sousrubriquedao;
use Rubrique\Model\RubriqueDao;
use Zend\Mvc\I18n\Translator;
use Application\Factory\CacheDataListener;
use ExtLib\Utils;

/**
 * Class SousrubriqueController
 * @package Sousrubrique\Controller
 */
class SousrubriqueController extends AbstractActionController {

    private $cache;
    private $translator;

    /**
     * SousrubriqueController constructor.
     * @param CacheDataListener $cacheDataListener
     * @param Translator $translator
     */
    public function __construct(CacheDataListener $cacheDataListener, Translator $translator){
        $this->cache = $cacheDataListener;
        $this->translator = $translator;
    }

    /**
     * @return ViewModel
     */
    public function indexAction() {

        $sousrubriqueDao = new Sousrubriquedao();

        return new ViewModel(array(
            //'sousrubriques' => $sousrubriqueDao->fetchAll(),
            'sousrubriques' => $sousrubriqueDao->getAllSousrubriques("object"),
        ));
    }

    /**
     * @return array|\Zend\Http\Response
     */
    public function addAction() {

        //$this->cache->getCacheService()->flush();
        
        $form = new SousrubriqueForm();
        $sousrubriqueDao = new Sousrubriquedao();
        $rubriqueDao = new RubriqueDao();
        // $this->translator=$this->getServiceLocator()->get('translator');
        
        $form->get('submit')->setAttribute('value', $this->translator->translate('Ajouter'));
        $request = $this->getRequest();

        if ($request->isPost()) {

            $sousrubrique = new Sousrubrique();

            $form->setInputFilter(new InputFilter());

            $form->setData($request->getPost());

            if ($form->isValid()) {

                $utils = new Utils();
                $sousrubrique = new Sousrubrique();
                $sousrubrique->setRubrique($rubriqueDao->getRubrique($request->getPost('rubriquesList')));
                $sousrubrique->setId($request->getPost('id'));
                $sousrubrique->setRang($utils->stripTags_replaceHtmlChar_trim($request->getPost('rang'), true, true, true));
                $sousrubrique->setLibelle($utils->stripTags_replaceHtmlChar_trim($request->getPost('libelle'), true, true, true));

                $sousrubriqueDao->saveSousrubrique($sousrubrique);

                //flush cache
                $this->cache->getCacheService()->flush();
                
                return $this->redirect()->toRoute('Sousrubrique');
            } else {

                return array(
                    'form' => $form,
                    'error' => $form->getMessages());
            }
        }

        return array('form' => $form,
            'error' => '');
    }

    /**
     * @return array|\Zend\Http\Response
     */
    public function editAction() {

        $form = new SousrubriqueForm();
        $sousrubriqueDao = new Sousrubriquedao();
        $rubriqueDao = new RubriqueDao();
        //$this->translator=$this->getServiceLocator()->get('translator');
        
        $id = (int) $this->params()->fromRoute('id', 0);
        //print_r($id);
        if (!$id) {
            return $this->redirect()->toRoute('Sousrubrique', array(
                        'action' => 'add'
            ));
        }

        $sousrubrique = $sousrubriqueDao->getSousrubrique($id);
        $sousrubriqueId = $sousrubrique->getId();
        
        if(!empty($id)){
            if (empty($sousrubriqueId)) {
                //return $this->getResponse()->setStatusCode(404);
                return $this->notFoundAction();
            }
        }
        
        $rubrique = $rubriqueDao->getAllRubriques("array");
        $form = new SousrubriqueForm();

        $form->get('libelle')->setAttribute('value', $sousrubrique->getLibelle());
        $form->get('id')->setAttribute('value', $sousrubrique->getId());
        $form->get('rang')->setAttribute('value', $sousrubrique->getRang());
        $form->get('rubriques_id')->setAttribute('value', $sousrubrique->getRubrique()->getId());
        $form->get('rubriquesList')->setAttribute('value', $sousrubrique->getRubrique()->getId());
        
        $form->get('submit')->setAttribute('value', $this->translator->translate('Modifier'));
        $request = $this->getRequest();

        if ($request->isPost()) {

            $form->setInputFilter(new InputFilter());

            $form->setData($request->getPost());

            if ($form->isValid()) {
                $utils = new Utils();
               
                $request->getPost()->set('libelle', $utils->stripTags_replaceHtmlChar_trim($request->getPost('libelle'), true, true, true));
                $request->getPost()->set('rang', $utils->stripTags_replaceHtmlChar_trim($request->getPost('rang'), true, true, true));
                
                $sousrubrique->setRubrique($rubriqueDao->getRubrique($request->getPost('rubriquesList')));
                $sousrubrique->setLibelle($request->getPost('libelle'));
                $sousrubrique->setRang($request->getPost('rang'));

                $sousrubriqueDao->saveSousrubrique($sousrubrique);
                
                //flush cache
                $this->cache->getCacheService()->flush();
                
                // Redirect to list of sousrubriques
                return $this->redirect()->toRoute('Sousrubrique');
            }
            else {

                return array(
                    'id' => $id,
                    'form' => $form,
                    'error' => $form->getMessages());
            }
        }

        return array(
            'id' => $id,
            'form' => $form,
            'error' => ''
        );
    }

    /**
     * @return array|\Zend\Http\Response
     */
    public function deleteAction() {

        // $this->translator=$this->getServiceLocator()->get('translator');
        $sousrubriqueDao = new Sousrubriquedao();

        $id = (int) $this->params()->fromRoute('id', 0);

        if (!$id) {
            return $this->redirect()->toRoute('Sousrubrique');
        }

        $request = $this->getRequest();

        if ($request->isPost()) {

            $del = $request->getPost('del', $this->translator->translate('Non'));

            if ($del == $this->translator->translate('Oui')) {
                $id = (int) $request->getPost('id');
                
                //flush cache
                $this->cache->getCacheService()->flush();
                
                $sousrubriqueDao->deleteSousrubrique($id);
            }

            // Redirect to list of sousrubriques
            return $this->redirect()->toRoute('Sousrubrique');
        }

        $sousrubrique = $sousrubriqueDao->getSousrubrique($id);

        return array(
            'id' => $id,
            'sousrubrique' => $sousrubrique
        );
    }

}
