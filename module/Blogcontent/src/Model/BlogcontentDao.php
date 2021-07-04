<?php

namespace Blogcontent\Model;

use Sousrubrique\Model\Sousrubriquedao;
use Blogcontent\Model\Blogcontent;
use Contenu\Model\ContenuType;
use Application\DBConnection\ParentDao;
use Blogcontent\Model\Mapper\BlogContentMapper;

/**
 * Class BlogcontentDao
 * @package Blogcontent\Model
 */
class BlogcontentDao extends ParentDao{

    public function __construct() {
        
        parent::__construct();
    }


    /**
     * @param $dataType
     *
     * dataType : array, object, json
     *
     * @return array
     */
    public function getAllBlogContent($dataType) {

        $count = 0;
        $sousrubriqueDao = new Sousrubriquedao();

        $requete = $this->dbGateway->prepare("
		SELECT *
		FROM contenu c
                WHERE c.type ='".ContenuType::$blog."' 
                ORDER BY c.sousrubriques_id, c.rang
		")or die(print_r($this->dbGateway->error_info()));

        $requete->execute();

        $requete2 = $requete->fetchAll(\PDO::FETCH_ASSOC);
        $blogContentMapper = new BlogContentMapper();
        if (strcasecmp($dataType,"object") == 0) {
            //Put result in an array of objects
            $arrayOfContenustep1 = array();
            $arrayOfContenustep2 = array();

            if (is_array($requete2)) {
                foreach ($requete2 as $key => $value) {
                    //print_r($value);
                    //put code to define an array of objects
                    if ($value['sousrubriques_id'] != null && $value['sousrubriques_id'] != "") {

                        $sousrubrique = $sousrubriqueDao->getSousrubrique($value['sousrubriques_id']);

                        $arrayOfContenustep1[$count]['id'] = $value['contenu_id'];
                        $arrayOfContenustep1[$count]['titre'] = $value['titre'];
                        $arrayOfContenustep1[$count]['soustitre'] = $value['soustitre'];
                        $arrayOfContenustep1[$count]['contenu'] = $value['contenuhtml'];
                        $arrayOfContenustep1[$count]['position'] = $value['rang'];
                        $arrayOfContenustep1[$count]['image'] = $value['image'];
                        $arrayOfContenustep1[$count]['image2'] = $value['image2'];
                        $arrayOfContenustep1[$count]['sousrubrique'] = $sousrubrique;
                        $arrayOfContenustep1[$count]['author'] = $value['author'];
                        $arrayOfContenustep1[$count]['themes'] = $value['themes'];
                        $arrayOfContenustep1[$count]['blogdate'] = $value['contenu_date'];
                        $arrayOfContenustep1[$count]['text1'] = $value['othertext1'];
                        $arrayOfContenustep1[$count]['text2'] = $value['othertext2'];
                        $arrayOfContenustep1[$count]['text3'] = $value['othertext3'];
                        
                        $arrayOfContenustep2[$count] = $blogContentMapper->exchangeArray($arrayOfContenustep1[$count]);

                        $count++;
                    }
                }
            }
            
            return $arrayOfContenustep2;
             
        }
        elseif (strcasecmp( $dataType, "array") == 0) {
            return $requete2;
        }
        elseif (strcasecmp( $dataType,"json") == 0) {
            return $blogContentMapper->to_json($requete2);
        }
    }

    /**
     * @param $id
     * @param $dataType
     * ataType : array, object
     * @return array
     */
    public function getAllBlogContentByRubrique($id, $dataType) {

        //var_dump($id);
        $count = 0;
        $count2 = -1;
        $sousrubriqueDao = new Sousrubriquedao();

        $requete = $this->dbGateway->prepare("
		SELECT c.*
		FROM contenu c
                JOIN sousrubrique sr on sr.id = c.sousrubriques_id
                JOIN rubrique r on r.id = sr.rubriques_id
                WHERE c.type ='".ContenuType::$blog."' AND r.id = :idrub AND c.rang > -1 AND sr.rang > -1
		ORDER BY sr.rang, c.rang
		")or die(print_r($this->dbGateway->error_info()));

        $requete->execute(array(
            'idrub' => $id));

        $requete2 = $requete->fetchAll(\PDO::FETCH_ASSOC);

        if (strcasecmp( $dataType,"object") == 0) {
            //Put result in an array of objects
            $arrayOfContenustep1 = array();
            $arrayOfContenustep2 = array();
            $arrayOfContenustep3 = array();

            $sousrub = "";
            if (is_array($requete2)) {
                $blogContentMapper = new BlogContentMapper();
                foreach ($requete2 as $key => $value) {
                    //print_r($value);
                    //put code to define an array of objects
                    if ($value['sousrubriques_id'] != null && $value['sousrubriques_id'] != "") {

                        //$sousrubrique = $sousrubriqueDao->getSousrubrique($value['sousrubriques_id']);
                        if ($sousrub != $value['sousrubriques_id']) {
                            $count2++;
                            $count = 0;
                        }

                        $sousrub = $value['sousrubriques_id'];

                        $arrayOfContenustep1[$count]['id'] = $value['contenu_id'];
                        $arrayOfContenustep1[$count]['titre'] = $value['titre'];
                        $arrayOfContenustep1[$count]['soustitre'] = $value['soustitre'];
                        $arrayOfContenustep1[$count]['contenu'] = $value['contenuhtml'];
                        $arrayOfContenustep1[$count]['position'] = $value['rang'];
                        $arrayOfContenustep1[$count]['image'] = $value['image'];
                        $arrayOfContenustep1[$count]['image2'] = $value['image2'];
                        //$arrayOfContenustep1[$count]['sousrubrique'] = $sousrubrique;
                        $arrayOfContenustep1[$count]['author'] = $value['author'];
                        $arrayOfContenustep1[$count]['themes'] = $value['themes'];
                        $arrayOfContenustep1[$count]['blogdate'] = $value['contenu_date'];
                        $arrayOfContenustep1[$count]['text1'] = $value['othertext1'];
                        $arrayOfContenustep1[$count]['text2'] = $value['othertext2'];
                        $arrayOfContenustep1[$count]['text3'] = $value['othertext3'];
                        
                        $arrayOfContenustep2[$count] = $blogContentMapper->exchangeArray($arrayOfContenustep1[$count]);

                        $arrayOfContenustep3[$count2][$count] = $arrayOfContenustep2[$count];

                        $count++;
                    }
                }
            }
            
            return $arrayOfContenustep3;
        }
        elseif (strcasecmp( $dataType,"array") == 0) {
             return $requete2;
        }
    }


    /**
     * @param $rubName
     * @param $limit
     * @param $typeContenu
     * @param $dataType : array or object
     * @return array or blogcontent object
     */
    public function getAllBlogContentByRubriqueName($rubName, $limit, $typeContenu, $dataType) {

        //var_dump($id);
        $count = 0;
        $count2 = -1;
        $sousrubriqueDao = new Sousrubriquedao();

        $requete = $this->dbGateway->prepare("
		SELECT c.*
		FROM contenu c
                JOIN sousrubrique sr on sr.id = c.sousrubriques_id
                JOIN rubrique r on r.id = sr.rubriques_id
                WHERE c.type = :typeContenu AND LOWER(r.libelle) = LOWER(:rubName) AND c.rang > -1 AND sr.rang > -1
		ORDER BY sr.rang, c.rang
                LIMIT :limit
		")or die(print_r($this->dbGateway->error_info()));

        $requete->bindParam(':typeContenu', $typeContenu, \PDO::PARAM_STR);
        $requete->bindParam(':rubName', $rubName, \PDO::PARAM_STR);
        $requete->bindParam(':limit', $limit, \PDO::PARAM_INT);

        $requete->execute();

        $requete2 = $requete->fetchAll(\PDO::FETCH_ASSOC);

        //var_dump($requete2);
        //exit();
        if (strcasecmp( $dataType,"object") == 0) {
            //Put result in an array of objects
            $arrayOfContenustep1 = array();
            $arrayOfContenustep2 = array();
            $arrayOfContenustep3 = array();

            $sousrub = "";
            if (is_array($requete2)) {
                $blogContentMapper = new BlogContentMapper();
                foreach ($requete2 as $key => $value) {
                    //print_r($value);
                    //put code to define an array of objects
                    if ($value['sousrubriques_id'] != null && $value['sousrubriques_id'] != "") {

                        //$sousrubrique = $sousrubriqueDao->getSousrubrique($value['sousrubriques_id']);
                        if ($sousrub != $value['sousrubriques_id']) {
                            $count2++;
                            $count = 0;
                        }

                        $sousrub = $value['sousrubriques_id'];

                        $arrayOfContenustep1[$count]['id'] = $value['contenu_id'];
                        $arrayOfContenustep1[$count]['titre'] = $value['titre'];
                        $arrayOfContenustep1[$count]['soustitre'] = $value['soustitre'];
                        $arrayOfContenustep1[$count]['contenu'] = $value['contenuhtml'];
                        $arrayOfContenustep1[$count]['position'] = $value['rang'];
                        $arrayOfContenustep1[$count]['image'] = $value['image'];
                        $arrayOfContenustep1[$count]['image2'] = $value['image2'];
                        //$arrayOfContenustep1[$count]['sousrubrique'] = $sousrubrique;
                        $arrayOfContenustep1[$count]['author'] = $value['author'];
                        $arrayOfContenustep1[$count]['themes'] = $value['themes'];
                        $arrayOfContenustep1[$count]['blogdate'] = $value['contenu_date'];
                        $arrayOfContenustep1[$count]['text1'] = $value['othertext1'];
                        $arrayOfContenustep1[$count]['text2'] = $value['othertext2'];
                        $arrayOfContenustep1[$count]['text3'] = $value['othertext3'];
                        
                        $arrayOfContenustep2[$count] = $blogContentMapper->exchangeArray($arrayOfContenustep1[$count]);

                        $arrayOfContenustep3[$count2][$count] = $arrayOfContenustep2[$count];

                        $count++;
                    }
                }
            }
            
            return $arrayOfContenustep3;
             
        }
        elseif (strcasecmp( $dataType,"array") == 0) {
           return $requete2;
        }
    }


    /**
     * @param $id
     * @param $dataType : array, object, json
     * @return array|\Blogcontent\Model\Blogcontent|mixed
     */
    public function getBlogContent($id, $dataType) {

        $id = (int) $id;
        $result = array();

        $sousrubriqueDao = new SousRubriqueDao();
        $contenustep1 = array();

        $requete = $this->dbGateway->prepare("
		SELECT *
		FROM contenu c
		WHERE c.contenu_id = :id
		")or die(print_r($this->dbGateway->error_info()));

        $requete->execute(array(
            'id' => $id
        ));

        $requete2 = $requete->fetch(\PDO::FETCH_ASSOC);
        $blogContentMapper = new BlogContentMapper();
        if (strcasecmp( $dataType,"object") == 0) {
            $sousrubrique = $sousrubriqueDao->getSousrubrique($requete2['sousrubriques_id']);

            $contenustep1['id'] = $requete2['contenu_id'];
            $contenustep1['titre'] = $requete2['titre'];
            $contenustep1['soustitre'] = $requete2['soustitre'];
            $contenustep1['contenu'] = $requete2['contenuhtml'];
            $contenustep1['position'] = $requete2['rang'];
            $contenustep1['image'] = $requete2['image'];
            $contenustep1['image2'] = $requete2['image2'];
            $contenustep1['sousrubrique'] = $sousrubrique;
            $contenustep1['author'] = $requete2['author'];
            $contenustep1['themes'] = $requete2['themes'];
            $contenustep1['blogdate'] = $requete2['contenu_date'];
            $contenustep1['text1'] = $requete2['othertext1'];
            $contenustep1['text2'] = $requete2['othertext2'];
            $contenustep1['text3'] = $requete2['othertext3'];

            $contenu = $blogContentMapper->exchangeArray($contenustep1);

            return $contenu;
        }
        elseif(strcasecmp( $dataType,"array") == 0) {
            return $requete2;
        }
        else if(strcasecmp( $dataType,"json") == 0) {
            return $blogContentMapper->to_json(array($requete2));
        }
    }

    /**
     * @param $sousrubriqueid
     * @param $dataType : array, object
     * @return array|blogcontent object
     */
    public function getBlogContentBySousrubrique($sousrubriqueid, $dataType) {

        $sousrubriqueid = (int) $sousrubriqueid;
        $result = array();

        $sousrubriqueDao = new SousRubriqueDao();
        $contenustep1 = array();

        $requete = $this->dbGateway->prepare("
		SELECT *
		FROM contenu c
		WHERE c.sousrubriques_id = :id
		")or die(print_r($this->dbGateway->error_info()));

        $requete->execute(array(
            'id' => $sousrubriqueid
        ));

        $requete2 = $requete->fetch(\PDO::FETCH_ASSOC);

        if (strcasecmp($dataType,"object") == 0) {
            //Put result in an array of objects
            $arrayOfContenustep1 = array();
            $arrayOfContenustep2 = array();

            if (is_array($requete2)) {
                $count=0;
                $blogContentMapper = new BlogContentMapper();
                foreach ($requete2 as $key => $value) {
                    //print_r($value);
                    //put code to define an array of objects
                    if ($value['sousrubriques_id'] != null && $value['sousrubriques_id'] != "") {

                        $sousrubrique = $sousrubriqueDao->getSousrubrique($value['sousrubriques_id']);

                        $arrayOfContenustep1[$count]['id'] = $value['contenu_id'];
                        $arrayOfContenustep1[$count]['titre'] = $value['titre'];
                        $arrayOfContenustep1[$count]['soustitre'] = $value['soustitre'];
                        $arrayOfContenustep1[$count]['contenu'] = $value['contenuhtml'];
                        $arrayOfContenustep1[$count]['position'] = $value['rang'];
                        $arrayOfContenustep1[$count]['image'] = $value['image'];
                        $arrayOfContenustep1[$count]['image2'] = $value['image2'];
                        $arrayOfContenustep1[$count]['sousrubrique'] = $sousrubrique;
                        $arrayOfContenustep1[$count]['author'] = $value['author'];
                        $arrayOfContenustep1[$count]['themes'] = $value['themes'];
                        $arrayOfContenustep1[$count]['blogdate'] = $value['contenu_date'];
                        $arrayOfContenustep1[$count]['text1'] = $value['othertext1'];
                        $arrayOfContenustep1[$count]['text2'] = $value['othertext2'];
                        $arrayOfContenustep1[$count]['text3'] = $value['othertext3'];
                        
                        $arrayOfContenustep2[$count] = $blogContentMapper->exchangeArray($arrayOfContenustep1[$count]);

                        $count++;
                    }
                }
                
            }
            
            return $arrayOfContenustep2;
             
        }
        elseif (strcasecmp($dataType,"array") == 0) {
            return $requete2;
        }
    }

    /**
     * @param \Blogcontent\Model\Blogcontent $contenu
     */
    public function saveBlogContent(Blogcontent $contenu) {

        $id = (int) $contenu->getId();

        if ($id > 0) {

            $requete = $this->dbGateway->prepare("
				UPDATE contenu 
				SET titre= :titre, 
				soustitre = :soustitre,
				sousrubriques_id = :sousrubriques_id,
				contenuhtml = :contenuhtml,
                                rang = :rang,
                                image = :image,
                                image2 = :image2,
                                author = :author,
                                themes = :themes,
                                contenu_date = :blogdate,
                                othertext1 = :text1,
                                othertext2 = :text2,
                                othertext3 = :text3
				WHERE contenu_id = :id
			")or die(print_r($this->dbGateway->errors_info()));

            $requete->execute(array(
                'id' => $id,
                'titre' => $contenu->getTitre(),
                'soustitre' => $contenu->getSousTitre(),
                'rang' => $contenu->getRang(),
                'image' => $contenu->getImage(),
                'image2' => $contenu->getImage2(),
                'sousrubriques_id' => $contenu->getSousRubrique()->getId(),
                'contenuhtml' => $contenu->getContenuHtml(),
                'author' => $contenu->getAuthor(),
                'themes' => $contenu->getThemes(),
                'blogdate' => $contenu->getDate(),
                'text1' => $contenu->getText1(),
                'text2' => $contenu->getText2(),
                'text3' => $contenu->getText3()
            ));
        } else {
            $requete = $this->dbGateway->prepare("INSERT into contenu(titre,soustitre,sousrubriques_id,contenuhtml, rang, image, image2, type, author, themes, contenu_date, othertext1, othertext2, othertext3) 
					values(:titre, :soustitre,:sousrubriques_id,:contenuhtml, :rang, :image, :image2, :type, :author, :themes, :blogdate, :text1, :text2, :text3)")or die(print_r($this->dbGateway->error_info()));

            $requete->execute(array(
                'titre' => $contenu->getTitre(),
                'soustitre' => $contenu->getSousTitre(),
                'sousrubriques_id' => $contenu->getSousRubrique()->getId(),
                'contenuhtml' => $contenu->getContenuHtml(),
                'rang' => $contenu->getRang(),
                'image' => $contenu->getImage(),
                'image2' => $contenu->getImage2(),
                'type' => $contenu->getType(),
                'author'=> $contenu->getAuthor(),
                'themes'=> $contenu->getThemes(),
                'blogdate'=> $contenu->getDate(),
                'text1' => $contenu->getText1(),
                'text2' => $contenu->getText2(),
                'text3' => $contenu->getText3()  
            ));
        }
    }

    /**
     * @param $id
     */
    public function deleteBlogContent($id) {

        $id = (int) $id;
        //echo $id;
        //fonction pour afficher la liste des tracteurs sous forme de tableau
        $requete = $this->dbGateway->prepare("
		DELETE FROM contenu WHERE contenu_id = :id
		")or die(print_r($this->dbGateway->error_info()));

        $requete->execute(array(
            'id' => $id
        ));
    }

}
