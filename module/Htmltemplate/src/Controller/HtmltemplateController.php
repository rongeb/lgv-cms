<?php

namespace Htmltemplate\Controller;

use Htmltemplate\Form\HtmltemplateForm;
use Htmltemplate\Form\HtmltemplateInputFilter;
use Htmltemplate\Model\Htmltemplate;
use Htmltemplate\Model\HtmltemplateDao;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Laminas\View\Model\JsonModel;
use Fichiers\Model\Fichiersdao;
use ExtLib\Utils;
use Application\Factory\CacheKeys;
use Application\Factory\CacheDataListener;
use Laminas\Mvc\I18n\Translator;

/**
 * Class HtmltemplateController
 * @package Htmltemplate\Controller
 */
class HtmltemplateController extends AbstractActionController
{

    private $cache;
    private $translator;

    /**
     * HtmltemplateController constructor.
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

        $htmltemplateDao = new HtmltemplateDao();
        return new ViewModel(array(
            'templates' => $htmltemplateDao->getAllHtmltemplate("object")
        ));
    }

    /**
     * @return array|\Laminas\Http\Response
     */
    public function addAction()
    {

        $form = new HtmltemplateForm();
        $form->get('submitbutton')->setAttribute('value', $this->translator->translate('Ajouter'));
        $htmltemplateDao = new HtmltemplateDao();
        $fichiersdao = new Fichiersdao();

        $request = $this->getRequest();

        $allFichiers = array();

        //get cache
        //$cache = $this->getServiceLocator()->get('CacheDataListener');
        $result = $this->cache->getCacheDataItem(CacheKeys::$CacheKeyFichiersAll);

        //if there's no cache for files
        if (!$result) {
            $allFichiers = $fichiersdao->getAllFichiers("object");
            $this->cache->setCacheDataItem(CacheKeys::$CacheKeyFichiersAll, array('fichiers' => $allFichiers));
        } else {
            $allFichiers = $result['fichiers'];
        }

        if ($request->isPost()) {
            //trigger data controls
            $htmltemplate = new Htmltemplate();
            $form->setInputFilter(new HtmltemplateInputFilter());
            $form->setData($request->getPost());
            //$form->setUseInputFilterDefaults(false);

            if ($form->isValid()) {
                /* Save contenu from filled form -> must add image path */
                $filterData = new Utils();

                $htmltemplate->setId($filterData->stripTags_replaceHtmlChar_trim($request->getPost('id'), true, false, true));
                $htmltemplate->setLabel($filterData->stripTags_replaceHtmlChar_trim($request->getPost('label'), false, false, true));
                $htmltemplate->setHtml($request->getPost('template'));

                $htmltemplateDao->saveHtmltemplate($htmltemplate);

                //flush cache
                $this->cache->getCacheService()->flush();

                return $this->redirect()->toRoute('htmltemplate');
            } else {
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
     * @return array|\Laminas\Http\Response
     */
    public function editAction()
    {

        $form = new HtmltemplateForm();

        $htmltemplateDao = new HtmltemplateDao();
        $fichiersdao = new Fichiersdao();

        $allFichiers = array();

        //get cache
        //$cache = $this->getServiceLocator()->get('CacheDataListener');
        $result = $this->cache->getCacheDataItem(CacheKeys::$CacheKeyFichiersAll);

        //if there's no cache for files
        if (!$result) {
            $allFichiers = $fichiersdao->getAllFichiers("object");
        } else {
            $allFichiers = $result['fichiers'];
            $this->cache->setCacheDataItem(CacheKeys::$CacheKeyFichiersAll, array('fichiers' => $allFichiers));
        }

        $id = (int)$this->params()->fromRoute('id', 0);
        //print_r($id);
        if (!$id) {
            return $this->redirect()->toRoute('htmltemplate', array(
                'action' => 'add'
            ));
        }

        $htmltemplate = $htmltemplateDao->getHtmltemplate($id, 'object');

        $htmltemplateId = $htmltemplate->getId();

        if (!empty($id)) {
            if (empty($htmltemplateId)) {
                //return $this->getResponse()->setStatusCode(404);
                return $this->notFoundAction();
            }
        }

        $form = new HtmltemplateForm();

        $form->get('id')->setAttribute('value', $htmltemplate->getId());
        $form->get('label')->setAttribute('value', $htmltemplate->getLabel());
        $form->get('template')->setAttribute('value', $htmltemplate->getHtml());
        $form->get('submitbutton')->setAttribute('value', $this->translator->translate('Ajouter'));
        $request = $this->getRequest();

        if ($request->isPost()) {

            $htmltemplate = new Htmltemplate();

            //trigger data controls
            $form->setInputFilter(new HtmltemplateInputFilter());
            $form->setData($request->getPost());
            $form->setUseInputFilterDefaults(false);
            if ($form->isValid()) {

                $filterData = new Utils();

                $htmltemplate->setId($filterData->stripTags_replaceHtmlChar_trim($request->getPost('id'), true, false, true));
                $htmltemplate->setLabel($filterData->stripTags_replaceHtmlChar_trim($request->getPost('label'), false, false, true));
                $htmltemplate->setHtml($request->getPost('template'));

                $htmltemplateDao->saveHtmltemplate($htmltemplate);

                //flush cache
                $this->cache->getCacheService()->flush();

                return $this->redirect()->toRoute('htmltemplate');
            } else {
                return array(
                    'id' => $id,
                    'form' => $form,
                    'fichiers' => $allFichiers,
                    'error' => $form->getMessages()
                );
            }
        }

        return array(
            'id' => $id,
            'form' => $form,
            'fichiers' => $allFichiers,
            'error' => "no error"
        );
    }

    /**
     * @return array|\Laminas\Http\Response
     */
    public function deleteAction()
    {

        $htmltemplateDao = new HtmltemplateDao();
        //$this->translator=$this->getServiceLocator()->get('translator');

        $id = (int)$this->params()->fromRoute('id', 0);

        if (!$id) {
            return $this->redirect()->toRoute('htmltemplate');
        }

        $request = $this->getRequest();

        if ($request->isPost()) {

            $del = $request->getPost('del', $this->translator->translate('Non'));

            if ($del == $this->translator->translate('Oui')) {
                $id = (int)$request->getPost('id');

                //flush cash
                $this->cache->getCacheService()->flush();

                $htmltemplateDao->deleteHtmltemplate($id);
            }

            // Redirect to list of contenus
            return $this->redirect()->toRoute('htmltemplate');
        }

        $htmltemplate = $htmltemplateDao->getHtmltemplate($id, 'object');

        // print_r($htmltemplate);
        // exit;

        return array(
            'id' => $id,
            'htmltemplate' => $htmltemplate
        );
    }

    public function gethtmltemplateAction()
    {
        $request = $this->getRequest();
        if ($request->isPost()) {
            $id = $request->getPost('id');
            $htmltemplateDao = new HtmltemplateDao();
            $result = $htmltemplateDao->getHtmltemplate($id, 'array');
            //return $this->getResponse()->setContent(json_encode(array('template'=>$result)));
            return new JsonModel(array('template'=>$result));
        }
    }
}
