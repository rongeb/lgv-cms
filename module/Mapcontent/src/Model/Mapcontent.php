<?php

namespace Mapcontent\Model;

use Contenu\Model\Contenu;
use Mapcontent\Model\GpsInfo;

/**
 * Class Mapcontent
 * @package Mapcontent\Model
 */
class Mapcontent extends Contenu implements IMapcontent {

    protected $gpsInfoList;

    /**
     * Mapcontent constructor.
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * @return mixed
     * it is an Std Object with 3 properties:
     * - latitude
     * - longitude
     * - description
     */
    public function getGpsInfoList()
    {
        return $this->gpsInfoList;
    }

    /**
     * @param $_gpsInfoList: associative array with 3 properties
     * - latitude
     * - longitude
     * - description
     * @return json string
     */
    public function setGpsInfoList($_gpsInfoList)
    {
        $gpsInfos = array();
        //print_r($_gpsInfoList);
        //exit;
        foreach($_gpsInfoList as $value) {
            //print_r($value);
            $gpsInfo['latitude'] = $value->latitude;
            $gpsInfo['longitude'] = $value->longitude;
            $gpsInfo['description'] = $value->description;
            array_push($gpsInfos, $gpsInfo);
        }

        return $this->gpsInfoList = json_encode($gpsInfos);
    }
}
