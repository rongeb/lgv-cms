<?php

namespace Mapcontent\Model;

use Contenu\Model\IContenu;

/**
 * Interface IMapcontent
 * @package Mapcontent\Model
 */
interface IMapcontent extends IContenu {
    /**
     * @return mixed
     */
    public function getGpsInfoList();

    /**
     * @param $_gpsInfo
     * @return mixed
     */
    public function setGpsInfoList($_gpsInfo);
}


