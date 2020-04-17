<?php
namespace Uploadmgmt\Model\Mapper;

use Uploadmgmt\Model\Fileupload;

/**
 * Class FileuploadMapper
 * @package Uploadmgmt\Model\Mapper
 */
class FileuploadMapper
{

    /**
     * FileuploadMapper constructor.
     */
    function __construct()
    {
    }

    /**
     * @param $data
     * @return Fileupload
     */
    public function exchangeArray($data)
    {
        $fileupload = new Fileupload();

        if (isset($data['id'])) {
            $fileupload->setId($data['id']);
        }
        if (isset($data['name'])) {
            $fileupload->setName($data['name']);
        }
        if (isset($data['path'])) {
            $fileupload->setPath($data['path']);
        }
        if (isset($data['type'])) {
            $fileupload->setType($data['type']);
        }
        if (isset($data['comment'])) {
            $fileupload->setComment($data['comment']);
        }
        if (isset($data['status'])) {
            $fileupload->setStatus($data['status']);
        }
        if (isset($data['thumbnailpath'])) {
            $fileupload->setThumbnailpath($data['thumbnailpath']);
        }
        if (isset($data['thumbnail'])) {
            $fileupload->setThumbnail($data['thumbnail']);
        }
        if (isset($data['author'])) {
            $fileupload->setAuthor($data['author']);
        }
        if (isset($data['userid'])) {
            $fileupload->setUserid($data['userid']);
        }
        if (isset($data['email'])) {
            $fileupload->setEmail($data['email']);
        }
        if (isset($data['creationdate'])) {
            $fileupload->setDate($data['creationdate']);
        }
        if (isset($data['lat'])) {
            $fileupload->setLat($data['lat']);
        }
        if (isset($data['lng'])) {
            $fileupload->setLng($data['lng']);
        }

        return $fileupload;
    }
}