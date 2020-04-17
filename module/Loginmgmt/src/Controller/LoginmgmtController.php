<?php
namespace Loginmgmt\Controller;

use Loginmgmt\Model\Login;
use Loginmgmt\Model\LoginmgmtDao;
use Loginmgmt\Form\LoginmgmtForm;
use Loginmgmt\Form\LoginmgmtInputFilter;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;
use ExtLib\Utils;
use Zend\Mvc\I18n\Translator;

/**
 * Class LoginmgmtController
 * @package Loginmgmt\Controller
 */
class LoginmgmtController extends AbstractActionController {

    private $translator;

    /**
     * LoginmgmtController constructor.
     * @param Translator $translator
     */
    public function __construct(Translator $translator){
        $this->translator = $translator;
    }

    /**
     * @return ViewModel
     */
    public function indexAction() {

        $loginmgmtDao = new LoginmgmtDao();

        //$useraccess =new \Zend\Session\Container('myacl');
        //$login = $useraccess->role;

        return new ViewModel(array(
            //'rubriques' => $this->rubriqueDao->fetchAll(),
            'loginlist' => $loginmgmtDao->getAllLogin('object')
                //'session'=> $useraccess
        ));
    }

    /**
     * @return array|\Zend\Http\Response
     */
    public function addAction() {

        $form = new LoginmgmtForm();
        $loginmgmtDao = new LoginmgmtDao();
        // $this->translator=$this->getServiceLocator()->get('translator');
        
        $login = new Login();

        $form->get('submitbutton')->setValue('Ajouter');
        
        $request = $this->getRequest();

        if ($request->isPost()) {
            
            $form->setData($request->getPost());
            //$form->setInputFilter($rubrique->getInputFilter());
            $form->setInputFilter(new LoginmgmtInputFilter());

            if ($form->isValid()) {
               
                $utils = new Utils();
                $request->getPost()->set('name', $utils->stripTags_replaceHtmlChar_trim($request->getPost('name'), true, true, true));
                $request->getPost()->set('pwd', $utils->stripTags_replaceHtmlChar_trim($request->getPost('pwd'), true, true, true));
                
                $login->setUser($request->getPost('name'));
                $login->setPwd($request->getPost('pwd'));
                $login->setRole($request->getPost('roleList'));
                
                $isExist = $loginmgmtDao->checkLoginUserame($login->getUser());
                
                if($isExist == 0){
                    $loginmgmtDao->saveLogin($login);
                    return $this->redirect()->toRoute('loginmgmt');
                }
                else{
                    $form->get('pwd')->setValue('');
                    return array(
                    'form' => $form,
                    'error' => array(
                        array('error' => $this->translator->translate('Un utilisateur existe déjà avec ce nom, veuillez en choisir un autre'))
                    ));
                }
                
            } 
            else {

                return array(
                    'form' => $form,
                    'error' => $form->getMessages());
                }
        }

        return array(
            'form' => $form,
            'error' => '');
    }

    /**
     * @return array|\Zend\Http\Response|ViewModel
     */
    public function editAction() {

        $form = new LoginmgmtForm();
        $loginmgmtDao = new LoginmgmtDao();
        // $this->translator=$this->getServiceLocator()->get('translator');
        
        $id = (int) $this->params()->fromRoute('id', 0);

        if (!$id) {
            return $this->redirect()->toRoute('loginmgmt', array(
                        'action' => 'add'
            ));
        }
        $login = new Login();
        $login = $loginmgmtDao->getLogin($id);
        
        $loginId = $login->getId();
        
        if(!empty($id)){
            if (empty($loginId)) {
                //return $this->getResponse()->setStatusCode(404);
                return $this->notFoundAction();
            }
        }
        
        $form->get('id')->setAttribute('value', $login->getId());
        $form->get('name')->setAttribute('value', $login->getUser());
        //$form->get('pwd')->setAttribute('value', $login->getPwd());
        $form->get('roleList')->setAttribute('value', $login->getRole());
        
        $form->get('submitbutton')->setAttribute('value', 'Modifier');

        $request = $this->getRequest();

        if ($request->isPost()) {
            $form->setData($request->getPost());
            //$form->setInputFilter($rubrique->getInputFilter());
            $form->setInputFilter(new LoginmgmtInputFilter());

            if ($form->isValid()) {

                $utils = new Utils();
                
                $loginOld = $loginmgmtDao->getLogin($id);
                
                $request->getPost()->set('name', $utils->stripTags_replaceHtmlChar_trim($request->getPost('name'), true, true, true));
                $request->getPost()->set('pwd', $utils->stripTags_replaceHtmlChar_trim($request->getPost('pwd'), true, true, true));
                
                $login->setId($request->getPost('id'));
                $login->setUser($request->getPost('name'));
                $login->setPwd($request->getPost('pwd'));
                $login->setRole($request->getPost('roleList'));
                
                //check if the new username is not already used
                if(strcmp($login->getUser(), $loginOld->getUser()) != 0){
                    $isExist= $loginmgmtDao->checkLoginUserame($login->getUser());
                    //if it s not used -> save
                    if($isExist == 0){
                        $loginmgmtDao->saveLogin($login);
                        return $this->redirect()->toRoute('loginmgmt');
                    }
                    else{
                        $form->get('pwd')->setValue('');
                        return array(
                        'id' => $id,    
                        'form' => $form,
                        'pwd' => $loginOld->getPwd(),    
                        'error' => array(
                            array('error' => $this->translator->translate('Un utilisateur existe déjà avec ce nom, veuillez en choisir un autre'))
                        ));
                    }
                }
                
                $loginmgmtDao->saveLogin($login);
                
                return $this->redirect()->toRoute('loginmgmt');
            } else {

                return array(
                    'id' => $id,
                    'pwd' => $login->getPwd(),
                    'form' => $form,
                    'error' => $form->getMessages());
            }
        }

        return array(
            'id' => $id,
            'pwd' => $login->getPwd(),
            'form' => $form,
            'error' => ''
        );
    }

    /**
     * @return array|\Zend\Http\Response
     */
    public function deleteAction() {

        $loginmgmtDao = new LoginmgmtDao();
        // $this->translator=$this->getServiceLocator()->get('translator');
        
        $id = (int) $this->params()->fromRoute('id', 0);

        if (!$id) {
            return $this->redirect()->toRoute('loginmgmt');
        }

        $request = $this->getRequest();

        if ($request->isPost()) {

            $del = $request->getPost('del', $this->translator->translate('Non'));

            if ($del == $this->translator->translate('Oui')) {
                $id = (int) $request->getPost('id');
                $loginmgmtDao->deleteLogin($id);
            }

            // Redirect to list of rubriques
            return $this->redirect()->toRoute('loginmgmt');
        }

        $login = $loginmgmtDao->getLogin($id);

        return array(
            'id' => $id,
            'login' => $login
        );
    }
    
}
