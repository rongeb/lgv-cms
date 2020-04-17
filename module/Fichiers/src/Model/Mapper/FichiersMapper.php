<?php

namespace Fichiers\Model\Mapper;

use Fichiers\Model\Fichiers as Files;

/**
 * Class FichiersMapper
 * @package Fichiers\Model\Mapper
 */
class FichiersMapper
{
    /**
     * @param $data
     * @return Fichiers object
     */
    public function exchangeArray($data)
    {
        $files = new Files();

        if (isset($data['fichiers_id'])) {
            $files->setId($data['fichiers_id']);
        }
        if (isset($data['fichiers_chemin'])) {
            $files->setChemin($data['fichiers_chemin']);
        }
        if (isset($data['fichiers_nom'])) {
            $files->setNom($data['fichiers_nom']);
        }
        if (isset($data['fichiers_type'])) {
            $files->setType($data['fichiers_type']);
        }
        if (isset($data['fichiers_libelle'])) {
            $files->setLibelle($data['fichiers_libelle']);
        }
        if (isset($data['fichiers_meta'])) {
            $files->setMetadata($data['fichiers_meta']);
        }
        if (isset($data['fichiers_thumbnailpath'])) {
            $files->setThumbnailpath($data['fichiers_thumbnailpath']);
        }
        if (isset($data['fichiers_thumbnail'])) {
            $files->setThumbnail($data['fichiers_thumbnail']);
        }

        return $files;

    }
}