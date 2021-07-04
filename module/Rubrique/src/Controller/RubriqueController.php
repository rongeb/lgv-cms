<?php

namespace Rubrique\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Laminas\View\Model\JsonModel;
use Rubrique\Model\Rubrique;
use Rubrique\Form\RubriqueForm;
use Rubrique\Form\RubriqueInputFilter as InputFilter;
use Rubrique\Model\RubriqueDao;
use Rubrique\Model\Mapper\RubriqueMapper;
use Rubrique\Model\Meta;
use Rubrique\Form\MetaForm;
use Rubrique\Form\MetaInputFilter;
use Rubrique\Model\MetaDao;
use Application\Factory\CacheDataListener;
use Laminas\Mvc\I18n\Translator;
use ExtLib\Utils;
use ExtLib\FileManager;

/**
 * Class RubriqueController
 * @package Rubrique\Controller
 */
class RubriqueController extends AbstractActionController
{

    private $cache;
    private $translator;
    private $sitepublicViewsPath;
    private $siteprivateViewsPath;

    /**
     * RubriqueController constructor.
     * @param CacheDataListener $cacheDataListener
     * @param Translator $translator
     */
    public function __construct(CacheDataListener $cacheDataListener, Translator $translator)
    {
        $this->cache = $cacheDataListener;
        $this->translator = $translator;
        $this->sitepublicViewsPath = BASE_PATH . '/module/Sitepublic/view/sitepublic/sitepublic/';
        $this->siteprivateViewsPath = BASE_PATH . '/module/Siteprivate/view/siteprivate/Siteprivate/';
    }

    /**
     * @return ViewModel
     */
    public function indexAction()
    {

        $rubriqueDao = new RubriqueDao();

        return new ViewModel(array(
            'rubriques' => $rubriqueDao->getAllRubriques("object")
        ));
    }

