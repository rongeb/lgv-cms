<?php

namespace Mobilews\Controller;

use Fichiers\Model\Fichiers;
use Fichiers\Model\Fichiersdao;
use Uploadmgmt\Controller\UploadmgmtController;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Rubrique\Model\RubriqueDao;
use Uploadmgmt\Model\Uploadmgmtdao;
use Siteprivate\Model\SiteprivateDao;
use Uploadmgmt\Model\Fileupload;
use ExtLib\Utils;
use ExtLib\MCrypt;
use Privatespacelogin\Model\PrivatespaceloginDao;
use ExtLib\FileManager;
use Zend\Mvc\I18n\Translator;
use Application\Factory\CacheDataListener;
use Fichiers\Model\FilesCategories;

class MobilewsController extends AbstractActionController
{

    private $cache;
    private $translator;
    protected $path;
    protected $paththumbnails;
    protected $savepath;

    public function __construct(CacheDataListener $cacheDataListener, Translator $translator)
    {
        $this->path = 'public/'.UploadmgmtController::$path;
        $this->paththumbnails = 'public/'.UploadmgmtController::$paththumbnails;
        $this->cache = $cacheDataListener;
        $this->translator = $translator;
    }

    /**
     * @return JsonModel
     *
     * input in json format :
     * username
     * password
     * token (the token is created when you create a private page)
     */
    /*public function authAction()
    {

        $request = $this->getRequest();

        if ($request->isPost()) {

            $siteprivateDao = new SiteprivateDao();
            $rubriqueDao = new RubriqueDao();

            $mcrypt = new MCrypt();
            $privatespaceloginDao = new PrivatespaceloginDao();

            //token has to be provided
            $mySpaceToken = $request->getPost('token');
            $utils = new Utils();
            $decypted = json_decode($mcrypt->decrypt($mySpaceToken));

            $page = $rubriqueDao->getRubriqueBySpaceToken($mySpaceToken, "object");
            $email = $utils->stripTags_replaceHtmlChar_trim($request->getPost('username'), true, true, false);
            $pwd = $utils->stripTags_replaceHtmlChar_trim($request->getPost('password'), true, true, false);

            $rowNb = $siteprivateDao->countLoginforAuthentication($decypted->spaceId, $email, $pwd);

            if ($rowNb == 0) {
                $error = $this->translator->translate('Veuillez recommencer le nom d\'utilisateur et/ou le mot de passe sont incorrects');
                $this->response->setStatusCode(401);
                return new JsonModel(array(
                    'error' => $error
                ));

            } elseif ($rowNb == 1) {

                $login = $privatespaceloginDao->getLoginByEmailAndPassword($email, $pwd);
                //TODO check number of row affected
                $privatespaceloginDao->updateLastConnection($login->getId());
                $pageNameArg = str_replace(".phtml", "", $page->getFilename());
                //var_dump($pageNameArg);
                //var_dump($decypted);
                //exit;
                $sessionData = array();
                $sessionData['loginId'] = $login->getId();
                $sessionData['loginEmail'] = $login->getEmail();
                $sessionData['spaceId'] = $decypted->spaceId;
                $sessionData['spaceName'] = $decypted->spaceName;
                $sessionData['pageName'] = $page->getFilename();
                $sessionData['pageId'] = $page->getId();
                //$sessionData['firstConnection'] = true;

                $loginaccess = new \Zend\Session\Container('myacl');
                $loginaccess->role = MyAclRoles::$GUEST;

                $loginaccess->userdata = $mcrypt->encrypt(
                    json_encode($sessionData));

                return new JsonModel(array(
                    'controller' => 'SitePrivate',
                    'action' => 'displayprivatepage',
                    'page' => $pageNameArg
                ));

            } else {
                $error = $this->translator->translate('Veuillez contacter l\'administrateur du site svp.');
                $this->response->setStatusCode(401);
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
    }*/
}
