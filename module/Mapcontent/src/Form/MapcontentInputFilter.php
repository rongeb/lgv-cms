<?php

namespace Mapcontent\Form;


use Contenu\Form\ContenuInputFilter;
use ExtLib\Utils;

/**
 * Class MapcontentInputFilter
 * @package Mapcontent\Form
 */
class MapcontentInputFilter extends ContenuInputFilter {

    protected $translator;

    /**
     * MapcontentInputFilter constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->translator = new Utils();
    }
}
