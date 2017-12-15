<?php

namespace app\commands;

use app\commands\MyController;
use app\models\Contract;
use app\commands\xmlToArrayParser;
use app\models\supplier;
use app\models\product;
use app\models\files;

/**
 * Description of ContractController
 *
 * @author roni
 */
class ContractController extends MyController {

//    const FTP_FOLDER = 'fcs_regions/Krasnodarskij_kraj/contracts';
//    const PATH_RESOURCE ='resource/contracts/';

    public function todb($fileName) {
        $xmlArray = $this->getXmlArray($fileName);
//        втсавить контракты
        $contractObj = new Contract();
        $ids = $contractObj->findBySql('SELECT id FROM contract')->asArray()->all();
        $idVal = array_column($ids, 'id');
        $contractObj->attributes = $xmlArray ['export']['contract'];
        $contractObj->dateFormat();
        $contractObj->setAttribute('customer', $xmlArray ['export']['contract']['customer']['regNum']);
        if (isset($xmlArray ['export']['contract']['priceInfo'])) {
            $contractObj->setAttribute('price', $xmlArray ['export']['contract']['priceInfo']['price']);
        }
//        если уже есть запись
        if ($contractObj->save(true, NULL, $idVal)) {

//             вставить suppliers
            $suppObj = new supplier();


//разные тэги для supplier
            if (isset($xmlArray ['export']['contract']['suppliers']['supplier']['legalEntityRF'])) {
                $suppObj->attributes = $xmlArray ['export']['contract']['suppliers']['supplier']['legalEntityRF'];
                if (isset($xmlArray ['export']['contract']['suppliers']['supplier']['legalEntityRF']['fullName'])) {
                    $suppObj->setAttribute('organizationName', $xmlArray ['export']['contract']['suppliers']['supplier']['legalEntityRF']['fullName']);
                }
            } elseif (isset($xmlArray ['export']['contract']['suppliers']['supplier']['individualPersonRF'])) {
                $suppObj->attributes = $xmlArray ['export']['contract']['suppliers']['supplier']['individualPersonRF'];
                $suppObj->setAttribute('organizationName', 'ИП');
                $suppObj->setAttribute('isIP', 'true');
            } else {
                $suppObj->attributes = $xmlArray ['export']['contract']['suppliers']['supplier'];
            }

            if (isset ($xmlArray ['export']['contract']['suppliers']['supplier']['contactInfo']['lastName'])) {
                $suppObj->setAttribute('lastName', $xmlArray ['export']['contract']['suppliers']['supplier']['contactInfo']['lastName']);
            }

            $suppObj->save();
            $suppObj->link('contract', $contractObj);

            // если массив или одно значение продукта
            $productObj = new product();
            $xmlProduct=$xmlArray ['export']['contract']['products']['product'];
//            если много значений products
            if (isset($xmlProduct[0])) {
//          то  в цикле перечислить и сохранить в БД
                foreach ($xmlProduct as $product) {
                    $productObj = new product();
                    $productObj->attributes = $product;
//                            var_dump($productObj);
//                            die;
                    if (isset($product['OKPD']['code'])) {
                        $productObj->setAttribute('OKPD', $product['OKPD']['code']);
                    }
                    $productObj->save();
                    $productObj->link('contract', $contractObj);
                    unset ($productObj);
                }
            } else {
                $productObj->attributes = $xmlProduct;
                if (isset($xmlProduct['OKPD']['code'])) {
                    $productObj->setAttribute('OKPD', $xmlProduct['OKPD']['code']);
                }


                $productObj->save();
                $productObj->link('contract', $contractObj);
            }
        }
//        var_dump($productObj);
    }

    public function getXmlArray($xmlFileName) {
        $xmltext = file_get_contents($xmlFileName);
        $xmltext = preg_replace('/oos:/', '', $xmltext);
        $xmltext = preg_replace('/ns2:/', '', $xmltext);
        $xmltext = preg_replace('/<signature>.*?<\/signature>/', '', $xmltext);
        $xmltext = preg_replace('/INN>/', 'inn>', $xmltext);
        $xmltext = preg_replace('/KPP>/', 'kpp>', $xmltext);
        $xmltext = preg_replace('/address/', 'factualAddress', $xmltext);

        $xmlObject = new xmlToArrayParser($xmltext);
        $xmlArray = $xmlObject->array;
        return $xmlArray;
    }

    private static function unZip($fileName, $pathTo = 'temp'){
        $zip= new \ZipArchive();
        if ($zip->open($fileName) === TRUE ) {
            $zip->extractTo($pathTo);
            $zip->close();
        }
    }

    public function actionUpdate() {
        $filesObj = new files();
        $query=$filesObj->find()->where(['model'=>'contract'])->asArray()->all();
        $files= array_column($query, 'filename');
        foreach (scandir($pathFolder=$this->pathResource()) as $tempFile) {
//            $pathFolder = 'resource/contract/';
            $pathTempFolder = 'temp/';
            exec ('rm -f temp/*');
            $listZipFiles = scandir($pathFolder);
            array_shift($listZipFiles);
            array_shift($listZipFiles);
            foreach ($listZipFiles as $zipFile) {
                // не работать над отработанными zip файлами
                if (in_array($zipFile, $listZipFiles)){
                    continue;
                }
                print_r($zipFile . "\n");
                self::unZip($pathFolder . $zipFile);
                $listFiles = scandir($pathTempFolder);
                array_shift($listFiles);
                array_shift($listFiles);
                $numberFiles = count($listFiles);
                //распарсить все из папки $pathTempFolder
                foreach ($listFiles as $fileName) {
                    $starttime = microtime(TRUE);
                    $this->todb($pathTempFolder . $fileName);
                    $endtime = microtime(true);
                    $time = (int) ($endtime - $starttime + 1);
                    $min = (int) ($time / 60);
                    $sec = (int) ($time % 60);
                    $filesObj->setAttribute('filename', $fileName);
                    $filesObj->setAttribute('model', "contract");
                    $filesObj->setAttribute('time', "$min м $sec с");
                    $filesObj->save();
                    unlink($pathTempFolder . $fileName);
                }
            }
        }
    }

    public function path() {
        return 'fcs_regions/Krasnodarskij_kraj/contracts/';
    }

    public function pathResource (){
        return 'resource/contracts/';
    }



}
