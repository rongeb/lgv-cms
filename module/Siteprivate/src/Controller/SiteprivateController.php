<?php

namespace Siteprivate\Controller;

use Loginmgmt\Model\Login;
use MyAcl\Controller\Plugin\MyAclRoles;
use Siteprivate\Form\IndexLoginForm;
use Siteprivate\Form\IndexLoginInputFilter;
use Siteprivate\Model\SiteprivateDao;
use Contenu\Model\ContenuType;
use Contenu\Model\ContenuDao;
use Rubrique\Model\RubriqueDao;
use Rubrique\Model\Rubrique;
use Rubrique\Model\MetaDao;
use Sousrubrique\Model\Sousrubriquedao;
use Commentaire\Model\Commentaire;
use Commentaire\Model\CommentaireDao;
use Privatespacelogin\Model\PrivatespaceloginDao;
use Privatespacelogin\Model\Privatespacelogin;
use Commentaire\Model\StatusComment;
use Privatespace\Model\PrivatespaceDao;
use Siteprivate\Form\SiteprivateCommentForm;
use Siteprivate\Form\SiteprivateCommentInputFilter;
use Siteprivate\Form\SiteprivateContactForm;
use Siteprivate\Form\SiteprivateContactInputFilter;
use Siteprivate\Form\SiteprivateupdateInfoInputFilter;
use Siteprivate\Form\SiteprivateUpdateInfoForm;
use Siteprivate\Form\SiteprivateFileuploadForm;
use Siteprivate\Form\SiteprivateFileuploadInputFilter;
use Siteprivate\EmailConfig\EmailCommentConfig;
use Siteprivate\EmailConfig\EmailContactConfig;
use Siteprivate\EmailConfig\EmailRegistrationConfig;
use Siteprivate\Form\SiteprivateRegistrationForm;
use Privatespace\Model\Privatespace;
use Pagearrangement\Model\PagearrangementDao;
use Siteprivate\Form\SiteprivateRegistrationInputFilter;
use Siteprivate\Form\SiteprivateForgottenPasswordForm;
use Siteprivate\EmailConfig\EmailForgottenPasswordConfig;
use Siteprivate\Form\SiteprivateForgottenPasswordInputFilter;
use Siteprivate\Form\SiteprivateNewPasswordForm;
use Siteprivate\Form\SiteprivateNewPasswordInputFilter;
use Uploadmgmt\Model\FileuploadStatus;
use Laminas\Mvc\Controller\AbstractActionController;
use Message\Model\MessageDao;
use Message\Model\Message as EmailSent;
use Message\Model\TypeMessage;
use Laminas\Mail\Message;
use Laminas\Mail\Transport\Smtp as SmtpTransport;
use Laminas\Mail\Transport\Sendmail as SendmailTransport;
use Laminas\Mail\Transport\SmtpOptions;
use Laminas\View\Model\ViewModel;
use Laminas\View\Model\JsonModel;
use ExtLib\Utils;
use ExtLib\MCrypt;
use Application\Factory\CacheDataListener;
use Laminas\Mvc\I18n\Translator;

/**
 * Class SiteprivateController
 * @package Siteprivate\Controller
 */
class SiteprivateController extends AbstractActionController
{

    protected $translator;
    protected $cache;

    /**
     * SiteprivateController constructor.
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

        $form = new IndexLoginForm();
        $token = $this->params()->fromQuery('myspace');
        $loginaccess = new \Laminas\Session\Container('myacl');

        $loginaccess->role = 'anonymous';
        $form->get('token')->setAttribute('value', $token);
        return new ViewModel(array(
            'navigation' => null,
            'navigationJSON' => null,
            'form' => $form,
            'spacetoken' => $token,
            'error' => ''
        ));
    }

    /**
     * @return \Laminas\Http\Response
     */
    public function authAction()
    {
        $siteprivateDao = new SiteprivateDao();
        $rubriqueDao = new RubriqueDao();

        $form = new IndexLoginForm();

        $request = $this->getRequest();

        if ($request->isPost()) {
            $mySpaceToken = $request->getPost('token');
            $login = new Privatespacelogin();

            $form->setInputFilter(new IndexLoginInputFilter());

            $form->setData($request->getPost());

            if ($form->isValid()) {

                $privatespaceloginDao = new PrivatespaceloginDao();
                $utils = new Utils();
                $mcrypt = new MCrypt();
                $decypted = json_decode($mcrypt->decrypt($mySpaceToken));
                $page = $rubriqueDao->getRubriqueBySpaceToken($mySpaceToken, "object");
                $email = $utils->stripTags_replaceHtmlChar_trim($request->getPost('username'), true, true, false);
                $pwd = $utils->stripTags_replaceHtmlChar_trim($request->getPost('password'), true, true, false);
                //$decypted[0] = space Id ; $decypted[1] = space name; $decypted[2] = timestamp 
                $rowNb = $siteprivateDao->countLoginforAuthentication($decypted->spaceId, $email, $pwd);

                if ($rowNb == 0) {
                    $loginaccess = new \Laminas\Session\Container('error');
                    $loginaccess->error = $this->translator->translate('Veuillez recommencer le nom d\'utilisateur et/ou le mot de passe sont incorrects');
                    //TO DO return with token
                    return $this->redirect()->toRoute('siteprivate', array('action' => 'index'), array('query' => array('myspace' => $mySpaceToken)));
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

                    $loginaccess = new \Laminas\Session\Container('myacl');
                    $loginaccess->role = MyAclRoles::$GUEST;

                    $loginaccess->userdata = $mcrypt->encrypt(
                        json_encode($sessionData));

                    //redirect to first page of the private space
                    return $this->redirect()->toRoute('siteprivate', array(
                        'controller' => 'SitePrivate',
                        'action' => 'displayprivatepage',
                        'page' => $pageNameArg
                    ));
                } else {
                    $loginaccess = new \Laminas\Session\Container('error');
                    $loginaccess->error = $this->translator->translate('Veuillez contacter l\'administrateur du site svp.');
                    return $this->redirect()->toRoute('siteprivate', array('action' => 'index'), array('query' => array('myspace' => $mySpaceToken)));
                }
            } else {
                //var_dump($form->getMessages());
                //exit;
                //form is not valid because the csrf token is not the same anymore
                $loginaccess = new \Laminas\Session\Container('error');
                $loginaccess->error = $this->translator->translate('Veuillez rafraichir la page et recommencer svp.');
                return $this->redirect()->toRoute('siteprivate', array('action' => 'index'), array('query' => array('myspace' => $mySpaceToken)));
            }
        }
    }

