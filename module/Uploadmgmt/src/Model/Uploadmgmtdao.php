<?php

namespace Uploadmgmt\Model;

use Application\DBConnection\ParentDao;
use Uploadmgmt\Model\FileuploadStatus;
use Uploadmgmt\Model\Fileupload;
use Uploadmgmt\Model\Mapper\FileuploadMapper;

/**
 * Class Uploadmgmtdao
 * @package Uploadmgmt\Model
 */
class Uploadmgmtdao extends ParentDao
{
    private static $fields = "p.filesupload_id as id, p.filesupload_name as name, p.filesupload_path as path, p.filesupload_type as type," .
    "p.filesupload_comment as comment, p.filesupload_status as status, p.filesupload_thumbnail as thumbnail, p.filesupload_thumbnailpath as thumbnailpath," .
    "p.filesupload_author as author, p.filesupload_userid as userid, p.filesupload_email as email, p.filesupload_date as creationdate," .
    "p.filesupload_lat as lat, p.filesupload_lng as lng";

    /**
     * @param int $idFile
     * @return mixed
     */
    public function getPhoto($idFile = 0)
    {
        $query = $this->dbGateway->prepare('SELECT ' . $this::$fields . ' FROM filesupload p WHERE filesupload_id=' . abs((int)$idFile))
        or die(print_r($this->dbGateway->error_info()));
        $query->execute();
        return $query->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * @return array
     */
    public function getPhotoWaitStatus()
    {
        $query = $this->dbGateway->prepare('SELECT ' . $this::$fields . ' FROM filesupload p WHERE p.filesupload_status=\'' . FileuploadStatus::$WAITING . '\' ORDER BY p.filesupload_date DESC')
        or die(print_r($this->dbGateway->error_info()));
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * @return array
     */
    public function getPhotoValidateStatus()
    {
        $query = $this->dbGateway->prepare('SELECT ' . $this::$fields . ' FROM filesupload p WHERE p.filesupload_status=\'' . FileuploadStatus::$VALIDATED . '\' ORDER BY p.filesupload_date DESC')
        or die(print_r($this->dbGateway->error_info()));
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }


    /**
     * @param int $idFile
     * @param $status
     * @return bool
     */
    public function updateStatus($idFile = 0, $status)
    {
        //return false;
        $idFile = (int)$idFile;
        $sql = 'UPDATE filesupload SET filesupload_status=\'' . $status . '\' WHERE filesupload_id=' . $idFile;
        $query = $this->dbGateway->prepare($sql) or die(print_r($this->dbGateway->error_info()));
        $reqIsOK = $query->execute();
        return (bool)$reqIsOK;
    }

    /**
     * @param int $idFile
     * @param array $params
     * @return bool
     */
    public function updateComment($idFile = 0, $params = array())
    {
        $idFile = abs((int)$idFile);
        $sql = 'UPDATE filesupload SET filesupload_comment=:commenter WHERE filesupload_id=:idPhoto';
        $query = $this->dbGateway->prepare($sql) or die(print_r($this->dbGateway->error_info()));
        $reqIsOK = $query->execute(array(
            'commenter' => $params['commenter'],
            'idPhoto' => $idFile
        ));
        return (bool)$reqIsOK;
    }

    /**
     * @param string $filename
     * @return \Uploadmgmt\Model\Fileupload
     */
    public function getFileByFilename(string $filename)
    {

        $fileuploadMapper = new FileuploadMapper();
        $query = $this->dbGateway->prepare("
		SELECT " . self::$fields . " 
		FROM filesupload p
		WHERE p.filesupload_name = :filename
        LIMIT 1
		") or die(print_r($this->dbGateway->error_info()));

        $query->execute(array(
            'filename' => $filename
        ));

        $result = $query->fetch(\PDO::FETCH_ASSOC);

        return $fileuploadMapper->exchangeArray($result);
    }

    /**
     * @param Fileupload $fileupload
     * @return bool
     *
     *
     */
    public function saveFileupload(Fileupload $fileupload)
    {
        $id = (int)$fileupload->getId();
        if ($id > 0) {
            $query = $this->dbGateway->prepare("
				UPDATE filesupload 
				SET filesupload_name 	= :name,
				filesupload_date = :filedate
				WHERE filesupload_id 	= :id
			") or die(print_r($this->dbGateway->errors_info()));

            $query->execute(array(
                'name' => $fileupload->getName(),
                'filedate' => $fileupload->getDate(),//date ( string $format [, int $timestamp = time() ] )
                'id' => $fileupload->getId()
            ));
        } else {
            $query = $this->dbGateway->prepare("INSERT INTO filesupload(
            filesupload_name, filesupload_type, filesupload_comment,
            filesupload_status, filesupload_thumbnail,
            filesupload_date,filesupload_thumbnailpath,
            filesupload_path,
            filesupload_author, filesupload_userid,
            filesupload_email, filesupload_lat,
            filesupload_lng) 
            values(:name,
            :type,
            :comment,:status,:thumbnail, :filedate, :thumbnailpath, :path, :author,:userid, :email,:lat,:lng)")
            or die(print_r($this->dbGateway->error_info()));

            $reqIsOK = $query->execute(
                array(
                    "name" => $fileupload->getName(),
                    "path" => $fileupload->getPath(),
                    "type" => $fileupload->getType(),
                    "comment" => $fileupload->getComment(),
                    "status" => $fileupload->getStatus(),
                    "filedate" => date("Y-m-d H:i:s"),
                    "thumbnail" => $fileupload->getThumbnail(),
                    "thumbnailpath" => $fileupload->getThumbnailpath(),
                    "author" => $fileupload->getAuthor(),
                    "userid" => $fileupload->getUserid(),
                    "email" => $fileupload->getEmail(),
                    "lat" => $fileupload->getLat(),
                    "lng" => $fileupload->getLng()
                )
            );
            return (bool)$reqIsOK;
        }
    }
}
