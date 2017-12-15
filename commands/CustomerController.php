<?php

namespace app\commands;

use app\commands\xmlToArrayParser;
use app\commands\MyController;
use app\models\customer;
use app\models\factualAddress;
use app\models\area;
use app\models\region;
use app\models\settlement;


/**
 * Description of CustomerController
 *
 * @author roni
 */
class CustomerController extends MyController {

    public function actionTodb() {

        $customerObj = new customer;
        $ids = $customerObj->findBySql('SELECT regNumber FROM customer')->asArray()->all();
        unset($customerObj);
        $idVal = array_column($ids, 'regNumber');
        $xmlTextBits = $this->getXmlBits('1.xml');
        foreach ($xmlTextBits as $xmlBit) {
            $customerObj = new customer;
            $factAddressObj = new factualAddress;
            $xmlArray = $this->getXmlArray($xmlBit);
            $customerObj->attributes = $xmlArray['nsiOrganization'];
          $regNumber = $customerObj->getAttribute('regNumber');
          //если вставилось, то вставить все зависимые таблицы

          if ($customerObj->save(true,null,$idVal)) {
              $query=$customerObj->find()->where(['regNumber'=>$regNumber])->limit(1)->one();
              $id=$query['id'];
                $factAddressObj->attributes =  $xmlArray['nsiOrganization']['factualAddress'];

                $factAddressObj->save();
                $factAddressObj->link('customer', $customerObj);
                // втсавка связанных данных в area region
                $this->area($xmlArray, $factAddressObj);
                $this->region($xmlArray, $factAddressObj);
                $this->settlement($xmlArray, $factAddressObj);

              var_dump('стоп'); die;
          }
            unset($xmlArray, $customerObj);
        }
        unset ($ids,$idVal);
    }

    public function getXmlArray($xmlText) {
        $xmlObject = new xmlToArrayParser($xmlText);
        $xmlArray = $xmlObject->array;
        unset($xmlObject);
        return $xmlArray;
    }

    public function getXmlBits($xmlFileName,$tag='') {
        $xmltext = file_get_contents($xmlFileName);
        $xmltext = preg_replace('/oos:/', '', $xmltext);
        $xmltext = preg_replace('/ns2:/', '', $xmltext);
        $xmltext = preg_replace('/<signature>.*?<\/signature>/', '', $xmltext);
        $xmltext = preg_replace('/<consRegistryNum>.*?<\/consRegistryNum>/', '', $xmltext);
        $xmltext = preg_replace('/<organizationRole>.*?<\/organizationRole>/', '', $xmltext);
        preg_match_all('/<nsiOrganization>.*?<\/nsiOrganization>/', $xmltext, $xmltextBits);
        return $xmltextBits[0];
    }

    public function area($xmlBit, $addrObj) {
        if (isset ($xmlBit['nsiOrganization']['factualAddress']['area'])) {
            $areaObj = new area();
            $areaObj->attributes = $xmlBit['nsiOrganization']['factualAddress']['area'];
            $areaObj->save();
            $areaObj->link('factualAddress',$addrObj);
        }

    }

    public function region($xmlBit, $addrObj) {
        if (isset($xmlBit['nsiOrganization']['factualAddress']['region'])) {
            $regionObj = new region();
            $regionObj->attributes = $xmlBit['nsiOrganization']['factualAddress']['region'];
            $regionObj->save();
            $regionObj->link('factualAddress', $addrObj);
        }
    }

    public function settlement($xmlBit, $addrObj) {
        if (isset($xmlBit['nsiOrganization']['factualAddress']['settlement'])) {
            $settlementObj = new settlement();
            $settlementObj->attributes = $xmlBit['nsiOrganization']['factualAddress']['settlement'];
            $settlementObj->save();
            $settlementObj->link('factualAddress', $addrObj);
        }
    }

    public function path() {
        return 'fcs_nsi/nsiOrganization/';
    }

    public function pathResource (){
        return 'resource/customer/';
    }
}
