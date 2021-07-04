<?php
namespace Application\DBConnection;
 
use Application\DBConnection\DBConnection;
 
class ParentDao{
     
    protected $dbGateway;

    /**
     * ParentDao constructor.
     */
    public function __construct() {
         //put code to instantiate db connection
        $DB = new DBConnection();
        $this->dbGateway = $DB->DBConnect();
    }
}

