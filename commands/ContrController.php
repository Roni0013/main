<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\commands;
use app\commands\MyController;
use app\models\mycontract;
use app\models\mysupplier;
use app\models\myproduct;
/**
 * Description of ContrController
 *
 * @author roni
 */
class ContrController extends MyController {

    public function actionTofile($filename = 'resource/contract.xml', $fileNumber = 1) {

        //получает zip файл    (общее действие)
        //разбивает на части если нужно         (частное)
        //записывает данные полей в модель      (частное)
        //из данных модели формируется файл sql дампа
//
        //проверка на обнуление ID первичного ключа
        if (file_exists('resource/idcurrent/contract')) {
            self::$autoinc = file_get_contents('resource/idcurrent/contract');
        } else {
            self::$autoinc = 1;
        }

        //сформировать  имя для contract
        $sqlFileNameContract = $this->pathDestination()['contract'] . $fileNumber . '.sql';
        //сформировать  имя для supplier
        $sqlFileNameSupplier = $this->pathDestination()['supplier'] . $fileNumber . '.sql';
        //сформировать  имя для product
        $sqlFileNameProduct = $this->pathDestination()['product'] . $fileNumber . '.sql';
        //вставка начальных строк  INSERT INTO contract
        $sqlInsertTextContract = "INSERT INTO contract ";
        //вставка начальных строк  INSERT INTO supplier
        $sqlInsertTextSuplier = "INSERT INTO supplier ";
        //вставка начальных строк  INSERT INTO product
        $sqlInsertTextProduct = "INSERT INTO product ";



        $xmlArray = $this->getXmlArray($filename);

//          сформировать модель contract
        $xmlContract = new mycontract();
        $xmlContract->attributes = $xmlArray['export']['contract'];
        $xmlContract->dateFormat();
        if (isset($xmlArray ['export']['contract']['customer']['regNum'])) {
            $xmlContract->setAttributes(['customer' => $xmlArray ['export']['contract']['customer']['regNum']]);
        }
        if (isset($xmlArray ['export']['contract']['priceInfo'])) {
            $xmlContract->setAttributes(['price' => $xmlArray ['export']['contract']['priceInfo']['price']]);
        }
//          вставка singleReason
        if (isset($xmlArray ['export']['contract']['singleCustomerReason']['id'])) {
            $xmlContract->setAttributes(['singlereason_id' => $xmlArray ['export']['contract']['singleCustomerReason']['id']]);
        } elseif (isset($xmlArray ['export']['contract']['foundation']['fcsOrder']['order']['singleCustomer']['reason']['code'])) {
            $xmlContract->setAttributes(['singlereason_id' => $xmlArray ['export']['contract']['foundation']['fcsOrder']['order']['singleCustomer']['reason']['code']]);
        }
        if (isset($xmlArray ['export']['contract']['placer']['responsibleOrg']['regNum'])) {
            $xmlContract->setAttributes(['responsible_id' => $xmlArray ['export']['contract']['placer']['responsibleOrg']['regNum']]);
        }

        $xmlContract->setAttributes(['supplier_id' => self::$autoinc]);
        $keysContract = $xmlContract->getAttributes();


//          сформировать модель supplier

        $suppObj = new mysupplier();

        $suppObj->setAttributes(['id' => self::$autoinc]);
        if (isset($xmlArray ['export']['contract']['suppliers']['supplier']['legalEntityRF'])) {
            $suppObj->attributes = $xmlArray ['export']['contract']['suppliers']['supplier']['legalEntityRF'];
            if (isset($xmlArray ['export']['contract']['suppliers']['supplier']['legalEntityRF']['fullName'])) {
                $suppObj->setAttributes(['organizationName' => $xmlArray ['export']['contract']['suppliers']['supplier']['legalEntityRF']['fullName']]);
            }
        } elseif (isset($xmlArray ['export']['contract']['suppliers']['supplier']['individualPersonRF'])) {
            $suppObj->attributes = $xmlArray ['export']['contract']['suppliers']['supplier']['individualPersonRF'];
            $suppObj->setAttributes(['organizationName' => 'ИП']);
            $suppObj->setAttributes(['isIP' => 'true']);
        } else {
            $suppObj->attributes = $xmlArray ['export']['contract']['suppliers']['supplier'];
        }

        if (isset($xmlArray ['export']['contract']['suppliers']['supplier']['contactInfo']['lastName'])) {
            $suppObj->setAttributes(['lastName' => $xmlArray ['export']['contract']['suppliers']['supplier']['contactInfo']['lastName']]);
        }
        $keysSupplier = $suppObj->getAttributes();

        $xmlProduct = $xmlArray ['export']['contract']['products']['product'];
        $productObj = new myproduct();
        unset($productObj);
//         если много значений products
        if (isset($xmlProduct[0])) {
//          то  в цикле перечислить и сохранить в файл
            $isFirstProduct = false;
            foreach ($xmlProduct as $product) {
//              сформировать модель product
                $productObj = new myproduct();
                $productObj->attributes = $product;
                if (isset($product['OKPD']['code'])) {
                    $productObj->setAttributes(['OKPD' => $product['OKPD']['code']]);
                }
                $productObj->setAttributes(['contract_id' => $xmlArray['export']['contract']['id']]);

                $keysProduct = $productObj->getAttributes();
//              если вставлена первая строка то больше не надо
                if (!self::$isFirst) {
                    $firstLineProduct = $this->getStrFirstLine(array_keys($keysProduct));
                    $this->putToFile($sqlFileNameProduct, $sqlInsertTextProduct . $firstLineProduct . ' VALUES ');
                }
                $lineProduct = $this->getStrVal($keysProduct, 5);  //количество целых в начале строки VALUES (,,,)
//                    print_r ($keysProduct); die;
                $this->putToFile($sqlFileNameProduct, $lineProduct);
                self::$isFirst = TRUE;
            }
            self::$isFirst = false;
//            если один
        } else {
            $productObj = new myproduct();
            $productObj->attributes = $xmlProduct;
            if (isset($xmlProduct['OKPD']['code'])) {
                $productObj->setAttributes(['OKPD' => $xmlProduct['OKPD']['code']]);
            }
            $keysProduct = $productObj->getAttributes();
            $firstLineProduct = $this->getStrFirstLine(array_keys($keysProduct));
            $this->putToFile($sqlFileNameProduct, $sqlInsertTextProduct . $firstLineProduct . ' VALUES ');
            $lineProduct = $this->getStrVal($keysProduct, 5);  //количество целых в начале строки VALUES (,,,)
            $this->putToFile($sqlFileNameProduct, $lineProduct);
        }

//          в конце запроса ;
        $this->putToFile($sqlFileNameProduct, "; \n");


        $firstLineContract = $this->getStrFirstLine(array_keys($keysContract));
        $firstLineSupplier = $this->getStrFirstLine(array_keys($keysSupplier));

        $this->putToFile($sqlFileNameContract, $sqlInsertTextContract . $firstLineContract . ' VALUES ');
        $this->putToFile($sqlFileNameSupplier, $sqlInsertTextSuplier . $firstLineSupplier . ' VALUES ');


        $lineContract = $this->getStrVal($keysContract, 6);  //количество целых в начале строки VALUES (,,,)
        $lineSupplier = $this->getStrVal($keysSupplier, 3);  //количество целых в начале строки VALUES (,,,)

        $this->putToFile($sqlFileNameContract, $lineContract);
        $this->putToFile($sqlFileNameSupplier, $lineSupplier);


        self::$autoinc++;

        //в конце файла ;
        $this->putToFile($sqlFileNameContract, "; \n");
        $this->putToFile($sqlFileNameSupplier, "; \n");
//      запомнить в фале текущий id
        file_put_contents('resource/idcurrent/contract', self::$autoinc);
//        self::$isFirst=FALSE;
    }

