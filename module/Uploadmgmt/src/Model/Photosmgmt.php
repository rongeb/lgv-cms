<?php

namespace Uploadmgmt\Model;

use ExtLib\FileManager;
use ExtLib\Utils;
use Mobilews\Controller\MobilewsController;
use Uploadmgmt\Controller\UploadmgmtController;

/**
 * Class Photosmgmt
 * @package Uploadmgmt\Model
 */
class Photosmgmt
{

    protected $id;
    protected $libelle;
    protected $rang;
    protected $rubrique;

    protected $publicPath = 'public/';
    protected $util;

    /**
     * Photosmgmt constructor.
     */
    public function __construct()
    {
        $util = new Utils();
    }

    /**
     * @param $idPhoto
     * @param $angle
     */
    public function photoRotate($idPhoto, $angle)
    {
        $Photosmgmtdao = new Uploadmgmtdao();
        $photo = $Photosmgmtdao->getPhoto($idPhoto);
        $phName = $photo['name'];
        $phPath = $this->publicPath . '/' . $photo['path'];
        $viPath = $this->publicPath . '/' . $photo['thumbnailpath'];
        $viName = $photo['thumbnail'];
        $imagePh = null;
        $imageVi = null;
        $info = getimagesize($phPath . $phName);

        if (strcasecmp($info['mime'], 'image/jpeg') == 0) {
            $imagePh = imagecreatefromjpeg($phPath . $phName);
            $imageVi = imagecreatefromjpeg($viPath . $viName);
        } elseif (strcasecmp($info['mime'], 'image/png') == 0) {
            $imagePh = imagecreatefrompng($phPath . $phName);
            $imageVi = imagecreatefrompng($viPath . $viName);
        } else {
            return false;
        }

        $rotatePh = imagerotate($imagePh, $angle, 0);
        $rotateVi = imagerotate($imageVi, $angle, 0);

        $phOri = $phPath . substr($phName, 0, strrpos($phName, '.')) . '.Ori' . substr($phName, strrpos($phName, '.'));
        if (!is_file($phOri)) {
            $filter = new \Laminas\Filter\File\Rename(array(
                "target" => $phOri,
                "overwrite" => false
            ));
            $filter->filter($phPath . $phName);
        }

        $viOri = $viPath . substr($viName, 0, strrpos($viName, '.')) . '.Ori' . substr($viName, strrpos($viName, '.'));
        if (!is_file($viOri)) {
            $filter = new \Laminas\Filter\File\Rename(array(
                "target" => $viOri,
                "overwrite" => false
            ));
            $filter->filter($viPath . $viName);
        }

        // save the picture in the folder
        if (strcasecmp($info['mime'], 'image/jpeg') == 0) {
            imagejpeg($rotatePh, $phPath . $phName, 100);
            imagejpeg($rotateVi, $viPath . $viName, 100);
        }
        if (strcasecmp($info['mime'], 'image/png') == 0) {
            imagepng($rotatePh, $phPath . $phName, 9);
            imagepng($rotateVi, $viPath . $viName, 9);
        }
    }

    /**
     * @param $photo
     * @return array
     */
    public function photoBackToOriginal($photo)
    {
        try {
            $phName = $photo['name'];
            $phPath = $this->publicPath . '/' . $photo['path'];
            $viPath = $this->publicPath . '/' . $photo['thumbnailpath'];
            $viName = $photo['thumbnail'];

            $phOri = $phPath . substr($phName, 0, strrpos($phName, '.')) . '.Ori' . substr($phName, strrpos($phName, '.'));

            if (is_file($phOri)) {

                $this->deleteFile($phPath . $phName);

                $filter = new \Laminas\Filter\File\Rename(array(
                    "target" => $phPath . $phName,
                    "overwrite" => false
                ));

                $filterTxt = $filter->filter($phOri);
            }

            $viOri = $viPath . substr($viName, 0, strrpos($viName, '.')) . '.Ori' . substr($viName, strrpos($viName, '.'));

            if (is_file($viOri)) {

                $this->deleteFile($viPath . $viName);

                $filter = new \Laminas\Filter\File\Rename(array(
                    "target" => $viPath . $viName,
                    "overwrite" => false
                ));

                $filterTxt = $filter->filter($viOri);
            }

            return array("status" => "ok",
                "error" => "none");
        } catch (\Exception $e) {
            return array("status" => "ko",
                "error" => $e);
        }
    }

    /**
     * @param $pathToFile
     * @return bool
     */
    public function deleteFile($pathToFile)
    {
        if (is_file($pathToFile)) {
            return @unlink($pathToFile);
            //var_dump($unlinkTxt);
        }
    }

    /**
     * @param $path
     * @param $filename
     */
    public function deleteOriTypePhoto($path, $filename)
    {
        $oriFilePath = $path . substr($filename, 0, strrpos($filename, '.')) . '.Ori' . substr($filename, strrpos($filename, '.'));
        $this->deleteFile($oriFilePath);
    }

}
