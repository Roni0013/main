<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\commands;
use app\commands\MyController;
use app\commands\xmlToArrayParser;
use app\models\myokpd;
use app\models\oktmoppo;
use app\models\organizationType;
use app\models\okopf;
use app\models\singlereason;
use app\models\myokei;
use app\models\myokopf;
use app\models\myokpd2;
use app\models\myplacingway;

/**
 * Description of ClassifController
 *
 * @author roni
 */
class ClassifController extends MyController {

    public function actionOkpd($fileNumber = 1) {
        $xmlText = $this->getFilenames();
        $xmlOkpd = new myokpd();
        $xmlBits = $this->getXmlBits($xmlText, 'nsiOKPD');
//        print_r ($xmlBits[0]);die;
        $sqltext = $xmlOkpd->putXml($xmlBits);
        file_put_contents($this->pathDestination()['okpd'].$fileNumber.'.sql', $sqltext);
    }

    public function actionOkpd2($fileNumber = 1) {
        $xmlText = $this->getFilenames();
        $xmlBits = $this->getXmlBits($xmlText, 'nsiOKPD2');
        $xmlOkpd = new myokpd2();
        $sqltext = $xmlOkpd->putXml($xmlBits);
        file_put_contents($this->pathDestination()['okpd2'].$fileNumber.'.sql', $sqltext);
    }

    public function actionOkei($fileNumber = 1) {
        $xmlText = $this->getFilenames();
        $xmlOkei = new myokei();
        $xmlBits = $this->getXmlBits($xmlText, 'nsiOKEI');
        $sqltext = $xmlOkei->putXml($xmlBits);
        file_put_contents($this->pathDestination()['okei'].$fileNumber.'.sql', $sqltext);
    }

    public function actionOkopf ($fileNumber = 1) {
        $xmlText = $this->getFilenames();
        $xmlOkopf = new myokopf();
        $xmlBits = $this->getXmlBits($xmlText, 'nsiOKOPF');
        $sqltext = $xmlOkopf->putXml($xmlBits);
        file_put_contents($this->pathDestination()['okopf'].$fileNumber.'.sql', $sqltext);
    }

