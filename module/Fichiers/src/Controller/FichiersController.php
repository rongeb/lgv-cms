<?php

namespace Fichiers\Controller;

use Fichiers\Form\FichiersForm;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Fichiers\Model\Fichiers;
use Fichiers\Model\FilesCategories;
use Fichiers\Form\SiteprivateFileuploadForm;
use Fichiers\Form\Fichiersinputfilter as InputFilter;
use Fichiers\Model\Fichiersdao;
use ExtLib\FileManager;
use ExtLib\Utils;
use Application\Factory\CacheKeys;
use Application\Factory\CacheDataListener;
use Zend\Mvc\I18n\Translator;

/**
 * Class FichiersController
 * @package Fichiers\Controller
 */
class FichiersController extends AbstractActionController
{

    private $cache;
    private $translator;

    /**
     * FichiersController constructor.
     * @param CacheDataListener $cacheDataListener
     * @param Translator $translator
     */
    public function __construct(CacheDataListener $cacheDataListener, Translator $translator)
    {
        $this->cache = $cacheDataListener;
        $this->translator = $translator;
    }

    protected $path = 'public/filesbank/';
    protected $savepath = 'filesbank/';

    /**
     * @return ViewModel
     */
    public function indexAction()
    {
        $fichiersDao = new Fichiersdao();

        // $cache = $this->cache->get('CacheDataListener');

        //get cache
        $result = $this->cache->getCacheDataItem(CacheKeys::$CacheKeyFichiersAll);

        //if there's no cache
        if (!$result) {

            $fichiers = $fichiersDao->getAllFichiers("object");

            $this->cache->setCacheDataItem(CacheKeys::$CacheKeyFichiersAll, array('fichiers' => $fichiers));

            return new ViewModel(array(
                'fichiers' => $fichiers
            ));
        } else {

            return new ViewModel(array(
                'fichiers' => $result['fichiers']
            ));
        }
    }

