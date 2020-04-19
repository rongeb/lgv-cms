<?php

namespace Backofficesearch\Controller;

use Rubrique\Model\RubriqueDao;
use Searchws\Model\Searchdao;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\JsonModel;
use Laminas\Mvc\I18n\Translator;
use Application\Factory\CacheDataListener;
use Laminas\View\Model\ViewModel;

/**
 * Class BackofficesearchController
 * @package Backofficesearch\Controller
 */
class BackofficesearchController extends AbstractActionController
{
    private $cache;
    private $translator;

    /**
     * BackofficesearchController constructor.
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
    public function searchAction()
    {
        /*return new ViewModel(array(
            'toto'=>'titi'
        ));*/
        return new ViewModel();
    }

    public function getmatchingpagesAction()
    {
        $request = $this->getRequest();
        if ($request->isPost()) {
            $words = $this->getParams($request);
            $searchDao = new Searchdao();
            $rubriqueDao = new RubriqueDao();
            $occurences = $searchDao->getAllPages($words, true);
        } else {
            $error = $this->translator->translate('Ce n\'est pas une requête POST');
            $this->response->setStatusCode(500);
            return new JsonModel(array(
                'error' => $error
            ));
        }
        return new JsonModel(array(
            'results' => $occurences
        ));
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
