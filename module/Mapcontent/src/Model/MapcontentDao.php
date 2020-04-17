<?php

namespace Mapcontent\Model;

use Contenu\Model\ContenuDao;
use Mapcontent\Model\Mapper\MapcontentMapper;
use Sousrubrique\Model\Sousrubriquedao;

/**
 * Class MapcontentDao
 * @package Mapcontent\Model
 */
class MapcontentDao extends ContenuDao {

    /**
     * MapcontentDao constructor.
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * @param $id
     * @return Mapcontent
     */
    public function getMapcontent($id) {

        $id = (int) $id;
        $result = array();

        $sousrubriqueDao = new SousRubriqueDao();
        $contenustep1 = array();
        $mapcontentMapper = new MapcontentMapper();

        $requete = $this->dbGateway->prepare("
		SELECT".self::$fields."
		FROM contenu c
		WHERE c.contenu_id = :id
		")or die(print_r($this->dbGateway->error_info()));

        $requete->execute(array(
            'id' => $id
        ));

        $requete2 = $requete->fetch(\PDO::FETCH_ASSOC);

        $sousrubrique = $sousrubriqueDao->getSousrubrique($requete2['sousrubriques_id']);

        $contenustep1['id'] = $requete2['contenu_id'];
        $contenustep1['titre'] = $requete2['titre'];
        $contenustep1['soustitre'] = $requete2['soustitre'];
        $contenustep1['contenu'] = $requete2['contenuhtml'];
        $contenustep1['position'] = $requete2['rang'];
        $contenustep1['image'] = $requete2['image'];
        $contenustep1['image2'] = $requete2['image2'];
        $contenustep1['sousrubrique'] = $sousrubrique;
        $contenustep1['type'] = $requete2['type'];
        $contenustep1['gps_coordinates'] = $requete2['gps_coordinates'];

        return $mapcontentMapper->exchangeArray($contenustep1);
    }

    /**
     * @param Mapcontent $mapcontent
     */
    public function saveMapcontent(Mapcontent $mapcontent) {

        $id = (int) $mapcontent->getId();
        //var_dump($mapcontent);
        //exit;
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
                gps_coordinates = :coords
				WHERE contenu_id = :id
			")or die(print_r($this->dbGateway->errors_info()));

            $requete->execute(array(
                'id' => $id,
                'titre' => $mapcontent->getTitre(),
                'soustitre' => $mapcontent->getSousTitre(),
                'rang' => $mapcontent->getRang(),
                'image' => $mapcontent->getImage(),
                'image2' => $mapcontent->getImage2(),
                'sousrubriques_id' => $mapcontent->getSousRubrique()->getId(),
                'contenuhtml' => $mapcontent->getContenuHtml(),
                'coords' => $mapcontent->getGpsInfoList()
            ));
        } else {
            $requete = $this->dbGateway->prepare("INSERT into contenu(titre,soustitre,sousrubriques_id,contenuhtml, rang, image, image2, type, gps_coordinates) 
					values(:titre, :soustitre,:sousrubriques_id,:contenuhtml, :rang, :image, :image2, :type, :coords)")or die(print_r($this->dbGateway->error_info()));

            $requete->execute(array(
                'titre' => $mapcontent->getTitre(),
                'soustitre' => $mapcontent->getSousTitre(),
                'sousrubriques_id' => $mapcontent->getSousRubrique()->getId(),
                'contenuhtml' => $mapcontent->getContenuHtml(),
                'rang' => $mapcontent->getRang(),
                'image' => $mapcontent->getImage(),
                'image2' => $mapcontent->getImage2(),
                'type' => $mapcontent->getType(),
                'coords' => $mapcontent->getGpsInfoList()
            ));
        }
    }
}
