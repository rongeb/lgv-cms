<?php

// module/Rubrique/src/Rubrique/Model/Rubrique.php:
namespace Rubrique\Model;

/**
 * Class Meta
 * @package Rubrique\Model
 */
class Meta{

	protected $metaid;
	protected $metakey;
        protected $metavalue;
        protected $rubriqueid;

    /**
     * Meta constructor.
     */
    public function __construct(){}
		
	/**
     * @param $row
     * @return Meta
     */
    public static function fromArray($row) {
		$instance = new self();
                $instance->exchangeArray($row);
		
                return $instance;
	}

    /**
     * @param $data
     */
    private function exchangeArray($data){
		
            if(isset($data['meta_id'])){
		$this->setMetaid($data['meta_id']);
            }
            if(isset($data['meta_key'])){
		$this->setMetakey($data['meta_key']);  
            }
            if(isset($data['meta_value'])){
		$this->setMetavalue($data['meta_value']);  
            }
            if(isset($data['rubrique_id'])){
                $this->setRubriqueId($data['rubrique_id']);  
            }
	}

    /**
     * @param $_id
     */
    public function setMetaid($_id){
		$this->metaid = $_id;
	}
	public function getMetaid(){
		return $this->metaid;
	}
	
	public function setMetakey($_key){
		$this->metakey=$_key;
	}
	public function getMetakey(){
		return $this->metakey;
	}
        
        public function setMetavalue($_value){
		$this->metavalue=$_value;
	}
	public function getMetavalue(){
		return $this->metavalue;
	}
        
        public function setRubriqueid($_rubriqueid){
		$this->rubriqueid=$_rubriqueid;
	}
	public function getRubriqueid(){
		return $this->rubriqueid;
	}


    /**
     * @return array
     */
	public function getArrayCopy(){
		return get_object_vars($this);
	}
		
}