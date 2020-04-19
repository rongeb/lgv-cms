<?php

namespace Privatespacelogin\Controller;

use Privatespace\Model\Privatespace;
use Privatespace\Model\PrivatespaceDao;
use Privatespacelogin\Model\Privatespacelogin;
use Privatespacelogin\Model\PrivatespaceloginDao;
use Privatespacelogin\Form\PrivatespaceloginForm;
use Privatespacelogin\Form\PrivatespaceloginInputFilter as InputFilter;
use Privatespacelogin\Controller\PrivatespaceloginErrorMessages;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use ExtLib\Utils;
use Laminas\Mvc\I18n\Translator;

/**
 * Class PrivatespaceloginController
 * @package Privatespacelogin\Controller
 */
class PrivatespaceloginController extends AbstractActionController {

    private $translator;

    /**
     * PrivatespaceloginController constructor.
     * @param Translator $translator
     */
    public function __construct(Translator $translator){
        $this->translator = $translator;
    }
    public function indexAction() {

        $privatespaceDao = new PrivatespaceDao();

        return new ViewModel(array(
            'spaces' => $privatespaceDao->getAllSpaces('object')
        ));
    }

    /**
     * @return \Laminas\Http\Response|ViewModel
     */
    public function indexloginAction() {

        $privatespaceloginmgmtDao = new PrivatespaceloginDao();

        $id = (int) $this->params()->fromRoute('id', 0);

        if (!$id) {
            return $this->redirect()->toRoute('privatespacelogin', array(
                        'action' => 'index'
            ));
        }

        $privateLoginList = $privatespaceloginmgmtDao->getAllLoginBySpace($id, "object");

        return new ViewModel(array(
            //'rubriques' => $this->rubriqueDao->fetchAll(),
            'loginlist' => $privateLoginList
                //'session'=> $useraccess
        ));
    }

