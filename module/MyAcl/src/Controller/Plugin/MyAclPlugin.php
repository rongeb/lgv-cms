<?php
namespace MyAcl\Controller\Plugin;
 
use Laminas\Mvc\Controller\Plugin\AbstractPlugin,
    Laminas\Session\Container as SessionContainer,
    Laminas\Permissions\Acl\Acl,
    Laminas\Permissions\Acl\Role\GenericRole as Role,
    Laminas\Permissions\Acl\Resource\GenericResource as Resource;

/**
 * Class MyAclPlugin
 * @package MyAcl\Controller\Plugin
 */
class MyAclPlugin extends AbstractPlugin
{
    protected $sesscontainer ;

    /**
     * @return SessionContainer
     */
    private function getSessContainer()
    {
        if (!$this->sesscontainer) {
            $this->sesscontainer = new SessionContainer('myacl');
        }
        return $this->sesscontainer;
    }

    /**
     * @param $e
     */
    public function doAuthorization($e)
    {
        // set ACL
        $acl = new Acl();
        $acl->deny(); // on by default
        //$acl->allow(); // this will allow every route by default so then you have to explicitly deny all routes that you want to protect.		
		
	# ROLES ############################################
        $acl->addRole(new Role('anonymous'));
        $acl->addRole(new Role('guest'),  'anonymous');
        $acl->addRole(new Role('user'),  'guest');
        $acl->addRole(new Role('admin'), 'user');
	# end ROLES ########################################
        
	# RESOURCES ########################################
        $acl->addResource('indexcontroller'); // Application module
        $acl->addResource('contenucontroller'); // Contenu module
        $acl->addResource('fichierscontroller'); // Fichiers module
        $acl->addResource('galeriecontroller'); // Galerie module
        $acl->addResource('logincontroller'); // Login module
        $acl->addResource('loginmgmtcontroller'); // Loginmgmt module
        $acl->addResource('rubriquecontroller'); // Rubrique module
        $acl->addResource('sitepubliccontroller'); // Sitepublic module
        $acl->addResource('blogcontentcontroller'); // back blog module
        $acl->addResource('sousrubriquecontroller'); // Sousrubrique module
        $acl->addResource('messagecontroller'); // message module
        $acl->addResource('commentairecontroller'); // commentaire module
        $acl->addResource('blogrestcontroller'); // blogrest module
        $acl->addResource('linktocontenucontroller'); // linktocontenu module
        $acl->addResource('pagearrangementcontroller'); // pagearrangement module
        $acl->addResource('privatespacecontroller'); // privatespace module
        $acl->addResource('privatespacelogincontroller'); // privatespacelogin module
        $acl->addResource('siteprivatecontroller'); // siteprivate module
        $acl->addResource('pagewscontroller'); // pagews module
        $acl->addResource('searchwscontroller'); // searchws module
        $acl->addResource('mapcontentcontroller'); // mapcontent module
        //$acl->addResource('mobilewscontroller'); // authentication and upload ws
        $acl->addResource('uploadmgmtcontroller'); // uploadmgmt module
        $acl->addResource('publishingcontroller'); // publishing module
        $acl->addResource('backofficesearchcontroller'); // backofficesearch module
        $acl->addResource('htmltemplatecontroller'); // htmltemplate module
	# end RESOURCES ########################################
		
	################ PERMISSIONS #######################
		
        // Application -------------------------->
        $acl->allow('anonymous', 'indexcontroller', NULL);
       
        // Contenu -------------------------->
        $acl->allow('user', 'contenucontroller', NULL);
        
        // Fichiers -------------------------->
        $acl->allow('user', 'fichierscontroller', NULL);
        
        // Galerie -------------------------->
        $acl->allow('user', 'galeriecontroller', NULL);
        
        // Login -------------------------->
        $acl->allow('anonymous', 'logincontroller', NULL);
	
        // Rubrique -------------------------->
        $acl->allow('user', 'rubriquecontroller', NULL);
        
        // Loginmgmt -------------------------->
        $acl->allow('admin', 'loginmgmtcontroller', NULL);
        
        // Sitepublic (Front)-------------------------->
        $acl->allow('anonymous', 'sitepubliccontroller', NULL);

         // Blog (Restful)-------------------------->
        $acl->allow('anonymous', 'blogrestcontroller', NULL);
        
        // BlogContent (Back)-------------------------->
        $acl->allow('user', 'blogcontentcontroller', NULL);
        
        // Sousrubrique -------------------------->
        $acl->allow('user', 'sousrubriquecontroller', NULL);
        
        // Message -------------------------->
        $acl->allow('user', 'messagecontroller', NULL);
        
        // Commentaire -------------------------->
        $acl->allow('user', 'commentairecontroller', NULL);
        
        // Linktocontenu -------------------------->
        $acl->allow('user', 'linktocontenucontroller', NULL);
	
        // Pagearrangement -------------------------->
        $acl->allow('user', 'pagearrangementcontroller', NULL);
		
        // Privatespace -------------------------->
        $acl->allow('user', 'privatespacecontroller', NULL);
        
       // Privatespaceloginmgmt -------------------------->
        $acl->allow('user', 'privatespacelogincontroller', NULL);
        
        // pagews -------------------------->
        $acl->allow('anonymous', 'pagewscontroller', array('getallpagesbyspaceid', 'getpagearrangementbypagename', 'getpagearrangementbypageid'));
        $acl->allow('user', 'pagewscontroller', array('getallpages'));

        // searchws -------------------------->
        //$acl->allow('anonymous', 'searchwscontroller', array('getpublicpages', 'getprivatepages', 'getallpages'));
        $acl->allow('anonymous', 'searchwscontroller', 'getpublicpages');
        $acl->allow('guest', 'searchwscontroller', 'getprivatepages');
        $acl->allow('anonymous', 'searchwscontroller', 'getallpages');

        // mobilews -------------------------->
        //$acl->allow('anonymous', 'mobilewscontroller', NULL);

        // uploadmgmtcontroller -------------------------->
        $acl->allow('guest', 'uploadmgmtcontroller', NULL);

        // Mapcontent -------------------------->
        $acl->allow('user', 'mapcontentcontroller', NULL);
        
        // siteprivate -------------------------->
        $acl->allow('anonymous', 'siteprivatecontroller', array('index','auth','registration','forgottenpassword', 'changepassword','displayregistrationstate'));
	    $acl->allow('guest', 'siteprivatecontroller', array('updatecontactinformation','changepassword','displayprivatepage','logout','addcommentajax','contactajax'));

        // publishing -------------------------->
        $acl->allow('admin', 'publishingcontroller', NULL);

        // backoffice search -------------------------->
        $acl->allow('user', 'backofficesearchcontroller', NULL);

        // backoffice search -------------------------->
        $acl->allow('user', 'htmltemplatecontroller', NULL);
	
		################ end PERMISSIONS #####################
		
	$role = (! $this->getSessContainer()->role ) ? 'anonymous' : $this->getSessContainer()->role;
		$routeMatch = $e->getRouteMatch();
		
        $actionName = strtolower($routeMatch->getParam('action', 'not-found'));	// get the action name	
        $controllerName = $routeMatch->getParam('controller', 'not-found');	// get the controller name	
        $controllerName2 = strtolower(array_pop(explode('\\', $controllerName)));

		//print '$controllerName: '.$controllerName.'<br>';
		//print '$action: '.$actionName.'<br>';

		
		#################### Check Access ########################
                //var_dump($moduleName);
                //var_dump($controllerName2);
                //var_dump($actionName);
                //var_dump($role);
                //var_dump($acl->isAllowed($role, $controllerName2, $actionName));
                //exit;
        //It Doesn't check module's name, it means that the controller name has to be unique in the project
        //For this cms, the controller name is the module's name + Action suffix
        if ( !$acl->isAllowed($role, $controllerName2, $actionName)){
            $router = $e->getRouter();
            $url    = $router->assemble(array(), array('name' => 'Login'));
            $response = $e->getResponse();
            $response->setStatusCode(302);
            // redirect to login page or other page.
            $response->getHeaders()->addHeaderLine('Location', $url);
            $e->stopPropagation();            
        }	
    }
}
