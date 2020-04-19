<?php

namespace Publishing\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Rubrique\Model\RubriqueDao;
use Application\Factory\CacheDataListener;
use Laminas\Mvc\I18n\Translator;
use ExtLib\Utils;

/**
 * Class PublishingController
 * @package Publishing\Controller
 */
class PublishingController extends AbstractActionController
{
    private $cache;
    private $translator;
    private $sitepublicViewsPath;
    private $siteprivateViewsPath;

    /**
     * PublishingController constructor.
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
        $rubriqueDao = new RubriqueDao();

        return new ViewModel(array(
            'rubriques' => $rubriqueDao->getAllRubriques("object")
        ));
    }

    /**
     * @return array|\Laminas\Http\Response
     */
    public function publishAction()
    {
        $rubriqueDao = new RubriqueDao();

        $id = (int)$this->params()->fromRoute('id', 0);

        /*        if (!empty($id)) {
                    if (empty($rubriqueId)) {
                        //return $this->getResponse()->setStatusCode(404);
                        return $this->notFoundAction();
                    }
                }*/

        $request = $this->getRequest();


        if ($id != 0) {

            $utils = new Utils();
            $rubrique = $rubriqueDao->getRubrique($id);
            if ((int)$rubrique->getPublishing() === 0) {
                $rubrique->setPublishing(1);
            } else {
                $rubrique->setPublishing(0);
            }

            $rubriqueDao->saveRubrique($rubrique);

            //flush cache
            $this->cache->getCacheService()->flush();
            //var_dump($rubrique);
            //exit;
            // Redirect to list of rubriques
            return $this->redirect()->toRoute('publishing', array('action' => 'index'));
        } else {

            return array(
                'id' => $id,
                'error' => $this->translator->translate('un paramètre n\'est pas correct'));
        }


        return array(
            'id' => $id,
            'error' => ''
        );
    }
}
