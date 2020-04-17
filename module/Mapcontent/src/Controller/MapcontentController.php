<?php

namespace Mapcontent\Controller;

use Mapcontent\Form\MapcontentForm;
use Mapcontent\Form\MapcontentInputFilter;
use Mapcontent\Model\GpsInfo;
use Mapcontent\Model\Mapcontent;
use Mapcontent\Model\MapcontentDao;
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
 * Class MapcontentController
 * @package Mapcontent\Controller
 */
class MapcontentController extends AbstractActionController
{

    private $cache;
    private $translator;

    /**
     * MapcontentController constructor.
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

        $mapcontentDao = new MapcontentDao();
        //print_r($mapcontentDao->getAllContenus("object"));
        return new ViewModel(array(
            'contenus' => $mapcontentDao->getAllContentsByType(ContenuType::$mapContent, "object")
        ));
    }


    /**
     * @return array|\Zend\Http\Response
     */
    public function addAction()
    {
        $form = new MapcontentForm();
        $form->get('submitbutton')->setAttribute('value', $this->translator->translate('Ajouter'));
        $mapContentDao = new MapcontentDao();
        $rubriqueDao = new RubriqueDao();
        $this->sousrubriqueDao = new Sousrubriquedao();
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
            $mapContent = new Mapcontent();
            $form->setInputFilter(new MapcontentInputFilter());
            $form->setData($request->getPost());
            //$form->setUseInputFilterDefaults(false);
            //'<pre>' . print_r($request->getPost()) . '<pre>';

            if ($form->isValid()) {
                /* Save contenu from filled form -> must add image path */
                $filterData = new Utils();

                $mapContent->setSousRubrique($this->sousrubriqueDao->getSousrubrique($filterData->stripTags_replaceHtmlChar_trim($request->getPost('sousrubriquesList'), true, false, true)));
                $mapContent->setId($filterData->stripTags_replaceHtmlChar_trim($request->getPost('id'), true, false, true));
                $mapContent->setTitre($filterData->stripTags_replaceHtmlChar_trim($request->getPost('titre'), false, false, true));
                $mapContent->setRang($filterData->stripTags_replaceHtmlChar_trim($request->getPost('position'), true, false, true));
                $mapContent->setSousTitre($filterData->stripTags_replaceHtmlChar_trim($request->getPost('soustitre'), false, false, true));
                $mapContent->setContenuHtml($request->getPost('contenu'));
                $mapContent->setType(ContenuType::$mapContent);
                $gpsInfosFromReq = $request->getPost('gps');
                //print_r($gpsInfosFromReq);
                $loop = 0;
                $gpsInfoList = array();

                foreach ($gpsInfosFromReq['gpsCoordinates'] as $value) {
                    $gpsInfo = new GpsInfo();
                    $gpsInfo->setLatitude($value['gpspointLat']);
                    $gpsInfo->setLongitude($value['gpspointLong']);
                    $gpsInfo->setDescription($value['gpspInfo']);
                    array_push($gpsInfoList, $gpsInfo);
                    $loop++;
                }
                //print_r($gpsInfoList);
                $mapContent->setGpsInfoList($gpsInfoList);
                //print_r($mapContent->getGpsInfoList());
                //exit;
                $mapContentDao->saveMapcontent($mapContent);

                //flush cache
                $this->cache->getCacheService()->flush();

                return $this->redirect()->toRoute('mapcontent');
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
     * @return array|\Zend\Http\Response
     */
    public function editAction()
    {

        $form = new MapcontentForm();

        $mapcontentDao = new MapcontentDao();
        $rubriqueDao = new RubriqueDao();
        $this->sousrubriqueDao = new Sousrubriquedao();
        $fichiersdao = new Fichiersdao();

        $allFichiers = array();

        //get cache
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
            return $this->redirect()->toRoute('Contenu', array(
                'action' => 'add'
            ));
        }

        $mapcontent = $mapcontentDao->getMapcontent($id);
        $mapcontentId = $mapcontent->getId();

        if (!empty($id)) {
            if (empty($mapcontentId)) {
                return $this->notFoundAction();
            }
        }

        $rubrique = $rubriqueDao->getAllRubriques("array");
        $form = new MapcontentForm();

        $form->get('id')->setAttribute('value', $mapcontent->getId());
        $form->get('titre')->setAttribute('value', $mapcontent->getTitre());
        $form->get('soustitre')->setAttribute('value', $mapcontent->getSousTitre());
        $form->get('position')->setAttribute('value', $mapcontent->getRang());
        $form->get('contenu')->setAttribute('value', $mapcontent->getContenuHtml());
        // $form->get('gps')->setAttribute('value', $contenu->getSousRubrique()->getRubrique()->getId());
        $form->get('submitbutton')->setAttribute('value', $this->translator->translate('Ajouter'));
        $request = $this->getRequest();

        if ($request->isPost()) {

            $mapcontent = new Mapcontent();

            //trigger data controls
            $form->setInputFilter(new ContenuInputFilter());
            $form->setData($request->getPost());
            $form->setUseInputFilterDefaults(false);
            if ($form->isValid()) {

                $filterData = new Utils();

                $mapcontent->setSousRubrique($this->sousrubriqueDao->getSousrubrique($filterData->stripTags_replaceHtmlChar_trim($request->getPost('sousrubriquesList'), true, false, true)));
                $mapcontent->setId($filterData->stripTags_replaceHtmlChar_trim($request->getPost('id'), true, false, true));
                $mapcontent->setTitre($filterData->stripTags_replaceHtmlChar_trim($request->getPost('titre'), false, false, true));
                $mapcontent->setRang($filterData->stripTags_replaceHtmlChar_trim($request->getPost('position'), true, false, true));
                $mapcontent->setSousTitre($filterData->stripTags_replaceHtmlChar_trim($request->getPost('soustitre'), false, false, true));
                $mapcontent->setContenuHtml($request->getPost('contenu'));
                $gpsInfosFromReq = $request->getPost('gps');
                $loop = 0;
                $gpsInfoList = array();
                //print_r($gpsInfosFromReq['gpsCoordinates']);
                foreach ($gpsInfosFromReq['gpsCoordinates'] as $value) {
                    $gpsInfo = new GpsInfo();
                    $gpsInfo->setLatitude($value['gpspointLat']);
                    $gpsInfo->setLongitude($value['gpspointLong']);
                    $gpsInfo->setDescription($value['gpspInfo']);
                    array_push($gpsInfoList, $gpsInfo);
                    $loop++;
                }
                //print_r($gpsInfoList);
                $mapcontent->setGpsInfoList($gpsInfoList);

                $mapcontentDao->saveMapcontent($mapcontent);

                //flush cache
                $this->cache->getCacheService()->flush();

                return $this->redirect()->toRoute('mapcontent');
            } else {
                return array(
                    'id' => $id,
                    'form' => $form,
                    'rubrique_id' => $mapcontent->getSousRubrique()->getRubrique()->getId(),
                    'sousrubrique_id' => $mapcontent->getSousRubrique()->getId(),
                    'gpsInfoList' => $mapcontent->getGpsInfoList(),
                    'fichiers' => $allFichiers,
                    'error' => $form->getMessages()
                );
            }
        }

        return array(
            'id' => $id,
            'form' => $form,
            'rubrique_id' => $mapcontent->getSousRubrique()->getRubrique()->getId(),
            'sousrubrique_id' => $mapcontent->getSousRubrique()->getId(),
            'gpsInfoList' => $mapcontent->getGpsInfoList(),
            'fichiers' => $allFichiers,
            'error' => "no error"
        );
    }

    /**
     * @return array|\Zend\Http\Response
     */
    public function deleteAction()
    {

        $mapcontentDao = new MapcontentDao();
        //$this->translator=$this->getServiceLocator()->get('translator');

        $id = (int)$this->params()->fromRoute('id', 0);

        if (!$id) {
            return $this->redirect()->toRoute('mapcontent');
        }

        $request = $this->getRequest();

        if ($request->isPost()) {

            $del = $request->getPost('del', $this->translator->translate('Non'));

            if ($del == $this->translator->translate('Oui')) {
                $id = (int)$request->getPost('id');

                //flush cash
                $this->cache->getCacheService()->flush();

                $mapcontentDao->deleteContenu($id);
            }

            // Redirect to list of contenus
            return $this->redirect()->toRoute('mapcontent');
        }

        $contenu = $mapcontentDao->getContenu($id);

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

            $rubid = $request->getPost('rubid');

            $this->sousrubriqueDao = new Sousrubriquedao();

            $result = $this->sousrubriqueDao->getSousrubriquesByRubrique($rubid, "array");

            return new JsonModel(array(
                'sousrubriquesList' => $result
            ));
        }
    }

}