    public function actionPlacingway($fileNumber = 1) {
        $xmlText = $this->getFilenames();
        $xmlPlace = new myplacingway();
        $xmlBits = $this->getXmlBits($xmlText, 'nsiPlacingWay');
        $sqltext = $xmlPlace->putXml($xmlBits);
        file_put_contents($this->pathDestination()['placingway'].$fileNumber.'.sql', $sqltext);
    }













//  общее для всех action получение списка файлов
    public function getFilenames($dir='temp') {
        $fileNames = scandir($dir);
        array_shift($fileNames);
        array_shift($fileNames);
        if (isset($fileNames[0])) {
           return  file_get_contents($dir.'/'.$fileNames[0]);

        } else {
            return '';
        }
    }















//
//
//    public function actionTofileokpd($filename = 'resource/OKPD.xml', $fileNumber = 1) {
//
////      сформировать  имя для okpd
//        $sqlFileNameOkpd = $this->pathDestination()['okpd'] . $fileNumber . '.sql';
//        //вставка начальных строк  INSERT INTO okpd
//        $sqlInsertTextOkpd = "INSERT INTO okpd ";
//        $xmlBits = $this->getXmlBits($filename, 'nsiOKPD');
//        foreach ($xmlBits as $xBit) {
////     сформировать модель
//            $xmlOkpd = new myokpd();
//            $xmlArray = $this->getXmlArray($xBit);
//            $xmlOkpd->attributes = $xmlArray['nsiOKPD'];
////            $xmlOkpd->setAttributes(['sqlfilename' => $fileNumber]);
////        print_r($xmlOkpd); die;
//            $keysOkpd = $xmlOkpd->getAttributes();
//            if (!self::$isFirst) {
//                $firstLineOkpd = $this->getStrFirstLine(array_keys($keysOkpd));
//                $this->putToFile($sqlFileNameOkpd, $sqlInsertTextOkpd . $firstLineOkpd . ' VALUES ');
//            }
//            $lineOkpd = $this->getStrVal($keysOkpd, 1);  //количество целых в начале строки VALUES (,,,)
//            $this->putToFile($sqlFileNameOkpd, $lineOkpd);
//            self::$isFirst = true;
//        }
////      $this->putToFile($sqlFileNameOkpd, "; \n");
//    }
//
//
//    public function actionTofileokpd2($filename = 'resource/OKPD2.xml', $fileNumber = 1) {
//
////      сформировать  имя для okpd
//        $sqlFileNameOkpd = $this->pathDestination()['okpd2'] . $fileNumber . '.sql';
//        //вставка начальных строк  INSERT INTO okpd
//        $sqlInsertTextOkpd = "INSERT INTO okpd ";
//        $xmlBits = $this->getXmlBits($filename, 'nsiOKPD2');
//        foreach ($xmlBits as $xBit) {
////     сформировать модель
//            $xmlOkpd = new myokpd();
//            $xmlArray = $this->getXmlArray($xBit);
//            $xmlOkpd->attributes = $xmlArray['nsiOKPD2'];
////            $xmlOkpd->setAttributes(['sqlfilename' => $fileNumber]);
////        print_r($xmlOkpd); die;
//            $keysOkpd = $xmlOkpd->getAttributes();
//            if (!self::$isFirst) {
//                $firstLineOkpd = $this->getStrFirstLine(array_keys($keysOkpd));
//                $this->putToFile($sqlFileNameOkpd, $sqlInsertTextOkpd . $firstLineOkpd . ' VALUES ');
//            }
//            $lineOkpd = $this->getStrVal($keysOkpd, 1);  //количество целых в начале строки VALUES (,,,)
//            $this->putToFile($sqlFileNameOkpd, $lineOkpd);
//            self::$isFirst = true;
//        }
////        $this->putToFile($sqlFileNameOkpd, "; \n");
//    }
//
//    public function actionOktmoppo() {
//        $oktmoppoObj = new oktmoppo();
//
//        $ids = $oktmoppoObj->findBySql('SELECT code FROM oktmoppo')->asArray()->all();
//        $idVal = array_column($ids, 'code');
//
//        $xmlTextBits = $this->getXmlBits('oktmoppo.xml','nsiOKTMOPPO');
//        foreach ($xmlTextBits as $xmlBit) {
//            $oktmoppoObj = new oktmoppo();
//            $xmlArray = $this->getXmlArray($xmlBit);
//
//            // проверка на скалярные значения
//            $xmlArrayValid = self::delArrays($xmlArray['nsiOKTMOPPO']);
//            $oktmoppoObj->attributes = $xmlArrayValid;
//            $oktmoppoObj->save(true,NULL,$idVal);
//            unset($xmlArray, $oktmoppoObj);
//        }
//    }
//
//    public function actionOrgtype() {
//        $orgtypeObj = new organizationType();
//        $tag = 'nsiOrganizationType';
//        $ids = $orgtypeObj->findBySql('SELECT code FROM organizationType')->asArray()->all();
//        $idVal = array_column($ids, 'code');
//        $xmlTextBits = $this->getXmlBits('OrganizationType.xml',$tag);
//        foreach ($xmlTextBits as $xmlBit) {
//            $orgtypeObj = new organizationType();
//            $xmlArray = $this->getXmlArray($xmlBit);
//            // проверка на скалярные значения
//            $xmlArrayValid = self::delArrays($xmlArray[$tag]);
//            $orgtypeObj->attributes = $xmlArrayValid;
//            $orgtypeObj->save(true,NULL,$idVal);
//            unset($xmlArray, $orgtypeObj);
//        }
//    }
//
//    public function actionOkopf() {
//        $okopfObj = new okopf();
//        $tag = 'nsiOKOPF';
//        $ids = $okopfObj->findBySql('SELECT code FROM okopf')->asArray()->all();
//        $idVal = array_column($ids, 'code');
//        $xmlTextBits = $this->getXmlBits('resource/okopf.xml',$tag);
//        foreach ($xmlTextBits as $xmlBit) {
//            $okopfObj = new okopf();
//            $xmlArray = $this->getXmlArray($xmlBit);
//            // проверка на скалярные значения
//            $xmlArrayValid = self::delArrays($xmlArray[$tag]);
//            $okopfObj->attributes = $xmlArrayValid;
//            $okopfObj->save(true,NULL,$idVal);
//            unset($xmlArray, $okopfObj);
//        }
//
//    }

//    public function actionSinglereason() {
//        $singlereasonObj = new singlereason();
//        $tag = 'nsiContractSingleCustomerReason';
//        $ids = $singlereasonObj->findBySql('SELECT code FROM singlereason')->asArray()->all();
//        $idVal = array_column($ids, 'code');
//        $xmlTextBits = $this->getXmlBits('resource/SingleCustomerReason.xml', $tag);
//        foreach ($xmlTextBits as $xmlBit) {
//            $singlereasonObj = new singlereason();
//            $xmlArray = $this->getXmlArray($xmlBit);
//            // проверка на скалярные значения
//            $xmlArrayValid = self::delArrays($xmlArray[$tag]);
//            $singlereasonObj->attributes = $xmlArrayValid;
//            $singlereasonObj->save(true, NULL, $idVal);
//            unset($xmlArray, $singlereasonObj);
//        }
//    }


