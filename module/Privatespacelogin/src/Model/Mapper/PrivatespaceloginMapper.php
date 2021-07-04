<?php
/**
 * Created by PhpStorm.
 * User: Romuald GEBLEUX
 * Date: 30/05/2018
 * Time: 08:52
 */

namespace Privatespacelogin\Model\Mapper;
use Privatespacelogin\Model\Privatespacelogin;
use Privatespace\Model\PrivatespaceDao;

/**
 * Class PrivatespaceloginMapper
 * @package Privatespacelogin\Model\Mapper
 */
class PrivatespaceloginMapper
{
    /**
     * @param $data
     * @return Privatespacelogin
     */
    public function exchangeArray($data) {
        
        $privatespaceLogin = new Privatespacelogin();

        if (isset($data['privatespacelogin_id'])) {
            $privatespaceLogin->setId($data['privatespacelogin_id']);
        }
        if (isset($data['privatespacelogin_email'])) {
            $privatespaceLogin->setEmail($data['privatespacelogin_email']);
        }
        if (isset($data['privatespacelogin_pwd'])) {
            $privatespaceLogin->setPwd($data['privatespacelogin_pwd']);
        }
        if (isset($data['privatespacelogin_validate'])){
            $privatespaceLogin->setIsValidate($data['privatespacelogin_validate']);
        }
        if (isset($data['privatespacelogin_firstname'])) {
            $privatespaceLogin->setFirstname($data['privatespacelogin_firstname']);
        }
        if (isset($data['privatespacelogin_lastname'])) {
            $privatespaceLogin->setLastname($data['privatespacelogin_lastname']);
        }
        if (isset($data['privatespacelogin_company'])) {
            $privatespaceLogin->setCompany($data['privatespacelogin_company']);
        }
        if (isset($data['privatespacelogin_streetnumber'])) {
            $privatespaceLogin->setStreetnumber($data['privatespacelogin_streetnumber']);
        }
        if (isset($data['privatespacelogin_streetline_1'])) {
            $privatespaceLogin->setStreetline_1($data['privatespacelogin_streetline_1']);
        }
        if (isset($data['privatespacelogin_streetline_2'])) {
            $privatespaceLogin->setstreetline_2($data['privatespacelogin_streetline_2']);
        }
        if (isset($data['privatespacelogin_streetline_3'])) {
            $privatespaceLogin->setstreetline_3($data['privatespacelogin_streetline_3']);
        }
        if (isset($data['privatespacelogin_zipcode'])) {
            $privatespaceLogin->setZipcode($data['privatespacelogin_zipcode']);
        }
        if (isset($data['privatespacelogin_city'])) {
            $privatespaceLogin->setCity($data['privatespacelogin_city']);
        }
        if (isset($data['privatespacelogin_homephone'])) {
            $privatespaceLogin->setHomephone($data['privatespacelogin_homephone']);
        }
        if (isset($data['privatespacelogin_mobilephone'])) {
            $privatespaceLogin->setMobilephone($data['privatespacelogin_mobilephone']);
        }
        if (isset($data['privatespacelogin_website'])) {
            $privatespaceLogin->setWebsite($data['privatespacelogin_website']);
        }
        if (isset($data['space_id_fk'])) {
            $spaceDao = new PrivatespaceDao();
            $space = $spaceDao->getSpace($data['space_id_fk']);
            //var_dump($space);
            //exit;
            $privatespaceLogin->setSpace($space);
        }
        if(isset($data['privatespacelogin_validate'])){
            $privatespaceLogin->setIsValidate($data['privatespacelogin_validate']);
        }
        
        return $privatespaceLogin;
    }

    public function exchangeForm($data) {

        $privatespaceLogin = new Privatespacelogin();

        if (isset($data['id'])) {
            $privatespaceLogin->setId($data['id']);
        }
        if (isset($data['email'])) {
            $privatespaceLogin->setEmail($data['email']);
        }
        if (isset($data['pwd'])) {
            $privatespaceLogin->setPwd($data['pwd']);
        }
        if (isset($data['firstname'])) {
            $privatespaceLogin->setFirstname($data['firstname']);
        }
        if (isset($data['lastname'])) {
            $privatespaceLogin->setLastname($data['lastname']);
        }
        if (isset($data['company'])) {
            $privatespaceLogin->setCompany($data['company']);
        }
        if (isset($data['streetnumber'])) {
            $privatespaceLogin->setStreetnumber($data['streetnumber']);
        }
        if (isset($data['streetline_1'])) {
            $privatespaceLogin->setStreetline_1($data['streetline_1']);
        }
        if (isset($data['streetline_2'])) {
            $privatespaceLogin->setstreetline_2($data['streetline_2']);
        }
        if (isset($data['streetline_3'])) {
            $privatespaceLogin->setstreetline_3($data['streetline_3']);
        }
        if (isset($data['zipcode'])) {
            $privatespaceLogin->setZipcode($data['zipcode']);
        }
        if (isset($data['city'])) {
            $privatespaceLogin->setCity($data['city']);
        }
        if (isset($data['homephone'])) {
            $privatespaceLogin->setHomephone($data['homephone']);
        }
        if (isset($data['mobilephone'])) {
            $privatespaceLogin->setMobilephone($data['mobilephone']);
        }
        if (isset($data['website'])) {
            $privatespaceLogin->setWebsite($data['website']);
        }
        if (isset($data['spacesList'])) {

            $spaceDao = new PrivatespaceDao();
            $space = $spaceDao->getSpace($data['spacesList']);

            $privatespaceLogin->setSpace($space);
        }
        if(isset($data['validate'])){
            $privatespaceLogin->setIsValidate($data['validate']);
        }

        return $privatespaceLogin;
    }
}