    /**
     * @return array|\Laminas\Http\Response
     */
    public function addAction()
    {
        $form = new RubriqueForm();

        $form->get('submit')->setAttribute('value', $this->translator->translate('Ajouter'));

        $rubriqueDao = new RubriqueDao();
        $rubrique = new Rubrique();

        $request = $this->getRequest();

        if ($request->isPost()) {

            $form->setInputFilter(new InputFilter());

            $form->setData($request->getPost());

            if ($form->isValid()) {
                $utils = new Utils();
                $filemanager = new FileManager();
                $rubriqueMapper = new RubriqueMapper();
                //$request->getPost()->set('libelle', $utils->stripTags_replaceHtmlChar_trim($request->getPost('libelle'), true, true, true));
                $rubrique = $rubriqueMapper->exchangeArray($form->getData());
                $rubrique->setLibelle($utils->stripTags_replaceHtmlChar_trim($rubrique->getLibelle(), true, true, true));
                $filename = $filemanager->formatNameFile($rubrique->getFilename());
                $rubrique->setFilename($filename);
                $rubrique->setPublishing(0);
                $idInserted = $rubriqueDao->saveRubrique($rubrique);
                $path = $this->sitepublicViewsPath;

                if ($rubrique->getSpaceId() > 0) {
                    $path = $this->siteprivateViewsPath;
                }

                $filemanager->createFile($path, $filename);

                //flush cache
                $this->cache->getCacheService()->flush();
                // Redirect to list of rubriques
                return $this->redirect()->toRoute('rubrique', array('action' => 'edit', 'id' => $idInserted));
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
     * @return array|\Laminas\Http\Response
     */
    public function editAction()
    {

        $rubriqueDao = new RubriqueDao();
        $metaDao = new MetaDao();
        $emptyError = '';

        $id = (int)$this->params()->fromRoute('id', 0);

        if (!$id) {
            return $this->redirect()->toRoute('rubrique', array(
                'action' => 'add'
            ));
        }

        $rubrique = $rubriqueDao->getRubrique($id);

        $rubriqueId = $rubrique->getId();
        if (!empty($id)) {
            if (empty($rubriqueId)) {
                //return $this->getResponse()->setStatusCode(404);
                return $this->notFoundAction();
            }
        }

        $form = new RubriqueForm();

        $form->get('libelle')->setAttribute('value', $rubrique->getLibelle());
        $form->get('id')->setAttribute('value', $rubrique->getId());
        $form->get('rang')->setAttribute('value', $rubrique->getRang());
        $form->get('scope')->setAttribute('value', $rubrique->getScope());
        $form->get('spaceId')->setAttribute('value', $rubrique->getSpaceId());
        $form->get('filename')->setAttribute('value', $rubrique->getFilename());
        $form->get('contactForm')->setAttribute('value', (int)$rubrique->getHasContactForm());
        $form->get('messageForm')->setAttribute('value', (int)$rubrique->getHasMessageForm());
        $form->get('updateForm')->setAttribute('value', (int)$rubrique->getHasUpdateForm());
        $form->get('fileuploadForm')->setAttribute('value', (int)$rubrique->gethasFileuploadForm());
        $form->get('submit')->setAttribute('value', $this->translator->translate('Modifier'));

        $metaForm = new MetaForm();
        $metaForm->get('rubriqueid')->setAttribute('value', $rubrique->getId());
        $metas = $metaDao->getAllMetasByRubrique($id, 'object');

        $request = $this->getRequest();

        if ($request->isPost()) {

            $form->setInputFilter(new InputFilter());

            $form->setData($request->getPost());

            if ($form->isValid()) {

                $utils = new Utils();
                $fileManager = new FileManager();
                $rubriqueMapper = new RubriqueMapper();
                $request->getPost()->set('libelle', $utils->stripTags_replaceHtmlChar_trim($request->getPost('libelle'), true, true, true));
                $rubriqueOld = $rubriqueDao->getRubrique($form->get('id')->getValue());
                $rubrique = $rubriqueMapper->exchangeArray($form->getData());
                $filename = $fileManager->formatNameFile($rubrique->getFilename());
                $rubrique->setFilename($filename);
                $rubrique->setPublishing($rubriqueOld->getPublishing());

                if (strcmp($rubrique->getScope(), "public") == 0) {
                    $rubrique->setSpaceId(-1);
                }

                $path = $this->sitepublicViewsPath;

                if ($rubrique->getSpaceId() > 0) {
                    $path = $this->siteprivateViewsPath;
                }

                if (strcmp($rubriqueOld->getFilename(), $rubrique->getFilename()) != 0) {
                    $fileManager->renameExistingFile($path, $rubriqueOld->getFilename(), $rubrique->getFilename());
                }

                $rubriqueDao->saveRubrique($rubrique);

                //flush cache
                $this->cache->getCacheService()->flush();

                // Redirect to list of rubriques
                return $this->redirect()->toRoute('rubrique');
            } else {

                return array(
                    'id' => $id,
                    'form' => $form,
                    'metaform' => $metaForm,
                    'metas' => $metas,
                    'error' => $form->getMessages());
            }
        }

        return array(
            'id' => $id,
            'form' => $form,
            'metaform' => $metaForm,
            'metas' => $metas,
            'error' => $emptyError
        );
    }

    /**
     * @return array|\Laminas\Http\Response
     */
    public function deleteAction()
    {

        $rubriqueDao = new RubriqueDao();
        $fileManager = new FileManager();

        $id = (int)$this->params()->fromRoute('id', 0);

        if (!$id) {
            return $this->redirect()->toRoute('rubrique');
        }

        $rubrique = $rubriqueDao->getRubrique($id);

        $request = $this->getRequest();

        if ($request->isPost()) {

            $del = $request->getPost('del', $this->translator->translate('Non'));

            if ($del == $this->translator->translate('Oui')) {
                $id = (int)$request->getPost('id');

                $rubriqueDao->deleteRubrique($id);
                $path = $this->sitepublicViewsPath;
                if ($rubrique->getSpaceId() > 0) {
                    $path = $this->siteprivateViewsPath;
                }

                $fileManager->deletefile($rubrique->getFileName(), $path);
                //flush cache
                $this->cache->getCacheService()->flush();
            }

            // Redirect to list of rubriques
            return $this->redirect()->toRoute('rubrique');
        }

        return array(
            'id' => $id,
            'rubrique' => $rubrique
        );
    }

    /**
     * @return array|JsonModel
     */
    function addmetaajaxAction()
    {

        $form = new MetaForm();
        $metaDao = new MetaDao();
        $meta = new Meta();
        // $this->translator = $this->getServiceLocator()->get('translator');
        //$form->bind($meta);
        $request = $this->getRequest();

        if ($request->isPost()) {

            $form->setInputFilter(new MetaInputFilter());

            $form->setData($request->getPost());

            if ($form->isValid()) {
                $utils = new Utils();
                $request->getPost()->set('metakey', $utils->stripTags_replaceHtmlChar_trim($request->getPost('metakey'), true, true, true));
                $request->getPost()->set('metavalue', $utils->stripTags_replaceHtmlChar_trim($request->getPost('metavalue'), true, true, true));
                $meta->setMetakey($request->getPost('metakey'));
                $meta->setMetavalue($request->getPost('metavalue'));
                $meta->setRubriqueid($request->getPost('rubriqueid'));
                //get number of row inserted
                $row = $metaDao->saveMeta($meta);

                $result = array();

                if ($row == 0) {
                    $result['error'] = $this->translator->translate("Un problème est survenu, veuillez recommencer");
                } else if ($row > 0) {
                    $result['result'] = "OK";
                    $result['metaId'] = $row;
                }

                return new JsonModel(
                    $result
                );
            } else {
                return new JsonModel(array(
                    'error' => $form->getMessages()
                ));
            }
        }

        return array('form' => $form,
            'error' => '');
    }

    function updatemetaajaxAction()
    {

        $id = (int)$this->params()->fromRoute('id', 0);
        $meta = new Meta();
        // $this->translator = $this->getServiceLocator()->get('translator');
        $metaDao = new MetaDao();
        $request = $this->getRequest();

        if ($request->isPost()) {

            $utils = new Utils();
            //$meta->setMetakey($request->getPost()->set('metakey', $utils->stripTags_replaceHtmlChar_trim($request->getPost('metakey'), true, true, true)));
            //$meta->setMetavalue($request->getPost()->set('metavalue', $utils->stripTags_replaceHtmlChar_trim($request->getPost('metavalue'), true, true, true)));
            $meta->setMetakey($utils->stripTags_replaceHtmlChar_trim($request->getPost('metakey'), true, true, true));
            $meta->setMetavalue($utils->stripTags_replaceHtmlChar_trim($request->getPost('metavalue'), true, true, true));
            $meta->setMetaid($id);
            $meta->setRubriqueid((int)$request->getPost('rubriqueid'));
            //get number of row inserted
            $row = $metaDao->saveMeta($meta);
            $result = array();

            //if ($row == 0 || $row > 1) {
            if ($row > 1) {
                $result['error'] = $this->translator->translate("Un problème est survenu, veuillez recommencer");
            } else if ($row == 1) {
                $result['result'] = "OK";
            }

            return new JsonModel(
                $result
            );
        }
    }

    function deletemetaajaxAction()
    {

        $metaid = (int)$this->params()->fromRoute('id', 0);
        // $this->translator = $this->getServiceLocator()->get('translator');
        $metaDao = new MetaDao();
        $request = $this->getRequest();

        if ($request->isPost()) {

            //get number of deleted row
            $row = $metaDao->deleteMeta($metaid);

            $result = array();

            if ($row == 0 || $row > 1) {
                $result['error'] = $this->translator->translate("Un problème est survenu, veuillez recommencer");
            } else if ($row == 1) {
                $result['result'] = "OK";
            }

            return new JsonModel(
                $result
            );
        }
    }

}