    public function path() {
        return [
            'okpd'=> 'fcs_nsi/nsiOKPD/',
            'okpd2' =>'fcs_nsi/nsiOKPD2/',
            'oktmoppo'=>'fcs_nsi/nsiOKTMOPPO/',
            'orgtype'=>'fcs_nsi/nsiOrganizationType/',
            'okopf'=>'fcs_nsi/nsiOKOPF/',
            'singlereason'=>'fcs_nsi/nsiSingleCustomerReasonOZ/',
            'okei'=>'fcs_nsi/nsiOKEI/',
            'placingway' => 'fcs_nsi/nsiPlacingWay/'
            ];
    }

    public function pathResource() {
        return [
            'okpd'=> 'resource/OKPD/',
            'okpd2' =>'resource/OKPD2/',
            'oktmoppo'=>'resource/OKTMOPPO/',
            'orgtype'=>'resource/organizationType/',
            'okopf'=>'resource/OKOPF/',
            'singlereason'=>'resource/singleReason/',
            'okei'=>'resource/OKEI/',
            'placingway'=>'resource/placingway/',
        ];
    }

    public function pathDestination() {
        return [
            'okpd' => 'files/okpd/okpd',
            'okpd2' => 'files/okpd2/okpd',
            'oktmoppo' => 'files/oktmoppo/oktmoppo',
            'orgtype' => 'files/orgtype/orgtype',
            'okopf' => 'files/okopf/okopf',
            'singlereason' => 'files/singlereason/singlereason',
            'okei' => 'files/okei/okei',
            'placingway' => 'files/placingway/placingway',
        ];
    }
    public function resetFiles($tableName) {

        $table = strtolower($tableName);
        switch ($table) {
        case 'okpd':
            exec('rm -f files/okpd/*');
            $this->putToFile($this->pathDestination()['okpd'].'0.sql', 'TRUNCATE TABLE okpd;');
            break;
        case 'okpd2':
            exec('rm -f files/okpd2/*');
            $this->putToFile($this->pathDestination()['okpd2'].'0.sql', 'TRUNCATE TABLE okpd;');
            break;
        case 'oktmoppo':
            exec('rm -f files/oktmoppo/*');
            $this->putToFile($this->pathDestination()['oktmoppo'].'0.sql', 'TRUNCATE TABLE oktmoppo;');
            break;
        case 'orgtype':
            exec('rm -f files/orgtype/*');
            $this->putToFile($this->pathDestination()['orgtype'].'0.sql', 'TRUNCATE TABLE orgtype;');
            break;
        case 'okopf':
            exec('rm -f files/okopf/*');
            $this->putToFile($this->pathDestination()['okopf'].'0.sql', 'TRUNCATE TABLE okopf;');
            break;
        case 'singlereason':
            exec('rm -f files/singlereason/*');
            $this->putToFile($this->pathDestination()['singlereason'].'0.sql', 'TRUNCATE TABLE singlereason;');
            break;
        case 'okei':
            exec('rm -f files/okei/*');
            $this->putToFile($this->pathDestination()['okei'].'0.sql', 'TRUNCATE TABLE okei;');
            break;
        case 'placingway':
            exec('rm -f files/placingway/*');
            $this->putToFile($this->pathDestination()['placingway'].'0.sql', 'TRUNCATE TABLE placingway;');
            break;
        }
    }


     public function delSqlFile($tableName,$number) {
        $table = strtolower($tableName);
        switch ($table) {
         case 'okpd':
            if (file_exists($this->pathDestination()['okpd'].$number.'.sql')) {
                unlink ($this->pathDestination()['okpd'].$number.'.sql');
            }
            break;

        }
     }

    public function manyActions() {
        return [
            'okpd'=>'tofileokpd',
            'okpd2'=>'tofileokpd2'
        ];
    }





}