    /**
     * @return array|\Laminas\Http\Response
     */
    public function addAction() {

        $form = new PrivatespaceloginForm();

        // $this->translator = $this->getServiceLocator()->get('translator');
        $form->get('id')->setAttribute('value', 0);
        $form->get('submitbutton')->setAttribute('value', $this->translator->translate('Ajouter'));

        $request = $this->getRequest();
        if ($request->isPost()) {
            //$form->setInputFilter($space->getInputFilter());
            $form->setInputFilter(new InputFilter());

            $form->setData($request->getPost());

            if ($form->isValid()) {
                $login = new Privatespacelogin();
                $privatespaceloginmgmtDao = new PrivatespaceloginDao();

                $filterData = new Utils();

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
                $login->setIsValidate($filterData->stripTags_replaceHtmlChar_trim((int) $request->getPost('validate'), true, false, true));
                $privatespaceDao = new PrivatespaceDao();
                $space = new Privatespace();
                $space = $privatespaceDao->getSpace($filterData->stripTags_replaceHtmlChar_trim((int) $request->getPost('spacesList'), true, false, true));
                $login->setSpace($space);

                //Check if email is unique else error message
                $isEmailExist = $privatespaceloginmgmtDao->countLoginByEmailAndPrivatespace($space->getId(), $login->getEmail());

                if ($isEmailExist > 0) {
                    $form->get('pwd')->setAttribute('value', "");
                    return array(
                        'form' => $form,
                        'error' => array(array($this->translator->translate(PrivatespaceloginErrorMessages::$emailAlreadyRegistered))));
                }

                $privatespaceloginmgmtDao->saveLogin($login);
                
                // Redirect to list of privatespaces
                return $this->redirect()->toRoute('privatespacelogin', array('action' => 'indexlogin', 'id' => $space->getId()));
            } else {
                $form->get('pwd')->setAttribute('value', "");
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
     * @return array|\Laminas\Http\Response
     */
    public function editAction() {

        $form = new PrivatespaceloginForm();
        $login = new Privatespacelogin();
        $space = new Privatespace();
        // $this->translator = $this->getServiceLocator()->get('translator');
        $privatespaceloginmgmtDao = new PrivatespaceloginDao();
        $request = $this->getRequest();

        if ($request->isPost()) {
            $filterData = new Utils();
            $form->setInputFilter(new InputFilter());

            $form->setData($request->getPost());
            
            if ($form->isValid()) {
                $id = (int) $request->getPost('id');
                $login = new Privatespacelogin();
                $login->setId($id);
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
                $login->setIsValidate($filterData->stripTags_replaceHtmlChar_trim((int) $request->getPost('validate'), true, false, true));
                $spaceId = (int) $request->getPost('spacesList');
                
                $loginDB = $privatespaceloginmgmtDao->getLogin($id);
                $isEmailExist = 0;
                
                if(strcasecmp($login->getEmail(), $loginDB->getEmail())!=0){
                    //if the email has been changed check if it already exists
                    $isEmailExist = $privatespaceloginmgmtDao->countLoginByEmailAndPrivatespace($spaceId, $login->getEmail());
                }
                
                if ($isEmailExist > 0) {
                    
                    $form->get('pwd')->setAttribute('value', "");
                    return array(
                        'pwd' => $login->getPwd(),
                        'form' => $form,
                        'error' => array(array($this->translator->translate(PrivatespaceloginErrorMessages::$emailAlreadyRegistered))));
                }

                $privatespaceDao = new PrivatespaceDao();

                $space = $privatespaceDao->getSpace($filterData->stripTags_replaceHtmlChar_trim($spaceId, true, false, false));
                $login->setSpace($space);

                $privatespaceloginmgmtDao->saveLogin($login);

                // Redirect to list of privatespaces
                return $this->redirect()->toRoute('privatespacelogin', array('action' => 'indexlogin', 'id' => $space->getId()));
            } else {
                $id = (int) $request->getPost('id');
                $login = $privatespaceloginmgmtDao->getLogin($id);
                //$form = $this->fillPrivatespaceloginForm($form, $login, $login->getSpace()->getId());
                $form->get('pwd')->setAttribute('value', "");
                return array(
                    'pwd' => $login->getPwd(),
                    'form' => $form,
                    'error' => $form->getMessages());
            }
        }

        $form->get('submitbutton')->setAttribute('value', $this->translator->translate('Modifier'));

        $id = (int) $this->params()->fromRoute('id', 0);
        //print_r($id);
        if (!$id) {
            return $this->redirect()->toRoute('privatespacelogin', array(
                        'action' => 'add'
            ));
        }

        $login = $privatespaceloginmgmtDao->getLogin($id);

        $form = $this->fillPrivatespaceloginForm($form, $login, $login->getSpace()->getId());
        
        return array(
            'pwd' => $login->getPwd(),
            'form' => $form,
            'error' => '');
    }

    /**
     * @return array|\Laminas\Http\Response
     */
    public function deleteAction() {

        $privatespaceloginmgmtDao = new PrivatespaceloginDao();
        // $this->translator = $this->getServiceLocator()->get('translator');

        $id = (int) $this->params()->fromRoute('id', 0);

        if (!$id) {
            return $this->redirect()->toRoute('privatespacelogin');
        }

        $request = $this->getRequest();

        if ($request->isPost()) {

            $del = $request->getPost('del', $this->translator->translate('Non'));
            $id = (int) $request->getPost('id');
            $privatespacelogin = $privatespaceloginmgmtDao->getLogin($id);

            if ($del == $this->translator->translate('Oui')) {
                $privatespaceloginmgmtDao->deleteLogin($id);
            }
            // Redirect to list of privatespaces
            return $this->redirect()->toRoute('privatespacelogin', array('action' => 'indexlogin', 'id' => $privatespacelogin->getSpace()->getId()));
        }

        $privatespacelogin = $privatespaceloginmgmtDao->getLogin($id);

        return array(
            'id' => $id,
            'login' => $privatespacelogin
        );
    }

    private function fillPrivatespaceloginForm($form, $login, $spaceId) {
        $form->get('id')->setAttribute('value', $login->getId());
        $form->get('spacesList')->setAttribute('value', $spaceId);
        $form->get('firstname')->setAttribute('value', $login->getFirstname());
        $form->get('lastname')->setAttribute('value', $login->getLastname());
        $form->get('email')->setAttribute('value', $login->getEmail());
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
        $form->get('validate')->setAttribute('value', $login->getIsValidate());
        return $form;
    }

}
