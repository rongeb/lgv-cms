<?php

namespace Uploadmgmt\Controller;

use Uploadmgmt\Model\FileuploadStatus;
use Uploadmgmt\Model\Uploadmgmtdao;
use Uploadmgmt\Model\Photosmgmt;
use Privatespacelogin\Model\PrivatespaceloginDao;
use Privatespacelogin\Model\Privatespacelogin;
use ExtLib\MCrypt;
use ExtLib\Utils;
use Uploadmgmt\Model\Fileupload;
use ExtLib\FileManager;
use Fichiers\Model\FilesCategories;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use Zend\Mvc\I18n\Translator;
use Application\Factory\CacheDataListener;

/**
 * Class UploadmgmtController
 * @package Uploadmgmt\Controller
 */
class UploadmgmtController extends AbstractActionController
{
    protected $path;
    protected $paththumbnails;
    protected $publicPath;

    protected $translator;
    protected $cache;

    /**
     * UploadmgmtController constructor.
     * @param CacheDataListener $cacheDataListener
     * @param Translator $translator
     */
    public function __construct(CacheDataListener $cacheDataListener, Translator $translator)
    {
        $this->cache = $cacheDataListener;
        $this->translator = $translator;
        $this->publicPath = 'public/';
        $this->path = 'uploadedfilesbank/';
        $this->paththumbnails = 'uploadedfilesbank/thumbnails/';
    }

    /**
     * @return ViewModel
     */
    public function indexAction()
    {

        $photosmgmtdao = new Uploadmgmtdao();
        return new ViewModel(array(
            'photos' => $photosmgmtdao->getPhotoWaitStatus()
        ));
    }

    /**
     * @return ViewModel
     */
    public function validatedfilesAction()
    {
        $photosmgmtdao = new Uploadmgmtdao();
        return new ViewModel(array(
            'photos' => $photosmgmtdao->getPhotoValidateStatus()
        ));
    }

    /**
     * @return JsonModel
     */
    public function rotaterightAction()
    {
        $idPhoto = (int)$this->params()->fromRoute('id', 0);
        $Photosmgmt = new Photosmgmt();
        $Photosmgmt->photoRotate($idPhoto, -90);
        return new JsonModel(array(
            'status' => 'ok'
        ));
    }

    /**
     * @return JsonModel
     */
    public function rotateleftAction()
    {
        $idPhoto = (int)$this->params()->fromRoute('id', 0);
        $Photosmgmt = new Photosmgmt();
        $Photosmgmt->photoRotate($idPhoto, 90);
        return new JsonModel(array(
            'status' => 'ok'
        ));
    }

    /**
     * @return JsonModel
     */
    public function validatefileAction()
    {
        $idFile = (int)$this->params()->fromRoute('id', 0);
        $uploadfilemgmtDao = new Uploadmgmtdao();
        $uploadfilemgmtDao->updateStatus($idFile, FileuploadStatus::$VALIDATED);
        return new JsonModel(array(
            'status' => 'ok',
        ));
    }

    /**
     * @return JsonModel
     */
    public function deletefileAction()
    {
        $idFile = (int)$this->params()->fromRoute('id', 0);
        if (!isset($idFile) || ($idFile < 1)) {
            $this->response->setStatusCode(502);
            return new JsonModel(array(
                'status' => 'ko',
                'error' => $this->translator->translate('numéro de photo invalide ou Statut non autorisé')
            ));
        }
        $photosmgmt = new Photosmgmt();
        $fileuploadmgmtdao = new Uploadmgmtdao();
        $file = $fileuploadmgmtdao->getPhoto($idFile);
        $status = FileuploadStatus::$REFUSED;

        if(strcmp($file['status'], FileuploadStatus::$VALIDATED)===0){
            $status = FileuploadStatus::$OBSOLETE;
        }
        if ($fileuploadmgmtdao->updateStatus($idFile, $status)) {
            if(in_array(strtolower($file['type']), FilesCategories::$imgList)){
                $photosmgmt->deleteFile($this->publicPath . $file['path'] . '/' . $file['name']);
                $photosmgmt->deleteFile($this->publicPath . $file['thumbnailpath'] . '/' . $file['thumbnail']);
                $photosmgmt->deleteOriTypePhoto($this->publicPath . $file['path'], $file['name']);
                $photosmgmt->deleteOriTypePhoto($this->publicPath . $file['thumbnailpath'], $file['thumbnail']);
            }

            else {
                $photosmgmt->deleteFile($this->publicPath . $file['path'] . '/' . $file['name']);
            }
        }
        else {
            $this->response->setStatusCode(502);
            return new JsonModel(array(
                'status' => 'ko',
                'error' => $this->translator->translate('un problème est survenue lors de la mise à jour')
            ));
        }
        return new JsonModel(array(
            'status' => 'ok',
        ));
    }