    /**
     * @return array|ViewModel
     */
    public function addAction()
    {

        $form = new FichiersForm();
        $fichiersDao = new Fichiersdao();
        $savethumbnailpath = 'img';
        //$this->translator=$this->getServiceLocator()->get('translator');

        $form->get('submit')->setValue($this->translator->translate('Ajouter'));
        $request = $this->getRequest();

        if ($request->isPost()) {

            $fichiers = new Fichiers();

            $form->setInputFilter(new InputFilter());

            /** File * */
            $outils = new FileManager();
            //print_r($this->path.$_FILES['newfichier']['name']);
            //exit;
            if ($_FILES['newfichier']['name'] != "") {

                $extension = $outils->extractExtension($_FILES['newfichier']['name']);
                $fichieruploaded = "";

                if (!is_uploaded_file($_FILES['newfichier']['tmp_name'])) {

                    $error = $this->translator->translate("Le fichier est inaccessible");

                    return new ViewModel(array(
                        'form' => $form,
                        'error' => $error
                    ));
                }

                // Tester si le fichier n'est pas trop gros < 10Mo
                if ($_FILES['newfichier']['size'] >= 10483760) {

                    $error = $this->translator->translate("La taille du fichier est supérieur à 10 Mo");
                    //print_r($error);
                    //exit;
                    return new ViewModel(array(
                        'form' => $form,
                        'error' => $error
                    ));
                }

                if (in_array(strtolower($extension), FilesCategories::$listeextension) == false) {

                    $error = $this->translator->translate("Le fichier doit avoir l\'extension") . " 'jpg','jpeg', 'png', 'bmp', 'doc', 'docx', 'rtf', 'txt', 'xls', 'xlsx', 
                    'ppt', 'pptx', 'pdf', 'epub', 'odt', 'ods', 'mp4', 'mkv', 'ogv', 'mp3', 'wav', 'ogg', 'gz', 'zip', 'tar'";
                    //print_r($error);
                    //exit;
                    return new ViewModel(array(
                        'form' => $form,
                        'error' => $error
                    ));
                } else {

                    $utils = new Utils();
                    $resultUpload = array();
                    $fichieruploaded = '';
                    $thumbnailfilename = '';

                    if (in_array(strtolower($extension), FilesCategories::$imgList) == true) {
                        $resultUpload = $outils->uploadfiles($_FILES['newfichier'], $this->path, "", FileManager::$renameExistingFile); //envoi du fichier original
                        $thumbname = "thumb";
                        $thumbname= $outils->formatNameFile($_FILES['newfichier']['name']);
                        //a thumbnail can be made only for a jpeg or a png image
                        if (in_array(strtolower($extension), array('jpg', 'jpeg', 'png')) == true) {
                            $thumbnailfilename = $outils->reduit_fichier($resultUpload["filename"][1], $thumbname, 150, 200, $this->path, $this->path, ""); //Redimensionnement vignette
                        }
                        $savethumbnailpath = $this->savepath;
                    } elseif (in_array(strtolower($extension), FilesCategories::$wordList) == true) {
                        $resultUpload = $outils->uploadfiles($_FILES['newfichier'], $this->path, "", FileManager::$renameExistingFile); //envoi du fichier original
                        $thumbnailfilename = FilesCategories::$wordImg;
                        $savethumbnailpath = 'img/';
                    } elseif (in_array(strtolower($extension), FilesCategories::$documentList) == true) {
                        $resultUpload = $outils->uploadfiles($_FILES['newfichier'], $this->path, "", FileManager::$renameExistingFile); //envoi du fichier original
                        $thumbnailfilename = FilesCategories::$documentImg;
                        $savethumbnailpath = 'img/';
                    } elseif (in_array(strtolower($extension), FilesCategories::$excelList) == true) {
                        $resultUpload = $outils->uploadfiles($_FILES['newfichier'], $this->path, "", FileManager::$renameExistingFile); //envoi du fichier original
                        $thumbnailfilename = FilesCategories::$excelImg;
                        $savethumbnailpath = 'img/';
                    } elseif (in_array(strtolower($extension), FilesCategories::$audioList) == true) {
                        $resultUpload = $outils->uploadfiles($_FILES['newfichier'], $this->path, "", FileManager::$renameExistingFile); //envoi du fichier original
                        $thumbnailfilename = FilesCategories::$audioImg;
                        $savethumbnailpath = 'img/';
                    } elseif (in_array(strtolower($extension), FilesCategories::$videoList) == true) {
                        $resultUpload = $outils->uploadfiles($_FILES['newfichier'], $this->path, "", FileManager::$renameExistingFile); //envoi du fichier original
                        $thumbnailfilename = FilesCategories::$videoImg;
                        $savethumbnailpath = 'img/';
                    } elseif (in_array(strtolower($extension), FilesCategories::$presentationList) == true) {
                        $resultUpload = $outils->uploadfiles($_FILES['newfichier'], $this->path, "", FileManager::$renameExistingFile); //envoi du fichier original
                        $thumbnailfilename = FilesCategories::$presentationImg;
                        $savethumbnailpath = 'img/';
                    } elseif (in_array(strtolower($extension), FilesCategories::$archiveList) == true) {
                        $resultUpload = $outils->uploadfiles($_FILES['newfichier'], $this->path, "", FileManager::$renameExistingFile); //envoi du fichier original
                        $thumbnailfilename = FilesCategories::$archiveImg;
                        $savethumbnailpath = 'img/';
                    }

                    if ($resultUpload["filename"][0] == true) {

                        if ($resultUpload["deleteExisting"][0] == true) {
                            $fichiersDao->deleteFichiersByFilename($resultUpload["deleteExisting"][1]);
                        } elseif ($resultUpload["renameExisting"][0] == true) {
                            $fichier = new Fichiers();
                            $fichier = $fichiersDao->getFichiersByFilename($resultUpload["filename"][1]);
                            $fichier->setNom($resultUpload["renameExisting"][1]);
                            $fichiersDao->saveFichiersFilename($fichier);
                        }

                        $fichieruploaded = $resultUpload["filename"][1];
                        $fichier = new Fichiers();

                        $fichier->setId($request->getPost('id'));
                        $fichier->setType($extension);
                        //$fichier['fichiers_nom'] = $_FILES['newfichier']['name'];
                        $fichier->setNom($fichieruploaded);
                        $fichier->setChemin($this->savepath);
                        $fichier->setLibelle($utils->stripTags_replaceHtmlChar_trim($request->getPost('libelle'), true, true, true));
                        $fichier->setMetaData($utils->stripTags_replaceHtmlChar_trim($request->getPost('metadata'), true, true, true));
                        $fichier->setThumbnail($thumbnailfilename);
                        $fichier->setThumbnailpath($savethumbnailpath);
                        $fichiersDao->saveFichiers($fichier);

                        $this->cache->removeCacheDataItem(CacheKeys::$CacheKeyFichiersAll);

                        // Redirect to list of fichiers
                        return $this->redirect()->toRoute('Fichiers');
                    } else {

                        $error = $this->translator->translate("Une erreur est survenue sur le serveur");
                        return new ViewModel(array(
                            'form' => $form,
                            'error' => $error
                        ));
                    }
                }
            } else {
                $error = $this->translator->translate("Aucun fichier n'est sélectionné");
                //print_r($error);
                //exit;
                return new ViewModel(array(
                    'form' => $form,
                    'error' => $error
                ));
            }
        }
        //print_r("no error");
        //			exit;
        return array(
            'form' => $form,
            'error' => "no error");
    }

