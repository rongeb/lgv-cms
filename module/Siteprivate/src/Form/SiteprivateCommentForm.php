<?php
namespace Siteprivate\Form;

use Sitepublic\Form\SitepublicCommentForm;

/**
 * Class SiteprivateCommentForm
 * @package Siteprivate\Form
 */
class SiteprivateCommentForm extends SitepublicCommentForm {

    /**
     * SiteprivateCommentForm constructor.
     * @param null $name
     */
    public function __construct($name = null) {
        // we want to ignore the name passed
        parent::__construct('commentform');
    }

}
