<?php

namespace Message\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Laminas\View\Model\JsonModel;
//use Laminas\Validator\File\Size;
//use Laminas\Validator\File\Extension;
use Message\Model\Message;
use Message\Form\MessageForm;
use Message\Form\MessageInputFilter;
use Message\Model\MessageDao;
//use ExtLib\FastJson;
use ExtLib\Utils;
use Application\Factory\CacheDataListener;
use Laminas\Mvc\I18n\Translator;

/**
 * Class MessageController
 * @package Message\Controller
 */
class MessageController extends AbstractActionController {

    protected $translator;
    protected $cache;

    /**
     * MessageController constructor.
     * @param CacheDataListener $cacheDataListener
     * @param Translator $translator
     */
    public function __construct(CacheDataListener $cacheDataListener, Translator $translator){
        $this->cache = $cacheDataListener;
        $this->translator = $translator;
    }


    /**
     * @return ViewModel
     */
    public function indexAction() {

        $messageDao = new MessageDao();
        //print_r($messageDao->getAllMessages("object"));
        return new ViewModel(array(
            'messages' => $messageDao->getAllMessages("object")
        ));
    }

    /**
     * @return array|\Laminas\Http\Response
     */
    public function addAction() {

        $form = new MessageForm();
        $messageDao = new MessageDao();
        
        // $this->translator=$this->getServiceLocator()->get('translator');
        $form->get('submitbutton')->setAttribute('value', $this->translator->translate('Ajouter'));
        
        $request = $this->getRequest();

        if ($request->isPost()) {
            //trigger data controls
            $message = new Message();
            $form->setInputFilter(new MessageInputFilter());
            $form->setData($request->getPost());
            //$form->setUseInputFilterDefaults(false);
            
            if ($form->isValid()) {
                /* Save message from filled form -> must add image path */
                $message = new Message();
                $filterData = new Utils();
                
                //$message['id'] = $filterData->stripTags_replaceHtmlChar_trim($request->getPost('id'), true, true, true);
                $message->setRow1($filterData->stripTags_replaceHtmlChar_trim($request->getPost('row1'), false, false, true));
                $message->setRow2($filterData->stripTags_replaceHtmlChar_trim($request->getPost('row2'), false, false, true));
                $message->setRow3($filterData->stripTags_replaceHtmlChar_trim($request->getPost('row3'), false, false, true));
                $message->setRow4($filterData->stripTags_replaceHtmlChar_trim($request->getPost('row4'), false, false, true));
                $message->setType($filterData->stripTags_replaceHtmlChar_trim($request->getPost('type'), true, false, true));
                //$message->setType($request->getPost('type'));
                $message->setDate($filterData->stripTags_replaceHtmlChar_trim($request->getPost('timestamp'), true, false, true));
                //$message['position'] = $filterData->stripTags_replaceHtmlChar_trim($request->getPost('position'), true, true, true);
                $message->setMessage($filterData->stripTags_replaceHtmlChar_trim($request->getPost('msg'), true, true, true));
                
                $messageDao->saveMessage($message);
                
                //flush cache
                $this->cache->getCacheService()->flush();
                
                return $this->redirect()->toRoute('Message');
            }
            else{
                
                return array(
                    'form' => $form,
                    'error' => $form->getMessages());
            }
            
        }
        
        return array(
            'form' => $form,
            'error' => "no error");
    }

    /**
     * @return array|\Laminas\Http\Response
     */
    public function editAction() {

        $form = new MessageForm();
        
        // $this->translator=$this->getServiceLocator()->get('translator');
        $form->get('submitbutton')->setAttribute('value', $this->translator->translate('Modifier'));
        
        $messageDao = new MessageDao();
        
        $id = (int) $this->params()->fromRoute('id', 0);
        /*
        if ($id == 0) {
            return $this->redirect()->toRoute('Message', array(
                        'action' => 'add'
            ));
        }
        */
        $message = $messageDao->getMessage($id);
        
        $messageId = $message->getId();
        
        if(!empty($id)){
            if (empty($messageId)) {
                //return $this->getResponse()->setStatusCode(404);
                return $this->notFoundAction();
            }
        }
        
        $form->get('id')->setAttribute('value', $message->getId());
        $form->get('row1')->setAttribute('value', $message->getRow1());
        $form->get('row2')->setAttribute('value', $message->getRow2());
        $form->get('row3')->setAttribute('value', $message->getRow3());
        $form->get('row4')->setAttribute('value', $message->getRow4());
        $form->get('type')->setAttribute('value', $message->getType());
        $form->get('msg')->setAttribute('value', $message->getMessage());
        //$form->get('position')->setAttribute('value', $message->getRang());
        $form->get('timestamp')->setAttribute('value', $message->getDate());
        $form->get('submitbutton')->setAttribute('value', 'Modifier');
        $request = $this->getRequest();

        if ($request->isPost()) {
            //trigger data controls
            $message = new Message();
            $form->setInputFilter(new MessageInputFilter());
            $form->setData($request->getPost());
            //$form->setUseInputFilterDefaults(false);
            //print_r('nonOK');
            //    exit;
            if ($form->isValid()) {
                
                $filterData = new Utils();
                
                $message->setId($filterData->stripTags_replaceHtmlChar_trim($request->getPost('id'), true, false, true));
                $message->setRow1($filterData->stripTags_replaceHtmlChar_trim($request->getPost('row1'), false, false, true));
                $message->setRow2($filterData->stripTags_replaceHtmlChar_trim($request->getPost('row2'), false, false, true));
                $message->setRow3($filterData->stripTags_replaceHtmlChar_trim($request->getPost('row3'), false, false, true));
                $message->setRow4($filterData->stripTags_replaceHtmlChar_trim($request->getPost('row4'), false, false, true));
                $message->setType($filterData->stripTags_replaceHtmlChar_trim($request->getPost('type'), true, true, true));
                $message->setDate($filterData->stripTags_replaceHtmlChar_trim($request->getPost('timestamp'), true, false, true));
                //$message['position'] = $filterData->stripTags_replaceHtmlChar_trim($request->getPost('position'), true, true, true);
                $message->setMessage($filterData->stripTags_replaceHtmlChar_trim($request->getPost('msg'), true, true, true));
                
                $messageDao->saveMessage($message);
                
                //flush cache
                $this->cache->getCacheService()->flush();
                
                return $this->redirect()->toRoute('Message');
            } else {
                return array(
                    'id' => $id,
                    'form' => $form,
                    'error' => $form->getMessages()
                );
            }
        }
        
        return array(
            'id' => $id,
            'form' => $form,
            'error' => "no error"
        );
    }

    /**
     * @return array|\Laminas\Http\Response
     */
    public function deleteAction() {

        // $this->translator=$this->getServiceLocator()->get('translator');
        
        $messageDao = new MessageDao();

        $id = (int) $this->params()->fromRoute('id', 0);

        if (!$id) {
            return $this->redirect()->toRoute('Message');
        }

        $request = $this->getRequest();

        if ($request->isPost()) {

            $del = $request->getPost('del', $this->translator->translate('Non'));

            if ($del == $this->translator->translate('Oui')) {
                $id = (int) $request->getPost('id');
                
                //flush cache
                $this->cache->getCacheService()->flush();
                
                $messageDao->deleteMessage($id);
            }

            // Redirect to list of messages
            return $this->redirect()->toRoute('Message');
        }

        $message = $messageDao->getMessage($id);

        return array(
            'id' => $id,
            'message' => $message
        );
    }

}
