<?php

namespace Blogcontent\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Blogcontent\Model\Blogcontent;
use Blogcontent\Model\BlogcontentDao;
use Blogcontent\Form\BlogcontentForm;
use Contenu\Model\ContenuType;
use Blogcontent\Form\BlogcontentInputFilter;
use Sousrubrique\Model\Sousrubriquedao;
use Sousrubrique\Model\Sousrubrique;
use Rubrique\Model\RubriqueDao;
use Fichiers\Model\Fichiersdao;
use ExtLib\Utils;
use Application\Factory\CacheDataListener;
use Zend\Mvc\I18n\Translator;
use Application\Factory\CacheKeys;

/**
 * Class BlogcontentController
 * @package Blogcontent\Controller
 * Controller that manage blog contents
 */
class BlogcontentController extends AbstractActionController {

    private $cache;
    private $translator;

    /**
     * BlogcontentController constructor.
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

        $blogContentDao = new BlogcontentDao();

        return new ViewModel(array(
            'contenus' => $blogContentDao->getAllBlogContent("object")
        ));
    }

    /**
     * @return array|\Zend\Http\Response
     */
    public function addAction() {

        $form = new BlogcontentForm();
        $form->get('submitbutton')->setAttribute('value', $this->translator->translate('Ajouter'));
        $blogContentDao = new BlogcontentDao();
        $rubriqueDao = new RubriqueDao();
        $sousrubriqueDao = new Sousrubriquedao();
        $fichiersdao = new Fichiersdao();

        $allFichiers = array();

        //get cache
        $result = $this->cache->getCacheDataItem(CacheKeys::$CacheKeyFichiersAll);

        //if there's no cache for images so get data from db and set cache
        if (!$result) {
            $allFichiers = $fichiersdao->getAllFichiers("object");
            $this->cache->setCacheDataItem(CacheKeys::$CacheKeyFichiersAll, array('fichiers'=>$allFichiers));
        } else {
            $allFichiers = $result['fichiers'];
        }
        $request = $this->getRequest();

        if ($request->isPost()) {
            //trigger data controls
            //$contenu = new Blogcontent();
            $form->setInputFilter(new BlogContentInputFilter());
            $form->setData($request->getPost());
            //$form->setUseInputFilterDefaults(false);
            //var_dump($_POST);
            //exit;

            if ($form->isValid()) {

                $contenu = new Blogcontent();
                $filterData = new Utils();

                $contenu->setSousRubrique($sousrubriqueDao->getSousrubrique($filterData->stripTags_replaceHtmlChar_trim($request->getPost('sousrubriquesList'), true, true, true)));
                $contenu->setTitre($filterData->stripTags_replaceHtmlChar_trim($request->getPost('titre'), false, false, true));
                $contenu->setRang($filterData->stripTags_replaceHtmlChar_trim($request->getPost('position'), true, false, true));
                $contenu->setSousTitre($filterData->stripTags_replaceHtmlChar_trim($request->getPost('soustitre'), false, true, true));
                $contenu->setImage($filterData->stripTags_replaceHtmlChar_trim($request->getPost('imagepath'), true, false, true));
                $contenu->setImage2($filterData->stripTags_replaceHtmlChar_trim($request->getPost('imagepath2'), true, false, true));
                $contenu->setContenuHtml($request->getPost('contenu'));
                $contenu->setType(ContenuType::$blog);
                $contenu->setAuthor($filterData->stripTags_replaceHtmlChar_trim($request->getPost('author'), true, false, true));
                $contenu->setThemes($filterData->stripTags_replaceHtmlChar_trim($request->getPost('themes'), true, false, true));
                $contenu->setDate($filterData->stripTags_replaceHtmlChar_trim($request->getPost('blogdate'), true, false, true));
                $contenu->setText1($filterData->stripTags_replaceHtmlChar_trim($request->getPost('text1'), true, false, true));
                $contenu->setText2($filterData->stripTags_replaceHtmlChar_trim($request->getPost('text2'), true, false, true));
                $contenu->setText3($filterData->stripTags_replaceHtmlChar_trim($request->getPost('text3'), true, false, true));

                $blogContentDao->saveBlogContent($contenu);

                //flush cash
                $this->cache->getCacheService()->flush();

                return $this->redirect()->toRoute('Blogcontent');
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
    public function editAction() {

        $form = new BlogcontentForm();
        //$this->translator=$this->getServiceLocator()->get('translator');
        $form->get('submitbutton')->setAttribute('value', $this->translator->translate('Modifier'));
        
        $blogContentDao = new BlogcontentDao();
        $rubriqueDao = new RubriqueDao();
        $sousrubriqueDao = new Sousrubriquedao();
        $fichiersdao = new Fichiersdao();

        $allFichiers = array();

        //get cache
        //$cache = $this->getServiceLocator()->get('CacheDataListener');
        $result = $this->cache->getCacheDataItem(CacheKeys::$CacheKeyFichiersAll);

        //if there's no cache for files
        if (!$result) {
            $allFichiers = $fichiersdao->getAllFichiers("object");
            $this->cache->setCacheDataItem(CacheKeys::$CacheKeyFichiersAll, array('fichiers'=>$allFichiers));
        } else {
            $allFichiers = $result['fichiers'];
        }

        $id = (int) $this->params()->fromRoute('id', 0);
        //print_r($id);
        if (!$id) {
            return $this->redirect()->toRoute('Blogcontent', array(
                        'action' => 'add'
            ));
        }

        $contenu = new Blogcontent();
        $contenu = $blogContentDao->getBlogContent($id, "object");

        $contenuId = $contenu->getId();
        if(!empty($id)){
            if (empty($contenuId)) {
                //return $this->getResponse()->setStatusCode(404);
                return $this->notFoundAction();
            }
        }

        $rubrique = $rubriqueDao->getAllRubriques("array");
        //$form = new GalerieForm();

        $form->get('id')->setAttribute('value', $contenu->getId());
        $form->get('titre')->setAttribute('value', $contenu->getTitre());
        $form->get('soustitre')->setAttribute('value', $contenu->getSousTitre());
        $form->get('position')->setAttribute('value', $contenu->getRang());
        $form->get('imagepath')->setAttribute('value', $contenu->getImage());
        $form->get('imagepath2')->setAttribute('value', $contenu->getImage2());
        $form->get('contenu')->setAttribute('value', $contenu->getContenuHtml());
        $form->get('author')->setAttribute('value', $contenu->getAuthor());
        $form->get('themes')->setAttribute('value', $contenu->getThemes());
        $form->get('blogdate')->setAttribute('value', $contenu->getDate());
        $form->get('text1')->setAttribute('value', $contenu->getText1());
        $form->get('text2')->setAttribute('value', $contenu->getText2());
        $form->get('text3')->setAttribute('value', $contenu->getText3());

        //$form->get('rubriques_id')->setAttribute('value', $contenu->getSousRubrique()->getRubrique()->getId());
        //$form->get('sousrubriques_id')->setAttribute('value', $contenu->getSousRubrique()->getId());
        
        $request = $this->getRequest();

        if ($request->isPost()) {

            //$contenu = new Blogcontent();
            //trigger data controls
            $form->setInputFilter(new BlogcontentInputFilter());
            $form->setData($request->getPost());
            //$form->setUseInputFilterDefaults(false);
            if ($form->isValid()) {

                $contenu = new Blogcontent();
                $filterData = new Utils();

                $contenu->setSousRubrique($sousrubriqueDao->getSousrubrique($filterData->stripTags_replaceHtmlChar_trim($request->getPost('sousrubriquesList'), true, true, true)));
                $contenu->setId($filterData->stripTags_replaceHtmlChar_trim($request->getPost('id'), true, false, true));
                $contenu->setTitre($filterData->stripTags_replaceHtmlChar_trim($request->getPost('titre'), false, false, true));
                $contenu->setRang($filterData->stripTags_replaceHtmlChar_trim($request->getPost('position'), true, false, true));
                $contenu->setSousTitre($filterData->stripTags_replaceHtmlChar_trim($request->getPost('soustitre'), false, true, true));
                $contenu->setImage($filterData->stripTags_replaceHtmlChar_trim($request->getPost('imagepath'), true, false, true));
                $contenu->setImage2($filterData->stripTags_replaceHtmlChar_trim($request->getPost('imagepath2'), true, false, true));
                $contenu->setContenuHtml($request->getPost('contenu'));
                $contenu->setType(ContenuType::$blog);
                $contenu->setAuthor($filterData->stripTags_replaceHtmlChar_trim($request->getPost('author'), true, false, true));
                $contenu->setThemes($filterData->stripTags_replaceHtmlChar_trim($request->getPost('themes'), true, false, true));
                $contenu->setDate($filterData->stripTags_replaceHtmlChar_trim($request->getPost('blogdate'), true, false, true));
                $contenu->setText1($filterData->stripTags_replaceHtmlChar_trim($request->getPost('text1'), true, false, true));
                $contenu->setText2($filterData->stripTags_replaceHtmlChar_trim($request->getPost('text2'), true, false, true));
                $contenu->setText3($filterData->stripTags_replaceHtmlChar_trim($request->getPost('text3'), true, false, true));

                $blogContentDao->saveBlogContent($contenu);

                $this->cache->getCacheService()->flush();
                return $this->redirect()->toRoute('Blogcontent');
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

        $blogContentDao = new BlogcontentDao();
        //$this->translator=$this->getServiceLocator()->get('translator');

        $id = (int) $this->params()->fromRoute('id', 0);

        if (!$id) {
            return $this->redirect()->toRoute('Blogcontent');
        }

        $request = $this->getRequest();

        if ($request->isPost()) {

            $del = $request->getPost('del', $this->translator->translate('Non'));

            if ($del == $this->translator->translate('Oui')) {
                $id = (int) $request->getPost('id');

                //flush cash
                $this->cache->getCacheService()->flush();

                $blogContentDao->deleteBlogContent($id);
            }

            // Redirect to list of contenus
            return $this->redirect()->toRoute('Blogcontent');
        }

        $contenu = $blogContentDao->getBlogContent($id, "object");

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

            $sousrubriqueDao = new Sousrubriquedao();

            $result = $sousrubriqueDao->getSousrubriquesByRubrique($rubid, "array");

            return new JsonModel(array(
                'sousrubriquesList' => $result
            ));
        }
    }

}
