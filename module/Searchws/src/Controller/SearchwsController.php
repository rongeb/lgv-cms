<?php

namespace Searchws\Controller;

use Searchws\Model\Searchdao;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\JsonModel;
use ExtLib\MCrypt;
use Application\Factory\CacheDataListener;
use Laminas\Mvc\I18n\Translator;

/**
 * Class SearchwsController
 * @package Searchws\Controller
 */
class SearchwsController extends AbstractActionController
{

    private $cache;
    private $translator;

    /**
     * SearchwsController constructor.
     * @param CacheDataListener $cacheDataListener
     * @param Translator $translator
     */
    public function __construct(CacheDataListener $cacheDataListener, Translator $translator)
    {
        $this->cache = $cacheDataListener;
        $this->translator = $translator;
    }

    /**
     * Content-Type accepted :
     * application/json and x-www-form-urlencoded
     * @return JsonModel
     */
    public function getpublicpagesAction()
    {
        $request = $this->getRequest();
        if ($request->isPost()) {
            $words = $this->getParams($request);
            $searchDao = new Searchdao();
            $occurences = $searchDao->getPublicPages($words);
            return new JsonModel(array(
                'results' => $occurences
            ));
        } else {
            $error = $this->translator->translate('Ce n\'est pas une requête POST');
            $this->response->setStatusCode(500);
            return new JsonModel(array(
                'error' => $error
            ));
        }
    }

    /**
     * Content-Type accepted :
     * application/json and x-www-form-urlencoded
     * @return JsonModel
     */
    public function getallpagesAction()
    {
        $request = $this->getRequest();
        if ($request->isPost()) {
            $words = $this->getParams($request);
            $searchDao = new Searchdao();
            $occurences = $searchDao->getAllPages($words, false);
            return new JsonModel(array(
                'results' => $occurences
            ));
        } else {
            $error = $this->translator->translate('Ce n\'est pas une requête POST');
            $this->response->setStatusCode(500);
            return new JsonModel(array(
                'error' => $error
            ));
        }
    }

    // TODO test line 67 to 69
    /**
     * Content-Type accepted :
     * application/json and x-www-form-urlencoded
     * @return JsonModel
     */
    public function getprivatepagesAction()
    {
        $request = $this->getRequest();
        if ($request->isPost()) {
            $loginaccess = new \Laminas\Session\Container('myacl');
            $mcrypt = new MCrypt();
            $sessionData = json_decode($mcrypt->decrypt($loginaccess->userdata));
            $words = $this->getParams($request);
            $searchDao = new Searchdao();
            $occurences = $searchDao->getPrivatePages($words, $sessionData->spaceId);

            return new JsonModel(array(
                'results' => $occurences
            ));
        } else {
            $error = $this->translator->translate('Ce n\'est pas une requête POST');
            $this->response->setStatusCode(500);
            return new JsonModel(array(
                'error' => $error
            ));
        }
    }

    /**
     * @param $request
     * @return string
     */
    private function getParams($request)
    {
        $headers = $request->getHeaders();
        $accept = $headers->get('Content-Type');
        $params = "";
        $isJson = $accept->match('application/json');
        // $isUrlencoded = $accept->match('application/x-www-form-urlencoded');
        if ($isJson) {
            $content = $request->getContent();
            $content = str_replace("'", "\"", $content);
            $jsonDecode = json_decode($content, true);
            $params = $jsonDecode['search'];
        } else {
            $params = $request->getPost('search');
        }

        return $params;
    }
}
