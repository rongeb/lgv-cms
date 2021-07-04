<?php

namespace Fichiers\Model;

/**
 * Class FilesCategories
 * @package Fichiers\Model
 * Constants that define type of files supported
 */
class FilesCategories{

    /**
     * @var array
     */
    public static $listeextension = array('jpg', 'jpeg', 'png', 'bmp', 'gif', 'svg', 'doc', 'docx', 'rtf', 'txt', 'xls', 'xlsx', 
        'csv','ppt', 'pptx', 'pdf', 'epub', 'odt', 'ods', 'mp4', 'mkv', 'ogv', 'mp3', 'wav', 'ogg', 'zip', 'gz', 'tar');
    /**
     * @var array
     */
    public static $imgList = array('jpg', 'jpeg', 'png', 'bmp', 'gif', 'svg');
    /**
     * @var array
     */
    public static $wordList = array('doc', 'docx', 'odt', 'rtf', 'txt');
    /**
     * @var array
     */
    public static $excelList = array('xls', 'xlsx', 'ods', 'csv');
    /**
     * @var array
     */
    public static $presentationList = array('ppt', 'pptx', 'odp');
    /**
     * @var array
     */
    public static $audioList = array('mp3', 'wav', 'ogg');
    /**
     * @var array
     */
    public static $videoList = array('mp4', 'mkv', 'ogv');
    /**
     * @var array
     */
    public static $documentList = array('pdf', 'epub');
    /**
     * @var array
     */
    public static $archiveList = array('gz', 'zip', 'tar');
    /**
     * @var string
     */
    public static $wordImg = 'word.png';
    /**
     * @var string
     */
    public static $documentImg = 'pdf.png';
    /**
     * @var string
     */
    public static $excelImg= 'excel.png';
    /**
     * @var string
     */
    public static $audioImg= 'audio.png';
    /**
     * @var string
     */
    public static $videoImg= 'video.png';
    /**
     * @var string
     */
    public static $presentationImg= 'powerpoint.png';
    /**
     * @var string
     */
    public static $archiveImg = 'zipfile.png';
}
