<?php

namespace Siteprivate\Form;

use Laminas\Form\Form;
use Laminas\Form\Element;
use Uploadmgmt\Model\FileuploadStatus;
use ExtLib\Utils;

/**
 * Class SiteprivateFileuploadForm
 * @package Siteprivate\Form
 */
class SiteprivateFileuploadForm extends Form
{

    private $utils;

    /**
     * SiteprivateFileuploadForm constructor.
     * @param null $name
     */
    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('fileuploadform');
        $this->utils = new Utils();

        $this->setAttribute('method', 'post');

        $this->add(array(
            'name' => 'author',
            'attributes' => array(
                'type' => 'hidden'
            ),
        ));

        $this->add(array(
            'name' => 'comment',
            'attributes' => array(
                'type' => 'text'
            ),
            'options' => array(
                'label' => $this->utils->translate('Commentaire'),
            )
        ));

        $this->add(array(
            'name' => 'lat',
            'attributes' => array(
                'type' => 'hidden'
            ),
        ));

        $this->add(array(
            'name' => 'lng',
            'attributes' => array(
                'type' => 'hidden'
            ),
        ));

        $this->add(array(
            'name' => 'status',
            'attributes' => array(
                'type' => 'hidden',
                'value' => FileuploadStatus::$WAITING
            ),
        ));

        $this->add(array(
            'name' => 'email',
            'attributes' => array(
                'type' => 'hidden'
            ),
        ));


        $this->add(array(
            'name' => 'userid',
            'attributes' => array(
                'type' => 'hidden'
            ),
        ));

        $this->add(array(
            'type' => 'Laminas\Form\Element\File',
            'name' => 'newfile',
            'attributes' => array(
                'id' => 'newfileId',
                //'class'	   => 'sousrubriqueSelectIdClass'
            ),
            'options' => array(
                'label' => $this->utils->translate('Choisir un fichier'),
            ),
        ));

        $this->add(array(
            'type' => 'Laminas\Form\Element\Button',
            'name' => 'sendfile',
            'options' => array(
                'label' => $this->utils->translate('Envoyer'),
            ),
            'attributes' => array(
                'value' => 'sendFile',
                'id' => 'sendFileId',
            ),
        ));
    }

}