    /**
     * @return null|ViewModel
     */
    public function displayprivatepageAction()
    {
        $pageArrangementDao = new PagearrangementDao();
        $metaDao = new MetaDao();
        $commentaireDao = new CommentaireDao();
        $rubriqueDao = new RubriqueDao();
        $contactForm = null;
        $commentForm = null;
        $fileuploadForm = null;
        $loginaccess = new \Laminas\Session\Container('myacl');
        $page = $this->params()->fromRoute('page');
        $phtmlFile = "";
        $viewModel = null;
        $allPagesBySpace = null;
        $allPagesBySpaceJSON = null;
        // $this->cache = $this->getServiceLocator()->get('CacheDataListener');

        $mcrypt = new MCrypt();
        //loginId=>id login, loginEmail=>email login, spaceId=>id private space, spaceName=> name private space, 
        //pageName=> first file private page, pageId=>page Id
        $sessionData = json_decode($mcrypt->decrypt($loginaccess->userdata));
        $role = $loginaccess->role;
        if (empty($page) || strcasecmp($page, 'index') == 0
            && ((strcasecmp($role, MyAclRoles::$ADMIN) != 0) && (strcasecmp($role, MyAclRoles::$USER) != 0))
        ) {
            $firstRubrique = $rubriqueDao->getFirstRubriqueBySpace($sessionData->spaceId, "object");
            $page = str_replace(".phtml", "", $firstRubrique->getFilename());
        }

        $loginaccess = new \Laminas\Session\Container('myacl');
        //get cache only for an anonymous user or an extranet user
        if ((strcasecmp($loginaccess->role, MyAclRoles::$USER) == 0 || strcasecmp($loginaccess->role, MyAclRoles::$ADMIN) == 0)
        ) {
            //get cache
            $result = $this->cache->getCacheDataItem($this->getEvent()->getRouteMatch());
        }

        if (!$result) {
            $rubrique = $rubriqueDao->getPrivateRubriqueByFilename($page . ".phtml", 'object');
            $idrub = $rubrique->getId();

            //if the page is not authorized to be published but the request comes from an user of the back-office or an adminstrator
            //the page will be displayed
            if (($rubrique->getId() == null || (int)$rubrique->getId() == 0) && (strcasecmp($loginaccess->role, MyAclRoles::$USER) == 0
                    || strcasecmp($loginaccess->role, MyAclRoles::ADMIN) == 0)
            ) {
                $rubrique = $rubriqueDao->getRubriqueByFilename($page . ".phtml", 'object');
            } elseif ($rubrique->getId() == null || (int)$rubrique->getId() == 0) {
                return $this->notFoundAction();
            }

            //It doesn't have the proper behaviour with the admin's user
            // (user provided by default for visualization)
            if ((strcasecmp($role, MyAclRoles::$ADMIN) == 0) || (strcasecmp($role, MyAclRoles::$USER) == 0)) {
                $allPagesBySpace = $rubriqueDao->getAllRubriquesBySpaceId($rubrique->getSpaceId(), "array");
                $allPagesBySpaceJSON = json_encode($allPagesBySpace);
            } else {
                $allPagesBySpace = $rubriqueDao->getAllRubriquesBySpaceId($sessionData->spaceId, "array");
                $allPagesBySpaceJSON = json_encode($allPagesBySpace);
            }

            //get metas attached to the page (rubrique)
            $metas = $metaDao->getAllMetasByRubrique($idrub, "object");

            //get all data to display the page with a pageArrangement object 
            //which have all the objects (page, section(s), content(s)...) sorted
            $pageContents = $pageArrangementDao->getPage($idrub, "asc", "object");
            $pageContentsJSON = $pageArrangementDao->getPage($idrub, "asc", "json");
            //get comments
            $comments = $commentaireDao->getCommentairesByRubrique($idrub, StatusComment::$visible, "object");

            $configuration = $this->getInformationFromPage($pageContents);

            if ($configuration['hasContactForm']) {
                $contactForm = new SiteprivateContactForm();
            }
            if ($configuration['hasMessageForm']) {
                $commentForm = new SiteprivateCommentForm();
                $commentForm->get('contactcontenuid')->setAttribute('value', $configuration['contactcontenuid']);
            }
            if ($configuration['hasFileuploadForm']) {
                $fileuploadForm = $this->setFileuploadForm($sessionData);
            }

            $phtmlFile = $configuration['phtmlFile'];

            $this->layout()->setVariable('navigation', $allPagesBySpace);
            $this->layout()->setVariable('navigationJSON', $allPagesBySpaceJSON);

            //Cache management
            if ((strcasecmp($loginaccess->role, MyAclRoles::$ANONYMOUS) == 0 || strcasecmp($loginaccess->role, MyAclRoles::$GUEST) == 0)
            ) {
                $this->cache->setCacheDataItem($this->getEvent()->getRouteMatch(), array(
                        'navigationJSON' => $allPagesBySpaceJSON,
                        'navigation' => $allPagesBySpace,
                        'metas' => $metas,
                        'pageContents' => $pageContents,
                        'pageContentsJSON' => $pageContentsJSON,
                        'comments' => $comments
                    )
                );
            }

            $viewModel = new ViewModel(array(
                'navigationJSON' => $allPagesBySpaceJSON,
                'navigation' => $allPagesBySpace, //if you need it in the body or if you don't want to use header
                'contactForm' => $contactForm,
                'commentForm' => $commentForm,
                'fileuploadForm' => $fileuploadForm,
                'metas' => $metas,
                'pageContents' => $pageContents,
                'pageContentsJSON' => $pageContentsJSON,
                'comments' => $comments
            ));
        }//if the cache exists 
        else {
            $this->layout()->setVariable('navigation', $result['navigation']);
            $this->layout()->setVariable('navigationJSON', $result['navigationJSON']);

            $configuration = $this->getInformationFromPage($result['pageContents']);

            if ($configuration['hasContactForm']) {
                $contactForm = new SiteprivateContactForm();
            }
            if ($configuration['hasMessageForm']) {
                $commentForm = new SiteprivateCommentForm();
                $commentForm->get('contactcontenuid')->setAttribute('value', $configuration['contactcontenuid']);
            }
            if ($configuration['hasFileuploadForm']) {
                $fileuploadForm = $this->setFileuploadForm($sessionData);
            }
            $phtmlFile = $configuration['phtmlFile'];

            $viewModel = new ViewModel(array(
                'navigationJSON' => $result['navigationJSON'],
                'navigation' => $result['navigation'], //if you need it in the body or if you don't want to use header
                'contactForm' => $contactForm,
                'commentForm' => $commentForm,
                'fileuploadForm' => $fileuploadForm,
                'metas' => $result['metas'],
                'pageContents' => $result['pageContents'],
                'pageContentsJSON' => $result['pageContentsJSON'],
                'comments' => $result['comments']
            ));
        }

        $viewModel->setTemplate('Siteprivate/Siteprivate/' . $phtmlFile);

        return $viewModel;
    }

