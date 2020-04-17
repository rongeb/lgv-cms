<?php

namespace Privatespacelogin\Model;

use Privatespace\Model\Privatespace;
use Privatespace\Model\PrivatespaceDao;

/**
 * Class Privatespacelogin
 * @package Privatespacelogin\Model
 */
class Privatespacelogin {

    protected $id;
    protected $pwd;
    protected $email;
    protected $firstname;
    protected $lastname;
    protected $company;
    protected $streetnumber;
    protected $streetline_1;
    protected $streetline_2;
    protected $streetline_3;
    protected $zipcode;
    protected $city;
    protected $mobilephone;
    protected $homephone;
    protected $website;
    protected $space;
    protected $isValidate;

    /**
     * Privatespacelogin constructor.
     */
    public function __construct() {}

    /**
     * @param $_id
     */
    public function setId($_id) {
        $this->id = $_id;
    }

    /**
     * @return mixed
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @param $_email
     */
    public function setEmail($_email) {
        $this->email = $_email;
    }

    /**
     * @return mixed
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * @param $_pwd
     */
    public function setPwd($_pwd) {
        $this->pwd = $_pwd;
    }

    /**
     * @return mixed
     */
    public function getPwd() {
        return $this->pwd;
    }

    /**
     * @param $_validate
     */
    public function setIsValidate($_validate) {
        $this->isValidate = $_validate;
    }

    /**
     * @return mixed
     */
    public function getIsValidate() {
        return $this->isValidate;
    }

    /**
     * @param $_firstname
     */
    public function setFirstname($_firstname) {
        $this->firstname = $_firstname;
    }

    /**
     * @return mixed
     */
    public function getFirstname() {
        return $this->firstname;
    }

    /**
     * @param $_lastname
     */
    public function setLastname($_lastname) {
        $this->lastname = $_lastname;
    }
    
    public function getLastname() {
        return $this->lastname;
    }

    public function getCompany() {
        return $this->company;
    }
    
    public function setCompany($_company) {
        $this->company = $_company;
    }
    
    public function getStreetnumber() {
        return $this->streetnumber;
    }
    
    public function setStreetnumber($_streetnumber) {
        $this->streetnumber = $_streetnumber;
    }
   
    public function getStreetline_1() {
        return $this->streetline_1;
    }
    
    public function setStreetline_1($_streetline1) {
        $this->streetline_1 = $_streetline1;
    }
    
    public function getStreetline_2() {
       return $this->streetline_2;
    }
    
    public function setStreetline_2($_streetline2) {
        $this->streetline_2 = $_streetline2;
    }
    
    public function getStreetline_3() {
        return $this->streetline_3;
    }
    
    public function setStreetline_3($_streetline3) {
        $this->streetline_3 = $_streetline3;
    }
    
    public function setZipcode($_zipcode) {
        $this->zipcode = $_zipcode;
    }
    
    public function getZipcode() {
        return $this->zipcode;
    }
    
    public function getCity() {
        return $this->city;
    }
    
    public function setCity($_city) {
        $this->city = $_city;
    }
    
    public function getMobilephone() {
        return $this->mobilephone;
    }
    
    public function setMobilephone($_mobilephone) {
        $this->mobilephone = $_mobilephone;
    }
    
    public function setHomephone($_homephone) {
        $this->homephone = $_homephone;
    }
    
    public function getHomephone() {
        return $this->homephone;
    }
    
    public function getWebsite() {
        return $this->website;
    }
    
    public function setWebsite($_website) {
        $this->website = $_website;
    }
    
    public function getSpace() {
        return $this->space;
    }
    
    public function setSpace(Privatespace $_space) {
        $this->space = $_space;
    }

    // Add the following method:
    public function getArrayCopy() {
        return get_object_vars($this);
    }

}
