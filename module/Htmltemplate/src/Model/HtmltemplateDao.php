<?php

namespace Htmltemplate\Model;

use Application\DBConnection\ParentDao;


/**
 * Class HtmltemplateDao
 * @package Htmltemplate\Model
 */
class HtmltemplateDao extends ParentDao
{

    /**
     * HtmltemplateDao constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    protected static $fields = ' h.htmltemplate_id as id,  h.htmltemplate_label as label, h.htmltemplate_model as template';

    /**
     * @param $dataType
     * @return array or array of Htmltemplate objects
     */
    public function getAllHtmltemplate($dataType)
    {
        $requete = $this->dbGateway->prepare("
		SELECT" . self::$fields . "
		FROM htmltemplate h
		ORDER BY h.htmltemplate_label
		") or die(print_r($this->dbGateway->error_info()));

        $requete->execute();

        $requete2 = $requete->fetchAll(\PDO::FETCH_ASSOC);

        if (strcasecmp($dataType, "object") == 0) {
            //Put result in an array of objects
            $htmltemplates = array();

            if (is_array($requete2)) {
                foreach ($requete2 as $key => $value) {
                    $htmltemplate = new Htmltemplate();
                    $htmltemplate->setId($value['id']);
                    $htmltemplate->setLabel($value['label']);
                    $htmltemplate->setHtml($value['template']);
                    array_push($htmltemplates, $htmltemplate);
                }
            }
            return $htmltemplates;
        } elseif (strcasecmp($dataType, "array") == 0) {
            return $requete2;
        }
    }


    /**
     * @param $id
     * @return Htmltemplate
     */
    public function getHtmltemplate($id, $dataType)
    {
        $id = (int)$id;
        // print_r($id);

        $requete = $this->dbGateway->prepare("
		SELECT" . self::$fields . "
		FROM htmltemplate h
		WHERE h.htmltemplate_id = :id
		") or die(print_r($this->dbGateway->error_info()));

        $requete->execute(array(
            'id' => $id
        ));

        $result = $requete->fetch(\PDO::FETCH_ASSOC);

        if (strcasecmp($dataType, "object") == 0) {
            $htmltemplate = new Htmltemplate();
            $htmltemplate->setId($result['id']);
            $htmltemplate->setLabel($result['label']);
            $htmltemplate->setHtml($result['template']);
        } else if (strcasecmp($dataType, "array") == 0) {
            return $result;
        }

        return $htmltemplate;
    }

    /**
     * @param Htmltemplate $htmltemplate
     */
    public function saveHtmltemplate(Htmltemplate $htmltemplate)
    {
        $id = (int)$htmltemplate->getId();

        if ($id > 0) {
            $requete = $this->dbGateway->prepare("
				UPDATE htmltemplate 
				SET htmltemplate_label= :label, 
				htmltemplate_model = :html
				WHERE htmltemplate_id = :id
			") or die(print_r($this->dbGateway->errors_info()));

            $requete->execute(array(
                'id' => $id,
                'label' => $htmltemplate->getLabel(),
                'html' => $htmltemplate->getHtml()
            ));
        } else {
            $requete = $this->dbGateway->prepare("INSERT into htmltemplate(htmltemplate_label, htmltemplate_model) 
					values(:label, :html)") or die(print_r($this->dbGateway->error_info()));

            $requete->execute(array(
                'label' => $htmltemplate->getLabel(),
                'html' => $htmltemplate->getHtml()
            ));
        }
    }

    /**
     * @param $id
     */
    public function deleteHtmltemplate($id)
    {
        $id = (int)$id;
        $requete = $this->dbGateway->prepare("
		DELETE FROM htmltemplate WHERE htmltemplate_id = :id
		") or die(print_r($this->dbGateway->error_info()));

        $requete->execute(array(
            'id' => $id
        ));
    }

}
