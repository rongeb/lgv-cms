<?php
namespace Application\Controller;

use Application\Factory\CacheDataListener;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\Mvc\I18n\Translator;

/**
 * Class IndexController
 * @package Application\Controller
 */
class IndexController extends AbstractActionController
{

    private $cache;
    private $translator;

    /**
     * IndexController constructor.
     * @param CacheDataListener $cacheDataListener
     * @param Translator $translator
     */
    public function __construct(CacheDataListener $cacheDataListener, Translator $translator){
        $this->cache = $cacheDataListener;
        $this->translator = $translator;
    }

    /**
     * @return \Laminas\Http\Response
     */
    public function indexAction()
    {
        return $this->redirect()->toRoute('Sitepublic', array('action' => 'displaypublicpage'));
    }
}
