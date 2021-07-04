<?php

namespace Linktocontenu\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Laminas\View\Model\JsonModel;
//use Laminas\Validator\File\Size;
//use Laminas\Validator\File\Extension;
use Linktocontenu\Model\Linktocontenu;
use Linktocontenu\Model\LinktocontenuType;
use Linktocontenu\Form\LinktocontenuForm;
use Linktocontenu\Form\LinktocontenuInputFilter;
use Linktocontenu\Model\LinktocontenuDao;
use Sousrubrique\Model\Sousrubriquedao;
use Rubrique\Model\RubriqueDao;
use Contenu\Model\ContenuDao;
use Contenu\Model\ContenuType;
use Fichiers\Model\Fichiersdao;
use ExtLib\Utils;
use Application\Factory\CacheKeys;
use Application\Factory\CacheDataListener;
use Laminas\Mvc\I18n\Translator;

/**
 * Class LinktocontenuController
 * @package Linktocontenu\Controller
 */
class LinktocontenuController extends AbstractActionController {

    private $cache;
    private $translator;

    /**
     * LinktocontenuController constructor.
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

        $linktocontenuDao = new LinktocontenuDao();
        //print_r($contenuDao->getAllContenus("object"));
        return new ViewModel(array(
            'linktocontenus' => $linktocontenuDao->getAllLinktocontenus("object")
        ));
    }

    /**
     * @return array|\Laminas\Http\Response
     */
    public function addAction() {

        $form = new LinktocontenuForm();
        // $this->translator=$this->getServiceLocator()->get('translator');
        $form->get('submitbutton')->setAttribute('value', $this->translator->translate('Ajouter'));
        $linktocontenuDao = new LinktocontenuDao();
        $sousrubriqueDao = new Sousrubriquedao();
        $fichiersdao = new Fichiersdao();
        $contenuDao = new ContenuDao();
        
        $request = $this->getRequest();

        $allFichiers = array();

        //get cache
        // $cache = $this->getServiceLocator()->get('CacheDataListener');
        $result = $this->cache->getCacheDataItem(CacheKeys::$CacheKeyFichiersAll);
        
        //if there's no cache for files
        if(!$result){
            $allFichiers = $fichiersdao->getAllFichiers("object");
            $this->cache->setCacheDataItem(CacheKeys::$CacheKeyFichiersAll, array('fichiers'=>$allFichiers));
        }
        else{
            $allFichiers = $result['fichiers'];
        }
        
        if ($request->isPost()) {
            //trigger data controls
            $linktocontenu = new Linktocontenu();
            $form->setInputFilter(new LinktocontenuInputFilter());
            $form->setData($request->getPost());
            //$form->setUseInputFilterDefaults(false);
            
            if ($form->isValid()) {
                $filterData = new Utils();
                
                //sousrubriquesList
                $section = $sousrubriqueDao->getSousrubrique($filterData->stripTags_replaceHtmlChar_trim((int)$request->getPost('sousrubriquesList'),true,false,true));
                $linktocontenu->setSousrubrique($section);                //contenusList
                
                $contenu = $contenuDao->getContenu($filterData->stripTags_replaceHtmlChar_trim((int)$request->getPost('contenusList'),true,false,true));
                $linktocontenu->setContenu($contenu);
                
                //titre
                $linktocontenu->setTitre($filterData->stripTags_replaceHtmlChar_trim($request->getPost('titre'),false,false,true));
                
                //soustitre
                $linktocontenu->setSousTitre($filterData->stripTags_replaceHtmlChar_trim($request->getPost('soustitre'),false,false,true));
                
                //html
                $linktocontenu->setContenuHtml($request->getPost('html'));
                
                //imagepath
                $linktocontenu->setImage($filterData->stripTags_replaceHtmlChar_trim($request->getPost('imagepath'),true,false,true));
                
                //imagepath2
                $linktocontenu->setImage2($filterData->stripTags_replaceHtmlChar_trim($request->getPost('imagepath2'), true, false, true));
             
                //rubriqueswhereislinkList
                $linktocontenu->setLinktopage($request->getPost('rubriqueswhereislinkList'));
                
                //type
                $linktocontenu->setType(ContenuType::$linkItem);
                
                //if no rank has been set, it takes the rank of the content
                $position = $request->getPost('position');
                if(!empty($position)){
                    $linktocontenu->setRang((int)$position);
                }
                else{
                    $linktocontenu->setRang(-1);
                }
                //sousrubriqueswhereislinkList
                $section = $sousrubriqueDao->getSousrubrique($request->getPost('sousrubriqueswhereislinkList'));
                $linktocontenu->setLinktosection($section);
                
                $linktocontenuDao->saveLinktocontenu($linktocontenu);
                //flush cache
                $this->cache->getCacheService()->flush();
                
                return $this->redirect()->toRoute('Linktocontenu');
            }
            else{
                
                return array(
                    'form' => $form,
                    'fichiers' => $allFichiers,
                    'error' => $form->getMessages());
            }
            
        }
        
        return array(
            'form' => $form,
            'fichiers' => $allFichiers,
            'error' => "no error");
    }