    /**
     * @param $pageContents
     * @return array
     */
    private function getInformationFromPage($pageContents)
    {
        $configuration = array();
        $configuration['hasMessageForm'] = false;
        $configuration['hasContactForm'] = false;
        $configuration['hasFileuploadForm'] = false;
        //set forms
        foreach ($pageContents as $key => $value) {
            if (stripos($key, "page") > -1) {
                //$counter++;
                $configuration['phtmlFile'] = $value->getFilename();

                if ((bool)$value->getHasMessageForm()) {
                    $configuration['hasMessageForm'] = true;
                }
                if ((bool)$value->getHasContactForm()) {
                    $configuration['hasContactForm'] = true;
                }
                if ((bool)$value->gethasFileuploadForm()) {
                    $configuration['hasFileuploadForm'] = true;
                }
            }// set contenuId for commentForm
            // We consider the first id of a blog content even if we have many contents of this type
            if (stripos($key, "content") > -1 && $configuration['hasMessageForm']) {
                if (strcmp($value->getType(), ContenuType::$blog) == 0) {
                    $configuration['contactcontenuid'] = $value->getId();
                    break;
                }
            }
        }
        //var_dump($configuration);
        //exit;
        return $configuration;
    }

    /**
     * @return json string
     */
    public function logoutAction()
    {
        $loginaccess = new \Laminas\Session\Container('myacl');
        $loginaccess->getManager()->getStorage()->clear('myacl');
        return json_encode(array("response" => "ok"));
        //return $this->redirect()->toRoute('Login');
    }

