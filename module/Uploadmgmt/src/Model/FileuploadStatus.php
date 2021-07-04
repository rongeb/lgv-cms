<?php

namespace Uploadmgmt\Model;

/**
 * Class FileuploadStatus
 * @package Uploadmgmt\Model
 * Constants that define the state of an uploaded file
 */
class FileuploadStatus
{
    /**
     * @var string
     */
    public static $WAITING = 'waiting';
    /**
     * @var string
     */
    public static $VALIDATED = 'validated';
    /**
     * @var string
     */
    public static $REFUSED = 'refused';
    /**
     * @var string
     */
    public static $OBSOLETE = 'obsolete';

    /**
     * @var array
     */
    public static $FILE_STATUS_LIST = array(
        'waiting' => 'waiting', 'validated' => 'validated', 'refused' => 'refused', 'obsolete' => 'obsolete'
    );

}