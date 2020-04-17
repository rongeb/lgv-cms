<?php

namespace Login\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Mvc\I18n\Translator;
use Login\Form\LoginForm;
use Login\Form\LoginInputFilter;
use Login\Model\LoginDao;
use Loginmgmt\Model\Mapper\LoginMapper;
use Privatespacelogin\Model\PrivatespaceloginDao;
use Rubrique\Model\RubriqueDao;
use Loginmgmt\Model\Login;
use ExtLib\Utils;
use ExtLib\MCrypt;

/**
 * Class LoginController
 * @package Login\Controller
 */
class LoginController extends AbstractActionController {

    private $translator;

    /**
     * LoginController constructor.
     * @param Translator $translator
     */
    public function __construct(Translator $translator){
        $this->translator = $translator;
    }

    /**
     * @return ViewModel
     */
    public function indexAction() {

        $form = new LoginForm();
        //$response = generateAction();
        $loginaccess = new \Zend\Session\Container('myacl');
        $loginaccess->role = 'anonymous';
        return new ViewModel(array(
            'form' => $form,
            'error' => ''
        ));
    }

    /**
     * @return \Zend\Http\Response
     */
    public function authAction() {

        $loginDao = new LoginDao();
        // $this->translator=$this->getServiceLocator()->get('translator');
        
        $form = new LoginForm();

        
        $request = $this->getRequest();
        
        if ($request->isPost()) {
            
            $login = new Login();
            $form->setInputFilter(new LoginInputFilter());

            $form->setData($request->getPost());
            
            $mcrypt = new MCrypt();
            
            if ($form->isValid()) {
                $loginMapper = new LoginMapper();
                $login = $loginMapper->exchangeForm($form->getData());
                $utils = new Utils();
                $rowNb = $loginDao->getAuthenticationByUserAndPwd($utils->stripTags_replaceHtmlChar_trim($login->getUser(), true, true, false),
                        $utils->stripTags_replaceHtmlChar_trim($login->getPwd(), true, true, false));
                //print_r($rowNb);
                if ($rowNb == 0) {
                    $loginaccess = new \Zend\Session\Container('error');
                    $loginaccess->error = $this->translator->translate('Veuillez recommencer le nom d\'utilisateur et/ou le mot de passe sont incorrects');
                    return $this->redirect()->toRoute('Login');
                    
                } elseif ($rowNb == 1) {
                    $privatespaceLoginDao = new PrivatespaceloginDao();

                    //the first privatespaceLogin's Id is always 1
                    //the id has been reserved to visualize privatepace pages
                    $rubriqueDao = new RubriqueDao();
                    //$privatespaceLogin = $privatespaceLoginDao->getLogin(1);
                    //var_dump($privatespaceLogin);
                    //TODO check if privatespacelogin exists
                    //$rubrique = $rubriqueDao->getFirstRubriqueBySpace($privatespaceLogin->getSpace()->getId(), 'array');
                    $sessionData = array();
                    $sessionData['loginId'] = 1000000000;
                    $sessionData['loginEmail'] = 'whatever@anit.org';
                    $sessionData['spaceId'] = 1000000000;
                    $sessionData['spaceName'] = 'whatever';
                    $sessionData['pageName'] = 'whatever.phtml';
                    $sessionData['pageId'] = 1000000000;
                    
                    $loginaccess = new \Zend\Session\Container('myacl');
                    
                    $loginaccess->userdata = $mcrypt->encrypt(json_encode($sessionData));
                    $role = $loginDao->getRole($utils->stripTags_replaceHtmlChar_trim($login->getUser(), true, true, false),
                        $utils->stripTags_replaceHtmlChar_trim($login->getPwd(), true, true, false)); 
                    $loginaccess->role = $role;

                    return $this->redirect()->toRoute('rubrique');
                } else {
                    $loginaccess = new \Zend\Session\Container('error');
                    $loginaccess->error = $this->translator->translate('Veuillez contacter l\'administrateur du site svp.');
                    return $this->redirect()->toRoute('Login');
                }
            }
            else {
                //form is not valid because the csrf token is not the same anymore
                $loginaccess = new \Zend\Session\Container('error');
                $loginaccess->error = $this->translator->translate('Veuillez rafraichir la page et recommencer svp.');
                return $this->redirect()->toRoute('Login');
            }
        }
    }

    /**
     * @return json
     */
    public function logoutAction() {
        $loginaccess = new \Zend\Session\Container('myacl');
        $loginaccess->getManager()->getStorage()->clear('myacl');
        return json_encode(array("response"=>"OK"));
        //return $this->redirect()->toRoute('Login');
    }

}