    /**
     * @return array
     */
    public function editAction() {

        $form = new LinktocontenuForm();
        // $this->translator=$this->getServiceLocator()->get('translator');
        $form->get('submitbutton')->setAttribute('value', $this->translator->translate('Ajouter'));
        $linktocontenuDao = new LinktocontenuDao();
        $sousrubriqueDao = new Sousrubriquedao();
        $fichiersdao = new Fichiersdao();
        $contenuDao = new ContenuDao();
        $linktocontenu = new Linktocontenu();

        $allFichiers = array();

        //get cache
        // $cache = $this->getServiceLocator()->get('CacheDataListener');
        $result = $this->cache->getCacheDataItem(CacheKeys::$CacheKeyFichiersAll);

        //if there's no cache for files
        if(!$result){
            $allFichiers = $fichiersdao->getAllFichiers("object");
            $this->cache->setCacheDataItem(CacheKeys::$CacheKeyFichiersAll, array('fichiers'=>$allFichiers));
        }
        else{
            $allFichiers = $result['fichiers'];
        }
        
        $request = $this->getRequest();
        
        if ($request->isPost()) {
            //trigger data controls
            
            $form->setInputFilter(new LinktocontenuInputFilter());
            $form->setData($request->getPost());
            //$form->setUseInputFilterDefaults(false);
            
            if ($form->isValid()) {
                $filterData = new Utils();
                
                //id
                $linktocontenu->setId((int)$request->getPost('id'));
                
                //sousrubriquesList
                $section = $sousrubriqueDao->getSousrubrique($filterData->stripTags_replaceHtmlChar_trim((int)$request->getPost('sousrubriquesList'),true,false,true));
                $linktocontenu->setSousrubrique($section);                //contenusList
                
                $contenu = $contenuDao->getContenu($filterData->stripTags_replaceHtmlChar_trim((int)$request->getPost('contenusList'),true,false,true));
                $linktocontenu->setContenu($contenu);
                
                //titre
                $linktocontenu->setTitre($filterData->stripTags_replaceHtmlChar_trim($request->getPost('titre'),false,false,true));
                
                //soustitre
                $linktocontenu->setSousTitre($filterData->stripTags_replaceHtmlChar_trim($request->getPost('soustitre'),false,false,true));
                
                //html
                $linktocontenu->setContenuHtml($request->getPost('html'));
                
                //imagepath
                $linktocontenu->setImage($filterData->stripTags_replaceHtmlChar_trim($request->getPost('imagepath'),true,false,true));
                
                //imagepath2
                $linktocontenu->setImage2($filterData->stripTags_replaceHtmlChar_trim($request->getPost('imagepath2'), true, false, true));
                
                //rubriqueswhereislinkList
                $linktocontenu->setLinktopage($request->getPost('rubriqueswhereislinkList'));
               
                //type
                //$linktocontenu->setType(ContenuType::$linkItem);
                
                //si pas de rang prendre le rang du contenu à lier
                //position
                $position = $request->getPost('position');
                if(!empty($position)){
                    $linktocontenu->setRang((int)$position);
                }
                else{
                    $linktocontenu->setRang(-1);
                }
                //sousrubriqueswhereislinkList
                $section = $sousrubriqueDao->getSousrubrique($request->getPost('sousrubriqueswhereislinkList'));
                $linktocontenu->setLinktosection($section);
                
                $linktocontenuDao->saveLinktocontenu($linktocontenu);
              
                //flush cache
                $this->cache->getCacheService()->flush();
                
                return $this->redirect()->toRoute('Linktocontenu');
            }
            else{
                
                return array(
                    'form' => $form,
                    'fichiers' => $allFichiers,
                    'error' => $form->getMessages());
            }
            
        }
        
        $allFichiers = array();
        
        $form = new LinktocontenuForm();
        
        $id = (int) $this->params()->fromRoute('id', 0);
        //print_r($id);
        if (!$id) {
            return $this->redirect()->toRoute('Linktocontenu', array(
                        'action' => 'add'
            ));
        }
        
        $linktocontenu = $linktocontenuDao->getLinktocontenu($id);
        $sectionsinselect1 = array();
        $sections = $sousrubriqueDao->getSousrubriquesByRubrique($linktocontenu->getSousrubrique()->getRubrique()->getId(), 'array');
        
        foreach ($sections as $value){
            $sectionsinselect1[$value['id']] = $value['libelle'];
        }
        
        $contentsinselect1 = array();
        $contents = $contenuDao->getContenusBySousrubrique($linktocontenu->getSousrubrique()->getId(), 'array');
        
        foreach ($contents as $value){
            $contentsinselect1[$value['contenu_id']] = $value['titre'];
        }
        
        $sectionsinselect2 = array();
        $sections = $sousrubriqueDao->getSousrubriquesByRubrique($linktocontenu->getLinktosection()->getRubrique()->getId(), 'array');
        
        foreach ($sections as $value){
            $sectionsinselect2[$value['id']] = $value['libelle'];
        }
        
        $form->get('rubriquesList')->setAttribute('value', $linktocontenu->getSousrubrique()->getRubrique()->getId());
        
        //fill select
        $form->get('sousrubriquesList')->setValueOptions($sectionsinselect1);
        $form->get('sousrubriquesList')->setAttribute('value', $linktocontenu->getSousrubrique()->getId());
        
        //fill select
        $form->get('contenusList')->setValueOptions($contentsinselect1);
        $form->get('contenusList')->setAttribute('value', $linktocontenu->getContenu()->getId());
        
        $form->get('id')->setAttribute('value', $linktocontenu->getId());
        $form->get('titre')->setAttribute('value', $linktocontenu->getTitre());
        $form->get('soustitre')->setAttribute('value', $linktocontenu->getSousTitre());
        $form->get('position')->setAttribute('value', $linktocontenu->getRang());
        $form->get('html')->setAttribute('value', $linktocontenu->getContenuHtml());
        $form->get('imagepath')->setAttribute('value', $linktocontenu->getImage());
        $form->get('imagepath2')->setAttribute('value', $linktocontenu->getImage2());
        $form->get('rubriqueswhereislinkList')->setAttribute('value', $linktocontenu->getLinktosection()->getRubrique()->getId());
        
        //fill select
        $form->get('sousrubriqueswhereislinkList')->setValueOptions($sectionsinselect2);
        $form->get('sousrubriqueswhereislinkList')->setAttribute('value', $linktocontenu->getLinktosection()->getId());
        
        // $this->translator=$this->getServiceLocator()->get('translator');
        $form->get('submitbutton')->setAttribute('value', $this->translator->translate('Ajouter'));
        
        //get cache
        // $cache = $this->getServiceLocator()->get('CacheDataListener');
        $result = $this->cache->getCacheDataItem(CacheKeys::$CacheKeyFichiersAll);
        
        //if there's no cache for files
        if(!$result){
            $allFichiers = $fichiersdao->getAllFichiers("object");
            $this->cache->setCacheDataItem(CacheKeys::$CacheKeyFichiersAll, array('fichiers'=>$allFichiers));
        }
        else{
            $allFichiers = $result['fichiers'];
        }
        
        
        
        return array(
            'form' => $form,
            'fichiers' => $allFichiers,
            'error' => "no error");
    }


