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
use app\models\contract;
use app\models\product;
use app\models\supplier;
/**
 * Description of ContrController
 *
 * @author roni
 */
class ContractController extends MyController {


    public function actionContract($fileNumber = 1) {
//        print_r (strpos (scandir('temp')[2],'Procedure')); die;
        if (strpos (scandir('temp')[2],'Procedure')>0) {
//            echo "нашел Procedure \n";
            exit;
        }
        $xmlConract = new mycontract;
        $xmlConract->setAttributes(['sqlfilenumber'=>$fileNumber]);

        file_put_contents($this->pathDestination()['contract'].$fileNumber.'.sql', $xmlConract->putXml($this->textArrays()));
        unset ($xmlConract);
        echo "Создан Conract$fileNumber \n";
        return true;
    }

    public function actionProduct($fileNumber = 1) {
        if (strpos (scandir('temp')[2],'Procedure')>0) {
//            echo "нашел Procedure \n";
            exit;
        }
        $xmlBits = $this->textArrays();
        $xmlProductText='';
        foreach ($xmlBits as $xBit) {
            $start=strpos($xBit, 'id>');
            $end = strpos($xBit, '</id');
            $contractNumber = substr($xBit, $start+3, $end-$start-3);
            $productBit = $this->getXmlBits($xBit, 'product');
            $producObj = new myproduct();
            $producObj->setAttributes(['contract_id'=>$contractNumber,'sqlfilenumber'=>$fileNumber]);
            $xmlProductText .= $producObj->putXml($productBit);
//            print_r ($xmlProductText); die;
            unset ($producObj,$productBit);
        }
        file_put_contents($this->pathDestination()['product'].$fileNumber.'.sql', $xmlProductText);
        echo "Создан Product$fileNumber \n";
        return true;
    }

    public function actionSupplier($fileNumber = 1) {
        if (strpos (scandir('temp')[2],'Procedure')>0) {
//            echo "нашел Procedure \n";
            exit;
        }
        $xmlSupplier = new mysupplier();
        $xmlSupplier->setAttributes(['sqlfilenumber'=>$fileNumber]);
        file_put_contents($this->pathDestination()['supplier'].$fileNumber.'.sql', $xmlSupplier->putXml($this->textArrays()));
        unset ($xmlSupplier);
        echo "Создан Supplier$fileNumber \n";
    }

    public function getXmlArray($xmlFileName) {
        $xmltext = file_get_contents($xmlFileName);
        $xmltext = preg_replace('/oos:/', '', $xmltext);
        $xmltext = preg_replace('/ns2:/', '', $xmltext);
        $xmltext = preg_replace('/<signature>.*?<\/signature>/', '', $xmltext);
        $xmltext = preg_replace('/INN>/', 'inn>', $xmltext);
        $xmltext = preg_replace('/KPP>/', 'kpp>', $xmltext);
        $xmltext = preg_replace('/address/', 'factualAddress', $xmltext);
        $xmltext = preg_replace('/\\\/', '', $xmltext);
        $xmltext = preg_replace('/\'/', '"', $xmltext);
        $xmltext = preg_replace('/&apos;/', '', $xmltext);

        return $xmltext;
    }

    public function path() {
        return ['contract' =>'fcs_regions/Krasnodarskij_kraj/contracts/'];
    }

    public function pathResource() {
        return [
            'contract' =>'resource/contracts/',
            'supplier' =>'resource/contracts/',
            'product' =>'resource/contracts/'
            ];
    }

    //еще добавляется номер файла и .sql  (для таблиц)
    public function pathDestination() {
        return [
            'contract' => 'files/contract/contract',
            'supplier' => 'files/supplier/supplier',
            'product' => 'files/product/product'
        ];
    }

    //    удалить дубликаты записей с номером $number из таблицы $tablename
    public function delDoubleIds($tablename, $number) {
        print_r($tablename, $number);
        if ($tablename == 'contract') {
            contract::deleteAll(['sqlfilenumber'=>$number]);
        }

        if ($tablename == 'supplier') {
            supplier::deleteAll(['sqlfilenumber'=>$number]);
        }

        if ($tablename == 'product') {
            product::deleteAll(['sqlfilenumber'=>$number]);
        }

    }

    public function resetFiles($tableName) {
//        if (file_exists('resource/idcurrent/contract')) {
//            unlink('resource/idcurrent/contract');
//        }

        $table = strtolower($tableName);
        switch ($table) {
            case 'contract':
                exec('rm -f files/contract/*');
                $this->putToFile($this->pathDestination()['contract'].'0.sql', 'TRUNCATE TABLE contract;');
                break;
            case 'supplier':
                exec('rm -f files/supplier/*');
                $this->putToFile($this->pathDestination()['supplier'].'0.sql', 'TRUNCATE TABLE supplier;');
                break;
            case 'product':
                exec('rm -f files/product/*');
                $this->putToFile($this->pathDestination()['product'].'0.sql', 'TRUNCATE TABLE product;');
                break;
        }

    }

    public function delSqlFile($tableName,$number) {
        $table = strtolower($tableName);
        switch ($table) {
         case 'contract':
            if (file_exists($this->pathDestination()['contract'].$number.'.sql')) {
                unlink ($this->pathDestination()['contract'].$number.'.sql');
            }
            break;
           case 'supplier':
                if (file_exists($this->pathDestination()['supplier'].$number.'.sql')) {
                    unlink ($this->pathDestination()['supplier'].$number.'.sql');
                }
                break;
            case 'product':
                if (file_exists($this->pathDestination()['product'].$number.'.sql')) {
                    unlink ($this->pathDestination()['product'].$number.'.sql');
                }
                break;
        }
    }

    public function manyActions() {
        return [
            'contract'=>'Contract',
            'supplier'=>'Supplier',
            'product'=>'Product'
        ];
    }

}
