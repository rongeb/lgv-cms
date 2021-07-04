<?php

namespace Linktocontenu\Model;

use Sousrubrique\Model\Sousrubriquedao;
use Application\DBConnection\ParentDao;
use Contenu\Model\ContenuDao;
use Rubrique\Model\RubriqueDao;
use Linktocontenu\Model\Linktocontenu;
use Linktocontenu\Model\LinktocontenuType;
use Linktocontenu\Model\Mapper\LinktocontenuMapper;

/**
 * Class LinktocontenuDao
 * @package Linktocontenu\Model
 */
class LinktocontenuDao extends ParentDao {

    /**
     * LinktocontenuDao constructor.
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * @param $dataType : array|object
     * @return array|array of Linktocontenu
     */
    public function getAllLinktocontenus($dataType) {

        $count = 0;
        $sousrubriqueDao = new Sousrubriquedao();
        $contenuDao = new ContenuDao();

        $requete = $this->dbGateway->prepare("
		SELECT c.linktocontenu_id, c.contenu_id, c.rang, c.titre, c.soustitre, c.sousrubriques_id,
                c.contenuhtml, c.image, c.image2, c.type, c.linktosousrubrique_id, c.linktorubrique_id,c.contenu_date
		FROM linktocontenu c
                JOIN sousrubrique sr on sr.id=c.sousrubriques_id
                JOIN rubrique r on r.id=sr.rubriques_id
                ORDER BY r.rang
		")or die(print_r($this->dbGateway->error_info()));

        $requete->execute();

        $requete2 = $requete->fetchAll(\PDO::FETCH_ASSOC);

        if (strcasecmp($dataType, "object") == 0) {
            //Put result in an array of objects
            $arrayOfContenustep1 = array();
            $arrayOfContenustep2 = array();
            $linkedContentMapper = new LinktocontenuMapper();
            if (is_array($requete2)) {
                foreach ($requete2 as $key => $value) {
                    //print_r($value);
                    //put code to define an array of objects
                    if ($value['sousrubriques_id'] != null && $value['sousrubriques_id'] != "") {

                        $sousrubrique = $sousrubriqueDao->getSousrubrique($value['sousrubriques_id']);
                        //$rubrique = $rubriqueDao->getRubrique($sousrubrique->getRubrique()->getId());
                        $contenu = $contenuDao->getContenuRelatedToLinkToContenu($value['contenu_id']);

                        $linktosousrubrique = $sousrubriqueDao->getSousrubrique($value['linktosousrubrique_id']);
                        //$linktorubrique = $rubriqueDao->getRubrique($value['linktorubrique_id']);

                        $arrayOfContenustep1[$count]['id'] = $value['linktocontenu_id'];
                        //Content that is linked to a new rubrique
                        $arrayOfContenustep1[$count]['contenuobj'] = $contenu;
                        //You can override the rank set for the content
                        $arrayOfContenustep1[$count]['position'] = $value['rang'];
                        $arrayOfContenustep1[$count]['title'] = $value['titre'];
                        $arrayOfContenustep1[$count]['subtitle'] = $value['soustitre'];

                        //SousRubrique data of the content 
                        $arrayOfContenustep1[$count]['section'] = $sousrubrique;
                        $arrayOfContenustep1[$count]['html'] = $value['contenuhtml'];
                        $arrayOfContenustep1[$count]['image'] = $value['image'];
                        $arrayOfContenustep1[$count]['image2'] = $value['image2'];
                        
                        $arrayOfContenustep1[$count]['type'] = $value['type'];
                        
                        $arrayOfContenustep1[$count]['linktopage'] = $value['linktorubrique_id'];

                        //id of the section that have the content link
                        $arrayOfContenustep1[$count]['linktosection'] = $linktosousrubrique;

                        $arrayOfContenustep2[$count] = $linkedContentMapper->exchangeArray($arrayOfContenustep1[$count]);

                        $count++;
                    }
                }
            }

            return $arrayOfContenustep2;
        } elseif (strcasecmp($dataType, "array") == 0) {
            return $requete2;
        }
    }

    /**
     * @param $dataType : array|object
     * @return array|array of Linktocontenu
     */
    public function getAllLinktocontenusBySousrubrique($sectionId ,$dataType) {

        $count = 0;
        $sousrubriqueDao = new Sousrubriquedao();
        $contenuDao = new ContenuDao();

        $requete = $this->dbGateway->prepare("
		SELECT c.linktocontenu_id, c.contenu_id, c.rang, c.titre, c.soustitre, c.sousrubriques_id,
                c.contenuhtml, c.image, c.image2,  c.type, c.linktosousrubrique_id,c.linktorubrique_id,c.contenu_date
		FROM linktocontenu c
                JOIN sousrubrique sr on sr.id=c.sousrubriques_id
                JOIN rubrique r on r.id=sr.rubriques_id
                WHERE sr.id = :srid
                ORDER BY r.rang
		")or die(print_r($this->dbGateway->error_info()));

        $requete->execute(array(
            "srid" => $sectionId
        ));

        $requete2 = $requete->fetchAll(\PDO::FETCH_ASSOC);

        if (strcasecmp($dataType, "object") == 0) {
            //Put result in an array of objects
            $arrayOfContenustep1 = array();
            $arrayOfContenustep2 = array();
            $linkedContentMapper = new LinktocontenuMapper();
            if (is_array($requete2)) {
                foreach ($requete2 as $key => $value) {
                    //print_r($value);
                    //put code to define an array of objects
                    if ($value['sousrubriques_id'] != null && $value['sousrubriques_id'] != "") {

                        $sousrubrique = $sousrubriqueDao->getSousrubrique($value['sousrubriques_id']);
                        //$rubrique = $rubriqueDao->getRubrique($sousrubrique->getRubrique()->getId());
                        $contenu = $contenuDao->getContenuRelatedToLinkToContenu($value['contenu_id']);

                        $linktosousrubrique = $sousrubriqueDao->getSousrubrique($value['linktosousrubrique_id']);
                        //$linktorubrique = $rubriqueDao->getRubrique($value['linktorubrique_id']);

                        $arrayOfContenustep1[$count]['id'] = $value['linktocontenu_id'];
                        //Content that is linked to a new rubrique
                        $arrayOfContenustep1[$count]['contenuobj'] = $contenu;
                        //You can override the rank set for the content
                        $arrayOfContenustep1[$count]['position'] = $value['rang'];
                        $arrayOfContenustep1[$count]['title'] = $value['titre'];
                        $arrayOfContenustep1[$count]['subtitle'] = $value['soustitre'];

                        //SousRubrique data of the content 
                        $arrayOfContenustep1[$count]['section'] = $sousrubrique;
                        $arrayOfContenustep1[$count]['html'] = $value['contenuhtml'];
                        $arrayOfContenustep1[$count]['image'] = $value['image'];
                        $arrayOfContenustep1[$count]['image2'] = $value['image2'];
                        
                        $arrayOfContenustep1[$count]['type'] = $value['type'];
                        /*$arrayOfContenustep1[$count]['author'] = null;
                        $arrayOfContenustep1[$count]['themes'] = null;
                        $arrayOfContenustep1[$count]['blogdate'] = null;
                        $arrayOfContenustep1[$count]['text1'] = null;
                        $arrayOfContenustep1[$count]['text2'] = null;
                        $arrayOfContenustep1[$count]['text3'] = null;
                        $arrayOfContenustep1[$count]['gps_coordinates'] = null;*/

                        $arrayOfContenustep1[$count]['linktopage'] = $value['linktorubrique_id'];

                        //id of the section that have the content link
                        $arrayOfContenustep1[$count]['linktosection'] = $linktosousrubrique;

                        $arrayOfContenustep2[$count] = $linkedContentMapper->exchangeArray($arrayOfContenustep1[$count]);

                        $count++;
                    }
                }
            }

            return $arrayOfContenustep2;
        } elseif (strcasecmp($dataType, "array") == 0) {
            return $requete2;
        }
    }

    /**
     * @param $dataType : array|object
     * @return array|array of Linktocontenu
     */
    public function getAllLinktocontenusByRubrique($pageId ,$dataType) {

        $count = 0;
        $sousrubriqueDao = new Sousrubriquedao();
        $contenuDao = new ContenuDao();

        $requete = $this->dbGateway->prepare("
		SELECT c.linktocontenu_id, c.contenu_id, c.rang, c.titre, c.soustitre, c.sousrubriques_id,
                c.contenuhtml, c.image, c.image2,  c.type, c.linktosousrubrique_id,c.linktorubrique_id,c.contenu_date
		FROM linktocontenu c
                JOIN sousrubrique sr on sr.id=c.sousrubriques_id
                JOIN rubrique r on r.id=sr.rubriques_id
                WHERE c.linktorubrique_id = :page_id
                ORDER BY r.rang
		")or die(print_r($this->dbGateway->error_info()));

        $requete->execute(array(
            "page_id" => $pageId
        ));

        $requete2 = $requete->fetchAll(\PDO::FETCH_ASSOC);

        if (strcasecmp($dataType, "object") == 0) {
            //Put result in an array of objects
            $arrayOfContenustep1 = array();
            $arrayOfContenustep2 = array();
            $linkedContentMapper = new LinktocontenuMapper();
            if (is_array($requete2)) {
                foreach ($requete2 as $key => $value) {
                    //print_r($value);
                    //put code to define an array of objects
                    if ($value['sousrubriques_id'] != null && $value['sousrubriques_id'] != "") {

                        $sousrubrique = $sousrubriqueDao->getSousrubrique($value['sousrubriques_id']);
                        //$rubrique = $rubriqueDao->getRubrique($sousrubrique->getRubrique()->getId());
                        $contenu = $contenuDao->getContenuRelatedToLinkToContenu($value['contenu_id']);

                        $linktosousrubrique = $sousrubriqueDao->getSousrubrique($value['linktosousrubrique_id']);
                        //$linktorubrique = $rubriqueDao->getRubrique($value['linktorubrique_id']);

                        $arrayOfContenustep1[$count]['id'] = $value['linktocontenu_id'];
                        //Content that is linked to a new rubrique
                        $arrayOfContenustep1[$count]['contenuobj'] = $contenu;
                        //You can override the rank set for the content
                        $arrayOfContenustep1[$count]['position'] = $value['rang'];
                        $arrayOfContenustep1[$count]['title'] = $value['titre'];
                        $arrayOfContenustep1[$count]['subtitle'] = $value['soustitre'];

                        //SousRubrique data of the content 
                        $arrayOfContenustep1[$count]['section'] = $sousrubrique;
                        $arrayOfContenustep1[$count]['html'] = $value['contenuhtml'];
                        $arrayOfContenustep1[$count]['image'] = $value['image'];
                        $arrayOfContenustep1[$count]['image2'] = $value['image2'];
                        
                        $arrayOfContenustep1[$count]['type'] = $value['type'];
                        
                        $arrayOfContenustep1[$count]['linktopage'] = $value['linktorubrique_id'];

                        //id of the section that have the content link
                        $arrayOfContenustep1[$count]['linktosection'] = $linktosousrubrique;

                        $arrayOfContenustep2[$count] = $linkedContentMapper->exchangeArray($arrayOfContenustep1[$count]);

                        $count++;
                    }
                }
            }

            return $arrayOfContenustep2;
        } elseif (strcasecmp($dataType, "array") == 0) {
            return $requete2;
        }
    }


    /**
     * @param $id
     * @return \Linktocontenu\Model\Linktocontenu
     */
    public function getLinktocontenu($id) {

        $id = (int) $id;
        $result = array();

        $sousrubriqueDao = new Sousrubriquedao();
        $contenuDao = new ContenuDao();
        $linkedContentMapper = new LinktocontenuMapper();

        $contenustep1 = array();

        $requete = $this->dbGateway->prepare("
		SELECT c.linktocontenu_id, c.contenu_id, c.rang, c.titre, c.soustitre, c.sousrubriques_id,
                c.contenuhtml, c.image, c.image2,  c.type, c.linktosousrubrique_id,c.linktorubrique_id,c.contenu_date
		FROM linktocontenu c
                WHERE c.linktocontenu_id = :id
                ")or die(print_r($this->dbGateway->error_info()));

        $requete->execute(array(
            'id' => $id
        ));

        $value = $requete->fetch(\PDO::FETCH_ASSOC);

        $sousrubrique = $sousrubriqueDao->getSousrubrique($value['sousrubriques_id']);
        $contenu = $contenuDao->getContenuRelatedToLinkToContenu($value['contenu_id']);
        $linktosousrubrique = $sousrubriqueDao->getSousrubrique($value['linktosousrubrique_id']);
        
        $contenustep1['id'] = $value['linktocontenu_id'];
        //Content that is linked to a new rubrique
        $contenustep1['contenuobj'] = $contenu;
        //You can override the rank set for the content
        $contenustep1['position'] = $value['rang'];
        $contenustep1['title'] = $value['titre'];
        $contenustep1['subtitle'] = $value['soustitre'];

        //SousRubrique data of the content 
        $contenustep1['section'] = $sousrubrique;
        $contenustep1['html'] = $value['contenuhtml'];
        $contenustep1['image'] = $value['image'];
        $contenustep1['image2'] = $value['image2'];
        
        $contenustep1['type'] = $value['type'];
        
        $contenustep1['linktopage'] = $value['linktorubrique_id'];

        //id of the section that have the content link
        $contenustep1['linktosection'] = $linktosousrubrique;

        $linktocontenu = $linkedContentMapper->exchangeArray($contenustep1);

        return $linktocontenu;
    }

    /**
     * @param \Linktocontenu\Model\Linktocontenu $linktocontenu
     */
    public function saveLinktocontenu(Linktocontenu $linktocontenu) {

        $id = (int) $linktocontenu->getId();

        if ($id > 0) {
            
           // var_dump($linktocontenu);
           /*var_dump(array(
                "contenu_id" => $linktocontenu->getContenu()->getId(),
                "rang" => $linktocontenu->getPosition(),
                "titre" => $linktocontenu->getTitle(),
                "soustitre" => $linktocontenu->getSubtitle(),
                "sousrubriques_id" => $linktocontenu->getSousrubrique()->getId(),
                "contenuhtml" => $linktocontenu->getHtml(),
                "image" => $linktocontenu->getImage(),
                "image2" => $linktocontenu->getImage2(),
                "id" => $linktocontenu->getId(),

            ));
           exit;*/

            $requete = $this->dbGateway->prepare("
				UPDATE linktocontenu 
				SET 
                                contenu_id = :contenu_id,
                                rang = :rang,
                                titre = :titre,
                                soustitre = :soustitre,
                                sousrubriques_id = :sousrubriques_id,
                                contenuhtml = :contenuhtml,
                                image = :image,
                                image2 = :image2,
                                linktosousrubrique_id = :linktosousrubrique_id,
                                linktorubrique_id = :linktorubrique_id
                                WHERE linktocontenu_id = :id
			")or die(print_r($this->dbGateway->errors_info()));

            $requete->execute(array(
                "contenu_id" => $linktocontenu->getContenu()->getId(),
                "rang" => $linktocontenu->getRang(),
                "titre" => $linktocontenu->getTitre(),
                "soustitre" => $linktocontenu->getSousTitre(),
                "sousrubriques_id" => $linktocontenu->getSousrubrique()->getId(),
                "contenuhtml" => $linktocontenu->getContenuHtml(),
                "image" => $linktocontenu->getImage(),
                "image2" => $linktocontenu->getImage2(),
                "linktosousrubrique_id" => $linktocontenu->getLinktosection()->getId(),
                "linktorubrique_id" => $linktocontenu->getLinktosection()->getRubrique()->getId(),
                "id" => $linktocontenu->getId(),

            ));
        } 
        else {
            $requete = $this->dbGateway->prepare("INSERT into linktocontenu(contenu_id,rang,titre,soustitre,sousrubriques_id,
                contenuhtml,image,image2,type,linktosousrubrique_id,linktorubrique_id) 
		values(:contenu_id,:rang,:titre,:soustitre,:sousrubriques_id,
                :contenuhtml,:image,:image2,:type,:linktosousrubrique_id, :linktorubrique_id)")or die(print_r($this->dbGateway->error_info()));

            $requete->execute(array(
                "contenu_id" => $linktocontenu->getContenu()->getId(),
                "rang" => $linktocontenu->getRang(),
                "titre" => $linktocontenu->getTitre(),
                "soustitre" => $linktocontenu->getSousTitre(),
                "sousrubriques_id" => $linktocontenu->getSousrubrique()->getId(),
                "contenuhtml" => $linktocontenu->getContenuHtml(),
                "image" => $linktocontenu->getImage(),
                "image2" => $linktocontenu->getImage2(),
                "type" => $linktocontenu->getType(),
                "linktosousrubrique_id" => $linktocontenu->getLinktosection()->getId(),
                "linktorubrique_id" => $linktocontenu->getLinktosection()->getRubrique()->getId(),
            ));
        }
    }

    /**
     * @param $id
     * @param $position
     * @return bool
     */
    public function updateLinktocontenuPosition($id, $position) {

        $id = (int)$id;
        
        //var_dump($contenu);
        //exit;
        if ($id > 0) {

            $requete = $this->dbGateway->prepare("
				UPDATE linktocontenu 
				SET rang = :rang
                                WHERE linktocontenu_id = :id
			")or die(print_r($this->dbGateway->errors_info()));

            $result = $requete->execute(array(
                'id'    => $id,
                'rang'  => $position
            ));
            
            return $result;
        }
        else{
            return false;
        }
    }

    /**
     * @param $id
     */
    public function deleteLinktocontenu($id) {

        $id = (int) $id;
        //echo $id;
        //fonction pour afficher la liste des tracteurs sous forme de tableau
        $requete = $this->dbGateway->prepare("
		DELETE FROM linktocontenu WHERE linktocontenu_id = :id
		")or die(print_r($this->dbGateway->error_info()));

        $requete->execute(array(
            'id' => $id
        ));
    }

}
