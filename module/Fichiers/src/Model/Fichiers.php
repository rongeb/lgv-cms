<?php
// module/Fichiers/src/Fichiers/Model/Fichiers.php:
namespace Fichiers\Model;

/**
 * Class Fichiers
 * @package Fichiers\Model
 */
class Fichiers
{
    protected $id;
    protected $chemin;
    protected $nom;
    protected $type;
    protected $libelle;
    protected $thumbnailPath;
    protected $thumbnail;
    protected $metaData;


    /**
     * Fichiers constructor.
     */
    public function __construct()
    {
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($_id)
    {
        $this->id = $_id;
    }

    public function getChemin()
    {
        return $this->chemin;
    }

    public function setChemin($_chemin)
    {
        $this->chemin = $_chemin;
    }

    public function getNom()
    {
        return $this->nom;
    }

    public function setNom($_nom)
    {
        $this->nom = $_nom;
    }

    public function getLibelle()
    {
        return $this->libelle;
    }

    public function setLibelle($_libelle)
    {
        $this->libelle = $_libelle;
    }

    public function getMetaData()
    {
        return $this->metaData;
    }

    public function setMetaData($_metaData)
    {
        $this->metaData = $_metaData;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($_type)
    {
        $this->type = $_type;
    }

    public function getThumbnailpath()
    {
        return $this->thumbnailPath;
    }

    public function setThumbnailpath($_thumbnailpath)
    {
        $this->thumbnailPath = $_thumbnailpath;
    }

    public function getThumbnail()
    {
        return $this->thumbnail;
    }

    public function setThumbnail($_thumbnail)
    {
        $this->thumbnail = $_thumbnail;
    }

}