    /**
     * @return \Zend\Http\Response|JsonModel
     */
    public function updateAction()
    {
        $idFile = (int)$this->params()->fromRoute('id', 0);
        $commenter = $this->params()->fromPost('commenter');
        $status = $this->params()->fromPost('status');
        $photosmgmtdao = new Uploadmgmtdao();
        if ($idFile < 1) {
            $this->response->setStatusCode(500);
            return new JsonModel(array(
                'status' => 'ko',
                'error' => $this->translator->translate('numéro de photo invalide ')
            ));
        }
        $photosmgmtdao->updateComment($idFile, array('commenter' => $commenter));
        $action = 'index';
        if (strcmp($status, FileuploadStatus::$VALIDATED) == 0) {
            $action = 'validatedfiles';
        }
        return $this->redirect()->toRoute(
            'Uploadmgmt', array(
                'action' => $action
            )
        );
    }

    /**
     * @return JsonModel
     */
    public function backtooriginalAction()
    {
        $photosmgmtdao = new Uploadmgmtdao();
        $idFile = (int)$this->params()->fromRoute('id', 0);
        $photo = $photosmgmtdao->getPhoto($idFile);
        $photosmgmt = new Photosmgmt();

        $result = $photosmgmt->photoBackToOriginal($photo);

        if (strcmp($result['status'], 'ko') == 0) {
            $this->response->setStatusCode(502);
        }

        return new JsonModel($result);
    }

