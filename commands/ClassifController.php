<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\commands;
use app\commands\MyController;
use app\commands\xmlToArrayParser;
use app\models\okpd;
use app\models\oktmoppo;
use app\models\organizationType;
use app\models\okopf;
use app\models\singlereason;

/**
 * Description of ClassifController
 *
 * @author roni
 */
class ClassifController extends MyController {

    public function actionOkpd() {
        $okpdObj = new okpd();

        $ids = $okpdObj->findBySql('SELECT code FROM okpd')->asArray()->all();
        $idVal = array_column($ids, 'code');
        $xmlTextBits = $this->getXmlBits('okpd.xml', 'nsiOKPD');
        foreach ($xmlTextBits as $xmlBit) {
            $okpdObj = new okpd();
            $xmlArray = $this->getXmlArray($xmlBit);
            $okpdObj->attributes = $xmlArray['nsiOKPD'];
           $okpdObj->save(TRUE, null , $idVal);
//             var_dump($idVal); die;
            //если id уже есть, то UPDATE

            unset($xmlArray, $okpdObj);
        }
        unset ($ids,$idVal);

    }

    public function actionOktmoppo() {
        $oktmoppoObj = new oktmoppo();

        $ids = $oktmoppoObj->findBySql('SELECT code FROM oktmoppo')->asArray()->all();
        $idVal = array_column($ids, 'code');

        $xmlTextBits = $this->getXmlBits('oktmoppo.xml','nsiOKTMOPPO');
        foreach ($xmlTextBits as $xmlBit) {
            $oktmoppoObj = new oktmoppo();
            $xmlArray = $this->getXmlArray($xmlBit);

            // проверка на скалярные значения
            $xmlArrayValid = self::delArrays($xmlArray['nsiOKTMOPPO']);
            $oktmoppoObj->attributes = $xmlArrayValid;
            $oktmoppoObj->save(true,NULL,$idVal);
            unset($xmlArray, $oktmoppoObj);
        }
    }

    public function actionOrgtype() {
        $orgtypeObj = new organizationType();
        $tag = 'nsiOrganizationType';
        $ids = $orgtypeObj->findBySql('SELECT code FROM organizationType')->asArray()->all();
        $idVal = array_column($ids, 'code');
        $xmlTextBits = $this->getXmlBits('OrganizationType.xml',$tag);
        foreach ($xmlTextBits as $xmlBit) {
            $orgtypeObj = new organizationType();
            $xmlArray = $this->getXmlArray($xmlBit);
            // проверка на скалярные значения
            $xmlArrayValid = self::delArrays($xmlArray[$tag]);
            $orgtypeObj->attributes = $xmlArrayValid;
            $orgtypeObj->save(true,NULL,$idVal);
            unset($xmlArray, $orgtypeObj);
        }
    }

    public function actionOkopf() {
        $okopfObj = new okopf();
        $tag = 'nsiOKOPF';
        $ids = $okopfObj->findBySql('SELECT code FROM okopf')->asArray()->all();
        $idVal = array_column($ids, 'code');
        $xmlTextBits = $this->getXmlBits('resource/okopf.xml',$tag);
        foreach ($xmlTextBits as $xmlBit) {
            $okopfObj = new okopf();
            $xmlArray = $this->getXmlArray($xmlBit);
            // проверка на скалярные значения
            $xmlArrayValid = self::delArrays($xmlArray[$tag]);
            $okopfObj->attributes = $xmlArrayValid;
            $okopfObj->save(true,NULL,$idVal);
            unset($xmlArray, $okopfObj);
        }

    }

    public function actionSinglereason() {
        $singlereasonObj = new singlereason();
        $tag = 'nsiContractSingleCustomerReason';
        $ids = $singlereasonObj->findBySql('SELECT code FROM singlereason')->asArray()->all();
        $idVal = array_column($ids, 'code');
        $xmlTextBits = $this->getXmlBits('resource/SingleCustomerReason.xml', $tag);
        foreach ($xmlTextBits as $xmlBit) {
            $singlereasonObj = new singlereason();
            $xmlArray = $this->getXmlArray($xmlBit);
            // проверка на скалярные значения
            $xmlArrayValid = self::delArrays($xmlArray[$tag]);
            $singlereasonObj->attributes = $xmlArrayValid;
            $singlereasonObj->save(true, NULL, $idVal);
            unset($xmlArray, $singlereasonObj);
        }
    }

}
