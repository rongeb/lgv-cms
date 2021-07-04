<?php
namespace Siteprivate\Form;

use Sitepublic\Form\SitepublicContactForm;

/**
 * Class SiteprivateContactForm
 * @package Siteprivate\Form
 */
class SiteprivateContactForm extends SitepublicContactForm {

    /**
     * SiteprivateContactForm constructor.
     * @param null $name
     */
    public function __construct($name = null) {
        // we want to ignore the name passed
        parent::__construct('contactform');
    }
}