    /**
     * @return JsonModel
     */
    public function contenuajaxAction() {

        $request = $this->getRequest();

        if ($request->isPost()) {
            
            $section_id = $request->getPost('subrubid');
            
            $contenuDao = new ContenuDao();

            $result = $contenuDao->getContenusBySousrubrique($section_id, 'array');
            
            return new JsonModel(array(
                'contenusList' => $result
            ));
        }
    }

    /**
     * @return array|\Laminas\Http\Response
     */
    public function deleteAction() {

        $linktocontenuDao = new LinktocontenuDao();
        // $this->translator=$this->getServiceLocator()->get('translator');
        
        $id = (int) $this->params()->fromRoute('id', 0);

        if (!$id) {
            return $this->redirect()->toRoute('Linktocontenu');
        }

        $request = $this->getRequest();

        if ($request->isPost()) {

            $del = $request->getPost('del', $this->translator->translate('Non'));

            if ($del == $this->translator->translate('Oui')) {
                $id = (int) $request->getPost('id');
                
                //flush cache
                $this->cache->getCacheService()->flush();
                
                $linktocontenuDao->deleteLinktocontenu($id);
            }

            // Redirect to list of contenus
            return $this->redirect()->toRoute('Linktocontenu');
        }

        $linktocontenu = $linktocontenuDao->getLinktocontenu($id);

        return array(
            'id' => $id,
            'linktocontenu' => $linktocontenu
        );
    }
    

}