    /**
     * @return \Zend\View\Model\JsonModel
     * input in Post :
     * newfile(the file to upload)
     * comment (text)
     * author (text)
     * userid (text)
     * email (text)
     * lat (text)
     * lng (text)
     * status ('waiting' => 'waiting', 'validated' => 'validated', 'refused' => 'refused', 'obsolete' => 'obsolete')
     *
     * by default the file uploaded will be renamed if a file with the same name already exists
     */
    public function uploadfileAction()
    {
        $request = $this->getRequest();
        if ($request->isPost()) {
            $outils = new FileManager();
            $filesDao = new Uploadmgmtdao();
            $savethumbnailpath = 'img';

            if (strcmp($_FILES['newfile']['name'], "") != 0) {
                $extension = $outils->extractExtension($_FILES['newfile']['name']);
                $fichieruploaded = "";
                if (!is_uploaded_file($_FILES['newfile']['tmp_name'])) {

                    $error = $this->translator->translate("Le fichier est inaccessible");
                    $this->response->setStatusCode(500);
                    return new JsonModel(array(
                        'error' => $error
                    ));
                }

                // Test file size
                if ($_FILES['newfile']['size'] >= 10483760) {

                    $error = $this->translator->translate("La taille du fichier est supérieur à 10 Mo");
                    $this->response->setStatusCode(500);
                    return new JsonModel(array(
                        'error' => $error
                    ));
                }

                if (in_array(strtolower($extension), FilesCategories::$listeextension) == false) {
                    $error = $this->translator->translate("Le fichier doit avoir l\'extension") . " 'jpg','jpeg', 'png', 'bmp', 'doc', 'docx', 'rtf', 'txt', 'xls', 'xlsx', 
                    'ppt', 'pptx', 'pdf', 'epub', 'odt', 'ods', 'mp4', 'mkv', 'ogv', 'mp3', 'wav', 'ogg', 'gz', 'zip', 'tar'";
                    $this->response->setStatusCode(500);
                    return new JsonModel(array(
                        'error' => $error
                    ));
                } else {
                    $utils = new Utils();
                    $resultUpload = array();
                    $thumbnailfilename = '';
                    //By default if a file already exists, it will be renamed
                    if (in_array(strtolower($extension), FilesCategories::$imgList) == true) {
                        $resultUpload = $outils->uploadfiles($_FILES['newfile'], $this->publicPath.$this->path, "", FileManager::$renameExistingFile); //envoi du fichier original
                        $thumbname = "thumb";
                        $thumbname .= $outils->formatNameFile($_FILES['newfile']['name']);
                        //a thumbnail is created only if it is a jpeg or a png image
                        if (in_array(strtolower($extension), array('jpg', 'jpeg', 'png')) == true) {
                            $thumbnailfilename = $outils->reduit_fichier($resultUpload["filename"][1], $thumbname, 150, 200, $this->publicPath.$this->path, $this->publicPath.$this->paththumbnails, ""); //create thumbnail
                        }
                        $savethumbnailpath = $this->paththumbnails;
                    } elseif (in_array(strtolower($extension), FilesCategories::$wordList) == true) {
                        $resultUpload = $outils->uploadfiles($_FILES['newfile'], $this->publicPath.$this->path, "", FileManager::$renameExistingFile); //envoi du fichier original
                        $thumbnailfilename = FilesCategories::$wordImg;
                        $savethumbnailpath = 'img/';
                    } elseif (in_array(strtolower($extension), FilesCategories::$documentList) == true) {
                        $resultUpload = $outils->uploadfiles($_FILES['newfile'], $this->publicPath.$this->path, "", FileManager::$renameExistingFile); //envoi du fichier original
                        $thumbnailfilename = FilesCategories::$documentImg;
                        $savethumbnailpath = 'img/';
                    } elseif (in_array(strtolower($extension), FilesCategories::$excelList) == true) {
                        $resultUpload = $outils->uploadfiles($_FILES['newfile'], $this->publicPath.$this->path, "", FileManager::$renameExistingFile); //envoi du fichier original
                        $thumbnailfilename = FilesCategories::$excelImg;
                        $savethumbnailpath = 'img/';
                    } elseif (in_array(strtolower($extension), FilesCategories::$audioList) == true) {
                        $resultUpload = $outils->uploadfiles($_FILES['newfile'], $this->publicPath.$this->path, "", FileManager::$renameExistingFile); //envoi du fichier original
                        $thumbnailfilename = FilesCategories::$audioImg;
                        $savethumbnailpath = 'img/';
                    } elseif (in_array(strtolower($extension), FilesCategories::$videoList) == true) {
                        $resultUpload = $outils->uploadfiles($_FILES['newfile'], $this->publicPath.$this->path, "", FileManager::$renameExistingFile); //envoi du fichier original
                        $thumbnailfilename = FilesCategories::$videoImg;
                        $savethumbnailpath = 'img/';
                    } elseif (in_array(strtolower($extension), FilesCategories::$presentationList) == true) {
                        $resultUpload = $outils->uploadfiles($_FILES['newfile'], $this->publicPath.$this->path, "", FileManager::$renameExistingFile); //envoi du fichier original
                        $thumbnailfilename = FilesCategories::$presentationImg;
                        $savethumbnailpath = 'img/';
                    } elseif (in_array(strtolower($extension), FilesCategories::$archiveList) == true) {
                        $resultUpload = $outils->uploadfiles($_FILES['newfile'], $this->publicPath.$this->path, "", FileManager::$renameExistingFile); //envoi du fichier original
                        $thumbnailfilename = FilesCategories::$archiveImg;
                        $savethumbnailpath = 'img/';
                    }

                    if ($resultUpload["filename"][0]) {

                        if ($resultUpload["renameExisting"][0] == true) {
                            $file = $filesDao->getFileByFilename($resultUpload["filename"][1]);
                            $file->setName($resultUpload["renameExisting"][1]);
                            $filesDao->saveFileupload($file);
                        }
                        $file = new Fileupload();
                        $file->setType($extension);
                        $file->setName($resultUpload["filename"][1]);
                        $file->setPath($this->path);
                        $file->setThumbnail($thumbnailfilename);
                        $file->setThumbnailpath($savethumbnailpath);
                        $file->setComment($utils->stripTags_replaceHtmlChar_trim($request->getPost('comment'), true, true, true));
                        $file->setAuthor($utils->stripTags_replaceHtmlChar_trim($request->getPost('author'), true, true, true));
                        $file->setEmail($utils->stripTags_replaceHtmlChar_trim($request->getPost('email'), true, true, true));
                        $file->setUserid($utils->stripTags_replaceHtmlChar_trim($request->getPost('userid'), true, true, true));
                        $file->setLat($utils->stripTags_replaceHtmlChar_trim($request->getPost('lat'), true, true, true));
                        $file->setLng($utils->stripTags_replaceHtmlChar_trim($request->getPost('lng'), true, true, true));
                        $file->setStatus($utils->stripTags_replaceHtmlChar_trim($request->getPost('status'), true, true, true));
                        $filesDao->saveFileupload($file);

                        // Redirect to list of fichiers
                        return new JsonModel(array(
                            'status' => $this->translator->translate("OK")
                        ));
                    } else {
                        $error = $this->translator->translate("Une erreur est survenue sur le serveur");
                        $this->response->setStatusCode(500);
                        return new JsonModel(array(
                            'error' => $error
                        ));
                    }
                }
            } else {
                $error = $this->translator->translate("Aucun fichier n'est sélectionné");
                //print_r($error);
                //exit;
                $this->response->setStatusCode(500);
                return new JsonModel(array(
                    'error' => $error
                ));
            }
        } else {
            $error = $this->translator->translate('Ce n\'est pas une requête POST');
            $this->response->setStatusCode(500);
            return new JsonModel(array(
                'error' => $error
            ));
        }
    }

}