    /**
     * @return array|\Zend\Http\Response|ViewModel
     */
    public function editAction()
    {

        $form = new FichiersForm();
        $fichiersDao = new Fichiersdao();

        // $this->translator=$this->getServiceLocator()->get('translator');
        $form->get('submit')->setValue($this->translator->translate('Modifier'));
        $id = (int)$this->params()->fromRoute('id', 0);

        $fichier = $fichiersDao->getFichiers($id);

        $fichierId = $fichier->getId();

        if (!empty($id)) {
            if (empty($fichierId)) {
                //return $this->getResponse()->setStatusCode(404);
                return $this->notFoundAction();
            }
        }

        $form->get('id')->setAttribute('value', $fichier->getId());
        $form->get('libelle')->setAttribute('value', $fichier->getLibelle());
        $form->get('metadata')->setAttribute('value', $fichier->getMetaData());

        $request = $this->getRequest();

        if ($request->isPost()) {

            $utils = new Utils();
            $form->setInputFilter(new InputFilter());

            /* Save contenu from filled form -> must add image path */
            $fichier = new Fichiers();

            $fichier->setId($request->getPost('id'));
            $fichier->setLibelle($utils->stripTags_replaceHtmlChar_trim($request->getPost('libelle'), true, true, true));
            $fichier->setMetaData($utils->stripTags_replaceHtmlChar_trim($request->getPost('metadata'), true, true, true));
            $fichiersDao->saveFichiers($fichier);

            $this->cache->removeCacheDataItem(CacheKeys::$CacheKeyFichiersAll);

            // Redirect to list of fichiers
            return $this->redirect()->toRoute('Fichiers');
        }

        return array(
            'form' => $form,
            'error' => "no error");
    }

    /**
     * @return array|\Zend\Http\Response
     */
    public function deleteAction()
    {

        $fichiersDao = new Fichiersdao();
        //$this->translator=$this->getServiceLocator()->get('translator');
        $id = (int)$this->params()->fromRoute('id', 0);

        if (!$id) {
            return $this->redirect()->toRoute('Fichiers');
        }

        $request = $this->getRequest();

        if ($request->isPost()) {
            $isDeleted = false;
            $fichier = new Fichiers();

            $del = $request->getPost('del', $this->translator->translate('Non'));

            if ($del == $this->translator->translate('Oui')) {
                $id = (int)$request->getPost('id');
                $fichier = $fichiersDao->getFichiers($id);
                $isDeleted = $fichiersDao->deleteFichiers($id);
            }
            if ($isDeleted == true) {

                $this->cache->removeCacheDataItem(CacheKeys::$CacheKeyFichiersAll);

                $outils = new FileManager();
                //fichier, chemin
                $outils->deleteFile($fichier->getNom(), 'public/' . $fichier->getChemin());
                if(in_array(strtolower($fichier->getType()), FilesCategories::$imgList)){
                    $outils->deleteFile($fichier->getThumbnail(), 'public/' . $fichier->getThumbnailpath());
                }
            }

            // Redirect to list of fichiers
            return $this->redirect()->toRoute('Fichiers');
        }

        $fichiers = $fichiersDao->getFichiers($id);

        return array(
            'id' => $id,
            'fichiers' => $fichiers
        );
    }

}