    /**
     * @return JsonModel
     */
    public function addcommentajaxAction()
    {

        $request = $this->getRequest();

        if ($request->isPost()) {

            $form = new SiteprivateCommentForm();

            //trigger data controls
            $form->setInputFilter(new SiteprivateCommentInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {

                //$message = new Message();
                $utils = new Utils();
                $to = EmailCommentConfig::$emailAdressForContact;
                $name = $utils->stripTags_replaceHtmlChar_trim($request->getPost('contactnom'), true, true, true);
                $company = $utils->stripTags_replaceHtmlChar_trim($request->getPost('contactentreprise'), true, true, true);
                $subject = "Contact site web de la part de " . $utils->stripTags_replaceHtmlChar_trim($request->getPost('contactnom'), true, true, true);
                $from = $utils->stripTags_replaceHtmlChar_trim($request->getPost('contactemail'), true, true, true);

                $contenuid = (int)$utils->stripTags_replaceHtmlChar_trim($request->getPost('contactcontenuid'), true, true, true);

                $txt = wordwrap($utils->stripTags_replaceHtmlChar_trim($request->getPost('contacttext'), true, true, true), 70);

                $message = new Commentaire();

                $message->setRow1($name);
                $message->setRow2($company);
                $message->setRow3($from);
                $message->setMessage($txt);
                $message->setDate(date("Y-m-d H:i:s", time()));
                $message->setType(\Message\Model\TypeMessage::$blog);
                $message->setContenuId($contenuid);
                $message->setCommentaireStatut(0);

                $messageDao = new CommentaireDao();
                $messageDao->saveCommentaire($message);

                //zend message sendmail
                /* Solution 1 only if you have sendMail
                 * Send email through sendmail
                 *
                  $emailMessage = new Message();
                  $emailMessage->addFrom($from, $name)
                  ->addTo($to)
                  ->setSubject($subject)
                  ->setBody($txt);

                  $transport = new SendmailTransport();
                  $transport->send($emailMessage);
                 *
                 */

                //zend message smtp
                /* Solution 2
                 * Send email through smtp client from Zend
                 *
                  $messageToSend = new Message();
                  $messageToSend->addFrom($from, $name)
                  ->addTo($to)
                  ->setSubject($subject);
                  $messageToSend->setBody($txt);

                  $messageToSend->setEncoding("UTF-8");

                  $transport = new SmtpTransport();
                  $options = new SmtpOptions(array(
                  'name' => EmailCommentConfig::$smtpServerNameForContact,
                  'host' => EmailCommentConfig::$smtpHostServerForContact,
                  'port' => EmailCommentConfig::$smtpHostPortForContact,
                  'connection_class' => EmailCommentConfig::$connectionClassForContact,
                  'connection_config' => array(
                  'username' => EmailCommentConfig::$connectionConfigUsernameForContact,
                  'password' => EmailCommentConfig::$connectionConfigPwdForContact,
                  'ssl' => EmailCommentConfig::$connectionConfigSSLForContact
                  ),
                  ));

                  $transport->setOptions($options);
                  $transport->send($messageToSend);
                 *
                 *
                 */
                return new JsonModel(array(
                    'result' => 'ok'
                ));
            } else {
                return new JsonModel(array(
                    'result' => 'failure',
                    'error' => $form->getMessages()
                ));
            }
        }
    }

    /**
     * @return JsonModel
     */
    public function contactajaxAction()
    {

        $request = $this->getRequest();

        if ($request->isPost()) {

            $form = new SiteprivateContactForm();

            //trigger data controls
            $form->setInputFilter(new SiteprivateContactInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {

                //$message = new Message();
                $utils = new Utils();
                $to = EmailContactConfig::$emailAdressForContact;
                $name = $utils->stripTags_replaceHtmlChar_trim($request->getPost('contactnom'), true, true, true);
                $company = $utils->stripTags_replaceHtmlChar_trim($request->getPost('contactentreprise'), true, true, true);
                $subject = "Contact site web de la part de " . $utils->stripTags_replaceHtmlChar_trim($request->getPost('contactnom'), true, true, true);
                $from = $utils->stripTags_replaceHtmlChar_trim($request->getPost('contactemail'), true, true, true);

                $txt = wordwrap($utils->stripTags_replaceHtmlChar_trim($request->getPost('contacttext'), true, true, true), 70);

                $message = new EmailSent();

                $message->setRow1($name);
                $message->setRow2($company);
                $message->setRow3($from);
                $message->setMessage($txt);
                $message->setDate(date("Y-m-d H:i:s", time()));
                $message->setType('contact');

                $messageDao = new MessageDao();

                $messageDao->saveMessage($message);

                /*
                  //zend message sendmail
                  $emailMessage = new Message();
                  $emailMessage->addFrom($from, $name)
                  ->addTo($to)
                  ->setSubject($subject)
                  ->setBody($txt);

                  $transport = new SendmailTransport();
                  $transport->send($message);
                 */
                /*
                  //zend message smtp
                  $messageToSend = new Message();
                  $messageToSend->addFrom($from, $name)
                  ->addTo($to)
                  ->setSubject($subject)
                  ->setBody($txt);

                  $messageToSend->setEncoding("UTF-8");
                 */
                /*
                  $transport = new SmtpTransport();
                  $options = new SmtpOptions(array(
                  'name' => EmailContactConfig::$smtpServerNameForContact,
                  'host' => EmailContactConfig::$smtpHostServerForContact,
                  'port' => EmailContactConfig::$smtpHostPortForContact,
                  'connection_class' => EmailContactConfig::$connectionClassForContact,
                  'connection_config' => array(
                  'username' => EmailContactConfig::$connectionConfigUsernameForContact,
                  'password' => EmailContactConfig::$connectionConfigPwdForContact,
                  'ssl' => EmailContactConfig::$connectionConfigSSLForContact
                  ),
                  ));

                  $transport->setOptions($options);
                  $transport->send($messageToSend);
                 */
                return new JsonModel(array(
                    'result' => 'ok'
                ));
            } else {
                return new JsonModel(array(
                    'result' => 'failure',
                    'error' => $form->getMessages()
                ));
            }
        }
    }

    /**
     * @return array|\Laminas\Http\Response
     */
    public function registrationAction()
    {

        $form = new SiteprivateRegistrationForm();

        // $this->translator = $this->getServiceLocator()->get('translator');
        $form->get('submitbutton')->setAttribute('value', $this->translator->translate('Ajouter'));
        $form->get('validate')->setAttribute('value', 1);
        $form->get('id')->setAttribute('value', 0);

        $request = $this->getRequest();
        if ($request->isPost()) {
            //$form->setInputFilter($space->getInputFilter());
            $filterData = new Utils();
            $form->setInputFilter(new SiteprivateRegistrationInputFilter());
            $form->setData($request->getPost());
            $pwd = $filterData->stripTags_replaceHtmlChar_trim($request->getPost('pwd'), true, true, true);
            $pwdConfirm = $filterData->stripTags_replaceHtmlChar_trim($request->getPost('pwdconfirm'), true, true, true);
            $formIsValid = $form->isValid();
            $pwdComparison = strcmp($pwd, $pwdConfirm);

            if ($form->isValid() && $pwdComparison == 0) {
                $login = new Privatespacelogin();
                $privatespaceloginmgmtDao = new PrivatespaceloginDao();

                $login->setFirstname($filterData->stripTags_replaceHtmlChar_trim($request->getPost('firstname'), true, false, true));
                $login->setLastname($filterData->stripTags_replaceHtmlChar_trim($request->getPost('lastname'), true, false, true));
                $login->setEmail($filterData->stripTags_replaceHtmlChar_trim($request->getPost('email'), true, false, true));
                $login->setPwd($filterData->stripTags_replaceHtmlChar_trim($request->getPost('pwd'), true, false, true));
                $login->setCompany($filterData->stripTags_replaceHtmlChar_trim($request->getPost('company'), true, false, true));
                $login->setStreetnumber($filterData->stripTags_replaceHtmlChar_trim($request->getPost('streetnumber'), true, false, true));
                $login->setStreetline_1($filterData->stripTags_replaceHtmlChar_trim($request->getPost('streetline_1'), true, false, true));
                $login->setStreetline_2($filterData->stripTags_replaceHtmlChar_trim($request->getPost('streetline_2'), true, false, true));
                $login->setStreetline_3($filterData->stripTags_replaceHtmlChar_trim($request->getPost('streetline_3'), true, false, true));
                $login->setZipcode($filterData->stripTags_replaceHtmlChar_trim($request->getPost('zipcode'), true, false, true));
                $login->setCity($filterData->stripTags_replaceHtmlChar_trim($request->getPost('city'), true, false, true));
                $login->setHomephone($filterData->stripTags_replaceHtmlChar_trim($request->getPost('homephone'), true, false, true));
                $login->setMobilephone($filterData->stripTags_replaceHtmlChar_trim($request->getPost('mobilephone'), true, false, true));
                $login->setWebsite($filterData->stripTags_replaceHtmlChar_trim($request->getPost('website'), true, false, true));
                //By default a registration has to be validated by an administrator
                $login->setIsValidate(false);

                $privatespaceDao = new PrivatespaceDao();
                $space = new Privatespace();
                $space = $privatespaceDao->getSpace($filterData->stripTags_replaceHtmlChar_trim((int)$request->getPost('spacesList'), true, false, true));
                $login->setSpace($space);

                //Check if email is unique else error message
                $isEmailExist = $privatespaceloginmgmtDao->countLoginByEmailAndPrivatespace($space->getId(), $login->getEmail());

                if ($isEmailExist > 0) {
                    $form->get('pwd')->setAttribute('value', "");
                    $form->get('pwdconfirm')->setAttribute('value', "");
                    return array(
                        'form' => $form,
                        'error' => array(array($this->translator->translate("Un compte existe déjà avec cette email"))));
                }

                $privatespaceloginmgmtDao->saveLogin($login);
                /*
                  $transport = new SmtpTransport();
                  $options = new SmtpOptions(array(
                  'name' => EmailRegistrationConfig::$smtpServerNameForContact,
                  'host' => EmailRegistrationConfig::$smtpHostServerForContact,
                  'port' => EmailRegistrationConfig::$smtpHostPortForContact,
                  'connection_class' => EmailRegistrationConfig::$connectionClassForContact,
                  'connection_config' => array(
                  'username' => EmailRegistrationConfig::$connectionConfigUsernameForContact,
                  'password' => EmailRegistrationConfig::$connectionConfigPwdForContact,
                  'ssl' => EmailRegistrationConfig::$connectionConfigSSLForContact
                  ),
                  ));

                  $transport->setOptions($options);
                  $transport->send($messageToSend);
                 */
                return $this->redirect()->toRoute('siteprivate',
                    array('action' => 'displayregistrationstate'),
                    array('query' => array(
                        'msg' => 'registration'
                    )));
            } else {
                if (!$formIsValid) {
                    $error = $form->getMessages();
                } elseif ($pwdComparison != 0) {
                    $error[0] = array($this->translator->translate('Les mots de passes saisis sont différents'));
                }

                $form->get('pwd')->setAttribute('value', "");
                $form->get('pwdconfirm')->setAttribute('value', "");

                return array(
                    'form' => $form,
                    'error' => $error);
            }
        }
        return array(
            'form' => $form,
            'error' => '');
    }

    /**
     * @return array|\Laminas\Http\Response
     */
    public function updatecontactinformationAction()
    {

        $form = new SiteprivateUpdateInfoForm();
        $loginBD = new Privatespacelogin();
        // $this->translator = $this->getServiceLocator()->get('translator');
        $privatespaceloginmgmtDao = new PrivatespaceloginDao();
        $rubriqueDao = new RubriqueDao;
        $loginaccess = new \Laminas\Session\Container('myacl');
        $mcrypt = new MCrypt();
        $allPagesBySpace = null;
        $allPagesBySpaceJSON = null;
        $page = $this->params()->fromRoute('page');
        $rubrique = new Rubrique();
        $role = $loginaccess->role;
        $loginDB = new Privatespacelogin();
        $spaceId = 0;
        $sessionData = json_decode($mcrypt->decrypt($loginaccess->userdata));

        if ((empty($page) || strcasecmp($page, 'index') == 0)) {
            $page = 'index';
        }

        if ((strcasecmp($role, MyAclRoles::$ADMIN) == 0) || (strcasecmp($role, MyAclRoles::$USER) == 0)) {

            $rubrique = $rubriqueDao->getPrivateRubriqueByFilename($page, "object");
            //getRubriqueByFilename($page.".phtml");
        } else {
            $rubrique = $rubriqueDao->getFirstRubriqueBySpace($sessionData->spaceId, "object");
            $page = str_replace(".phtml", "", $rubrique->getFilename());
        }


        //loginId=>id login, loginEmail=>email login, spaceId=>id private space, spaceName=> name private space,
        //pageName=> first file private page, pageId=>page Id

        // $cache = $this->getServiceLocator()->get('CacheDataListener');

        //get cache
        $result = $this->cache->getCacheDataItem($this->getEvent()->getRouteMatch());
        if (!$result) {
            //if ((strcasecmp($role, MyAclRoles::$ADMIN) == 0) || (strcasecmp($role, MyAclRoles::$USER) == 0)) {
            $allPagesBySpace = $rubriqueDao->getAllRubriquesBySpaceId($rubrique->getSpaceId(), "array");
            //var_dump($allPagesBySpace);
            $allPagesBySpaceJSON = json_encode($allPagesBySpace);
            //var_dump($allPagesBySpaceJSON);
            //} else {
            //    $allPagesBySpace = $rubriqueDao->getAllRubriquesBySpaceId($sessionData->spaceId, "array");
            //    $allPagesBySpaceJSON = json_encode($allPagesBySpace);
            //}
            //Cache management
            $this->cache->setCacheDataItem($this->getEvent()->getRouteMatch(), array(
                    'navigationJSON' => $allPagesBySpaceJSON,
                    'navigation' => $allPagesBySpace
                )
            );
            $this->layout()->setVariable('navigation', $allPagesBySpace);
            $this->layout()->setVariable('navigationJSON', $allPagesBySpaceJSON);
        } else {
            $this->layout()->setVariable('navigation', $result['navigation']);
            $this->layout()->setVariable('navigationJSON', $result['navigationJSON']);
        }

        $request = $this->getRequest();
        if ((strcasecmp($role, MyAclRoles::$ADMIN) != 0) && (strcasecmp($role, MyAclRoles::$USER) != 0)) {
            $loginDB = $privatespaceloginmgmtDao->getLogin($sessionData->loginId);
        } else {
            $loginDB->setPwd('whatever');

        }

        if ($request->isPost()) {

            $form->setInputFilter(new SiteprivateupdateInfoInputFilter());
            //var_dump($loginDB->getEmail());
            $hashEmail = sha1($loginDB->getEmail());
            // var_dump($hashEmail);
            if (strcmp($hashEmail, $request->getPost('email')) != 0) {
                $form->get('pwd')->setAttribute('value', "");
                return array(
                    'pwd' => $loginDB->getPwd(),
                    'form' => $form,
                    'error' => $this->translator->translate('Vous ne pouvez pas modifier votre email'));
            }

            //disable the email validator
            $form->setData($request->getPost());

            if ($form->isValid()) {

                $login = new Privatespacelogin();
                $privatespaceloginmgmtDao = new PrivatespaceloginDao();

                $filterData = new Utils();
                $login->setId($sessionData->loginId);
                $login->setFirstname($filterData->stripTags_replaceHtmlChar_trim($request->getPost('firstname'), true, false, true));
                $login->setLastname($filterData->stripTags_replaceHtmlChar_trim($request->getPost('lastname'), true, false, true));
                $login->setEmail($filterData->stripTags_replaceHtmlChar_trim($loginDB->getEmail(), true, false, true));
                $login->setPwd($filterData->stripTags_replaceHtmlChar_trim($request->getPost('pwd'), true, false, true));
                $login->setCompany($filterData->stripTags_replaceHtmlChar_trim($request->getPost('company'), true, false, true));
                $login->setStreetnumber($filterData->stripTags_replaceHtmlChar_trim($request->getPost('streetnumber'), true, false, true));
                $login->setStreetline_1($filterData->stripTags_replaceHtmlChar_trim($request->getPost('streetline_1'), true, false, true));
                $login->setStreetline_2($filterData->stripTags_replaceHtmlChar_trim($request->getPost('streetline_2'), true, false, true));
                $login->setStreetline_3($filterData->stripTags_replaceHtmlChar_trim($request->getPost('streetline_3'), true, false, true));
                $login->setZipcode($filterData->stripTags_replaceHtmlChar_trim($request->getPost('zipcode'), true, false, true));
                $login->setCity($filterData->stripTags_replaceHtmlChar_trim($request->getPost('city'), true, false, true));
                $login->setHomephone($filterData->stripTags_replaceHtmlChar_trim($request->getPost('homephone'), true, false, true));
                $login->setMobilephone($filterData->stripTags_replaceHtmlChar_trim($request->getPost('mobilephone'), true, false, true));
                $login->setWebsite($filterData->stripTags_replaceHtmlChar_trim($request->getPost('website'), true, false, true));
                $login->setIsValidate($loginDB->getIsValidate());

                $privatespaceDao = new PrivatespaceDao();
                $space = new Privatespace();
                $space = $privatespaceDao->getSpace($sessionData->spaceId);
                $login->setSpace($space);
                $privatespaceloginmgmtDao->saveLogin($login);
                return $this->redirect()->toRoute('siteprivate', array('action' => 'displayprivatepage'));
            } else {

                $form->get('pwd')->setAttribute('value', "");
                return array(
                    'pwd' => $loginDB->getPwd(),
                    'form' => $form,
                    'error' => $form->getMessages());
            }
        }
        //var_dump($loginDB->getSpace());
        //var_dump($loginDB->getPwd());
        if ((strcasecmp($role, MyAclRoles::$ADMIN) != 0) && (strcasecmp($role, MyAclRoles::$USER) != 0)) {
            $form = $this->fillPrivatespaceloginForm($form, $loginDB, $loginDB->getSpace()->getId());
        }

        return array(
            'pwd' => $loginDB->getPwd(),
            'form' => $form,
            'error' => '');
    }

    /**
     * @param $form
     * @param $login
     * @param $spaceId
     * @return mixed
     */
    private function fillPrivatespaceloginForm($form, $login, $spaceId)
    {
        $form->get('id')->setAttribute('value', $login->getId());
        $form->get('firstname')->setAttribute('value', $login->getFirstname());
        $form->get('lastname')->setAttribute('value', $login->getLastname());
        $form->get('email')->setAttribute('value', sha1($login->getEmail()));
        //$form->get('pwd')->setAttribute('value', $login->getPwd());
        $form->get('company')->setAttribute('value', $login->getCompany());
        $form->get('streetnumber')->setAttribute('value', $login->getStreetnumber());
        $form->get('streetline_1')->setAttribute('value', $login->getStreetline_1());
        $form->get('streetline_2')->setAttribute('value', $login->getStreetline_2());
        $form->get('streetline_3')->setAttribute('value', $login->getStreetline_3());
        $form->get('zipcode')->setAttribute('value', $login->getZipcode());
        $form->get('city')->setAttribute('value', $login->getCity());
        $form->get('homephone')->setAttribute('value', $login->getHomephone());
        $form->get('mobilephone')->setAttribute('value', $login->getMobilephone());
        $form->get('website')->setAttribute('value', $login->getWebsite());
        return $form;
    }

    /**
     * @return array|\Laminas\Http\Response
     */
    public function forgottenpasswordAction()
    {

        $form = new SiteprivateForgottenPasswordForm();

        // $this->translator = $this->getServiceLocator()->get('translator');
        // exit;
        $request = $this->getRequest();

        if ($request->isPost()) {
            $form->setData($request->getPost());
            $privatespaceloginDao = new PrivatespaceloginDao();
            $utils = new Utils();
            $user = $utils->stripTags_replaceHtmlChar_trim($request->getPost('email'), true, true, true);
            //var_dump($user);
            $countOccurences = $privatespaceloginDao->countLoginByEmail($user);
            //var_dump($countOccurences);
            //var_dump($form->isValid());
            if ($form->isValid() && $countOccurences == 1) {
                $rubriqueDao = new RubriqueDao();
                $login = $privatespaceloginDao->getLoginByEmail($user);
                //it retrieves the first page of the private space related to the email address
                $page = $rubriqueDao->getFirstRubriqueBySpace($login->getSpace()->getId(), "object");
                $txt = $this->translator->translate('Veuillez cliquer sur le lien afin d\'initialiser un nouveau mot de passe');
                $mcrypt = new MCrypt();
                //Create token with data inside
                $dataToken = array();
                $dataToken['email'] = $user;
                $dataToken['timestamp'] = time();
                $dataToken['space'] = $page->getSpaceId();
                $dataToken['pagename'] = str_replace(".phtml", "", $page->getFilename());
                //it serializes data in json and it encrypts the json
                $token = $mcrypt->encrypt(json_encode($dataToken));

                //get url in order to create the link. this link will be sent by email
                $uri = $this->getRequest()->getUri();
                $url = sprintf('%s://%s%s', $uri->getScheme(), $uri->getHost(), $uri->getPath()) . '?go=' . $token;
                $url = str_replace('forgottenpassword', 'changepassword', $url);
                $txt .= '<a href="' . $url . '">' . $url . '</a>';
                //var_dump($url);
                //var_dump($txt);
                //exit;
                //create email
                $subject = $this->translator->translate("Changer votre mot de passe ");
                $from = EmailForgottenPasswordConfig::$emailAdressForContact;
                $to = $user;

                $message = new EmailSent();

                $message->setRow1($login->getFirstname() . " " . $login->getLastname());
                $message->setRow2($login->getCompany());
                $message->setRow3($from);
                $message->setMessage($txt);
                $message->setDate(date("Y-m-d H:i:s", time()));
                $message->setType(\Message\Model\TypeMessage::$forgottenPassword);
                $messageDao = new MessageDao();

                $messageDao->saveMessage($message);


                //zend message sendmail
                /* $emailMessage = new Message();
                  $emailMessage->addFrom($from, $name)
                  ->addTo($to)
                  ->setSubject($subject)
                  ->setBody($txt);

                  $transport = new SendmailTransport();
                  $transport->send($emailMessage);
                 */
                /*
                  //TODO catch exceptions
                  //zend message smtp
                  $messageToSend = new Message();
                  $messageToSend->addFrom($from, $login->getFirstname() . " " . $login->getLastname())
                  ->addTo($to)
                  ->setSubject($subject);
                  $messageToSend->setBody($txt);

                  $messageToSend->setEncoding("UTF-8");

                  $transport = new SmtpTransport();
                  $options = new SmtpOptions(array(
                  'name' => EmailForgottenPasswordConfig::$smtpServerNameForContact,
                  'host' => EmailForgottenPasswordConfig::$smtpHostServerForContact,
                  'port' => EmailForgottenPasswordConfig::$smtpHostPortForContact,
                  'connection_class' => EmailForgottenPasswordConfig::$connectionClassForContact,
                  'connection_config' => array(
                  'username' => EmailForgottenPasswordConfig::$connectionConfigUsernameForContact,
                  'password' => EmailForgottenPasswordConfig::$connectionConfigPwdForContact,
                  'ssl' => EmailForgottenPasswordConfig::$connectionConfigSSLForContact
                  ),
                  ));

                  $transport->setOptions($options);
                  $transport->send($messageToSend);
                 */
                return $this->redirect()->toRoute('siteprivate',
                    array('action' => 'displayregistrationstate'),
                    array('query' => array(
                        'msg' => 'forgottenpwd'
                    )));
            } else {
                $error = array();
                if ($countOccurences == 0 || $countOccurences > 1) {
                    $error[0] = array($this->translator->translate('L\'adresse email est incorrect'));
                } else {
                    $error = $form->getMessages();
                }
                //var_dump($error);
                //exit;
                return array(
                    'form' => $form,
                    'error' => $error
                );
            }
        }

        return array(
            'form' => $form,
            'error' => ''
        );
    }

    /**
     * @return array
     */
    public function changepasswordAction()
    {
        $form = new SiteprivateNewPasswordForm();
        $error = array();
        $request = $this->getRequest();
        $dataToken = $this->params()->fromQuery('go');
        $form->get('token')->setAttribute('value', $dataToken);
        if ($request->isPost()) {
            $utils = new Utils();
            $form->setInputFilter(new SiteprivateNewPasswordInputFilter());
            $form->setData($request->getPost());
            $pwd = $utils->stripTags_replaceHtmlChar_trim($request->getPost('pwd'), true, true, true);
            $pwdConfirm = $utils->stripTags_replaceHtmlChar_trim($request->getPost('pwdconfirm'), true, true, true);
            $formIsValid = $form->isValid();
            $pwdComparison = strcmp($pwd, $pwdConfirm);
            if ($formIsValid && $pwdComparison == 0) {
                $mcrypt = new MCrypt();
                $privatespaceDao = new PrivatespaceDao();
                $privatespaceloginDao = new PrivatespaceloginDao();
                $dataToken = $utils->stripTags_replaceHtmlChar_trim($request->getPost('token'), true, false, true);
                $token = $mcrypt->decrypt($dataToken);
                $token = json_decode($token);
                $privatespace = $privatespaceDao->getSpace($token->space);
                // var_dump($token);
                // exit;
                $login = $privatespaceloginDao->getLoginByEmail($token->email);
                $login->setPwd($pwd);
                $privatespaceloginDao->saveLogin($login);
                (bool)$isExist = $privatespaceloginDao->countLoginByEmail($token->email);
                if ($isExist) {
                    //redirect to first page of the private space
                    return $this->redirect()->toRoute('siteprivate', array(
                        'action' => 'index'),
                        array('query' => array(
                            'myspace' => $privatespace->getToken()
                        )));
                } else {

                    $error[0] = array($this->translator->translate('Un compte existe déjà avec cet email'));


                    return array(
                        'form' => $form,
                        'error' => $error);
                }
            } else {

                if (!$formIsValid) {
                    $error = $form->getMessages();
                } elseif ($pwdComparison != 0) {
                    $error[0] = array($this->translator->translate('Les mots de passes saisis sont différents'));
                }

                return array(
                    'form' => $form,
                    'error' => $error);
            }
        }

        return array(
            'form' => $form,
            'error' => '');
    }

    /**
     * @return ViewModel
     */
    public function displayregistrationstateAction()
    {
        $msg = $this->params()->fromQuery('msg');

        return new ViewModel(
            array(
                'msg' => $msg
            )
        );
    }

    /**
     * @param $sessionData
     * @return SiteprivateFileuploadForm
     */
    private function setFileuploadForm($sessionData)
    {
        $fileuploadForm = new SiteprivateFileuploadForm();
        $privatespaceloginDao = new PrivatespaceloginDao();
        $login = $privatespaceloginDao->getLogin($sessionData->loginId);
        $fileuploadForm->get('author')->setAttribute('value', $login->getFirstname() . ' ' . $login->getLastname());
        // useless right now...
        $fileuploadForm->get('userid')->setAttribute('value', $login->getEmail());
        /// redundant for now.
        $fileuploadForm->get('email')->setAttribute('value', $login->getEmail());
        // default status of a document is 'waiting'. it needs to be validate before publishing
        $fileuploadForm->get('status')->setAttribute('value', FileuploadStatus::$WAITING);
        // TODO get latitude and longitude if it is a picture
        $fileuploadForm->get('lat')->setAttribute('value', '0');
        $fileuploadForm->get('lng')->setAttribute('value', '0');

        return $fileuploadForm;
    }
}
