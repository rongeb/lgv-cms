<?php

namespace Sitepublic\Controller;

use Contenu\Model\ContenuType;
use MyAcl\Controller\Plugin\MyAclRoles;
use Rubrique\Model\RubriqueDao;
use Rubrique\Model\MetaDao;
use Commentaire\Model\Commentaire;
use Commentaire\Model\CommentaireDao;
use Commentaire\Model\StatusComment;
use Siteprivate\Form\SiteprivateCommentForm;
use Siteprivate\Form\SiteprivateCommentInputFilter;
use Siteprivate\Form\SiteprivateContactForm;
use Siteprivate\Form\SiteprivateContactInputFilter;
use Siteprivate\EmailConfig\EmailCommentConfig;
use Siteprivate\EmailConfig\EmailContactConfig;
use Pagearrangement\Model\PagearrangementDao;
use Sitepublic\Form\SitepublicCommentForm;
use Sitepublic\Form\SitepublicCommentInputFilter;
use Zend\Mvc\Controller\AbstractActionController;
use Message\Model\MessageDao;
use Message\Model\Message as EmailSent;
use Zend\Mail\Message;
use Zend\Mail\Transport\Smtp as SmtpTransport;
use Zend\Mail\Transport\Sendmail as SendmailTransport;
use Zend\Mail\Transport\SmtpOptions;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use ExtLib\Utils;
use Application\Factory\CacheDataListener;
use Zend\Mvc\I18n\Translator;

/**
 * Class SitepublicController
 * @package Sitepublic\Controller
 */
class SitepublicController extends AbstractActionController
{

    private $cache;
    private $translator;

    /**
     * SitepublicController constructor.
     * @param CacheDataListener $cacheDataListener
     * @param Translator $translator
     */
    public function __construct(CacheDataListener $cacheDataListener, Translator $translator)
    {
        $this->cache = $cacheDataListener;
        $this->translator = $translator;
    }

    private static $publicSpace = -1;

    /**
     * @return null|ViewModel
     */
    public function displaypublicpageAction()
    {

        $pageArrangementDao = new PagearrangementDao();
        $metaDao = new MetaDao();
        $commentaireDao = new CommentaireDao();
        $rubriqueDao = new RubriqueDao();
        $contactForm = null;
        $commentForm = null;
        $page = $this->params()->fromRoute('page');
        $phtmlFile = "";
        $viewModel = null;

        $loginaccess = new \Zend\Session\Container('myacl');
        //get cache only for anonymous or extranet user ('guest')
        if ((strcasecmp($loginaccess->role, MyAclRoles::$USER) != 0 || strcasecmp($loginaccess->role, MyAclRoles::$ADMIN) != 0)
        ) {
            //get cache
            $result = $this->cache->getCacheDataItem($this->getEvent()->getRouteMatch());
        }

        //if no rubrique filename (without extension) is in the url, the first page will be displayed
        if (!$result && empty($page)) {
            $firstRubrique = $rubriqueDao->getFirstRubriqueBySpaceId(SitepublicController::$publicSpace, "object");
            $page = str_replace(".phtml", "", $firstRubrique->getFilename());
            // print_r($firstRubrique);
            //exit;
        }

        if (!$result) {
            $rubrique = $rubriqueDao->getPublicRubriqueByFilename($page . ".phtml", 'object');
            //if the page is not authorized to be published but the request comes from an user of the back-office or an adminstrator
            //the page will be displayed
            if (($rubrique->getId() == null || (int)$rubrique->getId() == 0) && (strcasecmp($loginaccess->role, MyAclRoles::$USER) == 0
                    || strcasecmp($loginaccess->role, MyAclRoles::$ADMIN) == 0)
            ) {
                $rubrique = $rubriqueDao->getRubriqueByFilename($page . ".phtml", 'object');
            } elseif ($rubrique->getId() == null || (int)$rubrique->getId() == 0) {
                return $this->notFoundAction();
            }

            $idrub = $rubrique->getId();
            $allPagesBySpace = $rubriqueDao->getAllRubriquesBySpaceId(SitepublicController::$publicSpace, "array");
            $allPagesBySpaceJSON = json_encode($allPagesBySpace);

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
                'metas' => $metas,
                'pageContents' => $pageContents,
                'pageContentsJSON' => $pageContentsJSON,
                'comments' => $comments
            ));
        } //if the cache exists
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
            $phtmlFile = $configuration['phtmlFile'];

            $viewModel = new ViewModel(array(
                'navigationJSON' => $result['navigationJSON'],
                'navigation' => $result['navigation'], //if you need it in the body or if you don't want to use header
                'contactForm' => $contactForm,
                'commentForm' => $commentForm,
                'metas' => $result['metas'],
                'pageContents' => $result['pageContents'],
                'pageContentsJSON' => $result['pageContentsJSON'],
                'comments' => $result['comments']
            ));
        }

        $viewModel->setTemplate('sitepublic/sitepublic/' . $phtmlFile);

        return $viewModel;
    }

    /**
     * @return JsonModel
     */
    public function addcommentajaxAction()
    {

        $request = $this->getRequest();

        if ($request->isPost()) {

            $form = new SitepublicCommentForm();

            //trigger data controls
            $form->setInputFilter(new SitepublicCommentInputFilter());
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
                /*
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
                /*
                 * Send email through smtp
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
     * @param $pageContents
     * @return array
     */
    private function getInformationFromPage($pageContents)
    {
        $configuration = array();
        $configuration['hasMessageForm'] = false;
        $configuration['hasContactForm'] = false;
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
            }// set contenuId for commentForm
            // We consider there is only one blog content in a page
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

}