    public function getXmlArray($xmlFileName) {
        $xmltext = file_get_contents($xmlFileName);
        $xmltext = preg_replace('/oos:/', '', $xmltext);
        $xmltext = preg_replace('/ns2:/', '', $xmltext);
        $xmltext = preg_replace('/<signature>.*?<\/signature>/', '', $xmltext);
        $xmltext = preg_replace('/INN>/', 'inn>', $xmltext);
        $xmltext = preg_replace('/KPP>/', 'kpp>', $xmltext);
        $xmltext = preg_replace('/address/', 'factualAddress', $xmltext);
        $xmltext = preg_replace('/&apos;/', '', $xmltext);
        $xmlObject = new xmlToArrayParser($xmltext);
        $xmlArray = $xmlObject->array;
        return $xmlArray;
    }

    public function path() {
        return 'fcs_regions/Krasnodarskij_kraj/contracts/';
    }

    public function pathResource() {
        return 'resource/contracts/';
    }

    //еще добавляется номер файла и .sql  (для таблиц)
    public function pathDestination() {
        return [
            'contract' => 'files/contract/contract',
            'supplier' => 'files/supplier/supplier',
            'product' => 'files/product/product'
        ];
    }

    public function resetFiles() {
        if (file_exists('resource/idcurrent/contract')) {
            unlink('resource/idcurrent/contract');
        }
        exec('rm -f files/contract/*');
        exec('rm -f files/supplier/*');
        exec('rm -f files/product/*');
    }

}
