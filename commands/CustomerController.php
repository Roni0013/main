<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\commands;
use app\commands\MyController;
use app\models\mycustomer;
use app\models\myfactualaddress;


/**
 * Description of CustController
 *
 * @author roni
 */
class CustController extends MyController{


public function actionTofile ($filename='1.xml',$fileNumber=1){

            //получает zip файл    (общее действие)
            //разбивает на части если нужно         (частное)
            //записывает данные полей в модель      (частное)
            //из данных модели формируется файл sql дампа
//
            //проверка на обнуление ID первичного ключа
            if (file_exists('resource/idcurrent/customer')) {
                self::$autoinc = file_get_contents('resource/idcurrent/customer');
            } else {
                 self::$autoinc = 1;
            }
            $i = 0;

        //сформировать  имя для customer
        $sqlFileNameCustomer =  $this->pathDestination()['customer'].$fileNumber.'.sql';
        //сформировать  имя для factualAddress
        $sqlFileNameFactAddress =  $this->pathDestination()['factAddress'].$fileNumber.'.sql';
        //вставка начальных строк  INSERT INTO customer
        $sqlInsertTextCustomer = "INSERT INTO customer ";
        //вставка начальных строк  INSERT INTO factualAddress
        $sqlInsertTextFactAddress = "INSERT INTO factualAddress ";


//      разбить файл на части
        $xmlBits = $this->getXmlBits($filename, 'nsiOrganization');
//      каждую часть сформировать в ассоциативный массив
        foreach ($xmlBits as $xBit) {
            $xmlArray = $this->getXmlArray($xBit);

//          сформировать модель customer из части
            $xmlCustomer = new mycustomer();
            $xmlCustomer ->attributes   =$xmlArray['nsiOrganization'];
            $xmlCustomer->setAttributes(['id' => self::$autoinc]);
            $xmlCustomer->setAttributes(['factualAddress_id'=>self::$autoinc]);
            $keysCustomer = $xmlCustomer->getAttributes();

//          сформировать модель factualAddress из части


            $factAddressObj = new myfactualaddress;
            $factAddressObj -> attributes =  $xmlArray['nsiOrganization']['factualAddress'];
            $factAddressObj -> setAttributes(['id' => self::$autoinc]);
            if (isset($xmlArray['nsiOrganization']['factualAddress']['settlement']['kladrCode'])) {
                $factAddressObj -> setAttributes(['kladrCode' => $xmlArray['nsiOrganization']['factualAddress']['settlement']['kladrCode']]);
            } elseif (isset($xmlArray['nsiOrganization']['factualAddress']['city']['kladrCode'])) {
                $factAddressObj -> setAttributes(['kladrCode' => $xmlArray['nsiOrganization']['factualAddress']['city']['kladrCode']]);
            } elseif (isset($xmlArray['nsiOrganization']['factualAddress']['region']['kladrCode'])) {
                $factAddressObj -> setAttributes(['kladrCode' => $xmlArray['nsiOrganization']['factualAddress']['region']['kladrCode']]);
            }
            $keysFactAddress = $factAddressObj->getAttributes();
//            print_r ($keysFactAddress); die;


//          если вставлена первая строка то больше не надо
            if (!self::$isFirst) {
                $firstLineCustomer=$this->getStrFirstLine(array_keys($keysCustomer));
                $firstLineFactAddress=$this->getStrFirstLine(array_keys($keysFactAddress));

                $this->putToFile($sqlFileNameCustomer, $sqlInsertTextCustomer . $firstLineCustomer . ' VALUES ');
                $this->putToFile($sqlFileNameFactAddress, $sqlInsertTextFactAddress . $firstLineFactAddress . ' VALUES ');

            }

            $lineCustomer = $this->getStrVal($keysCustomer, 7);  //количество целых в начале строки VALUES (,,,)
            $lineFactAddress = $this->getStrVal($keysFactAddress, 2);  //количество целых в начале строки VALUES (,,,)
            self::$isFirst = true;

            $this->putToFile($sqlFileNameCustomer, $lineCustomer);
            $this->putToFile($sqlFileNameFactAddress, $lineFactAddress);


            self::$autoinc++;
            $i++;
//            echo "$i  ";
        }
        //в конце файла ;
        $this->putToFile($sqlFileNameCustomer, ';');
        $this->putToFile($sqlFileNameFactAddress, ';');
//      запомнить в фале текущий id
        file_put_contents('resource/idcurrent/customer', self::$autoinc);
//        self::$isFirst=FALSE;
    }

     public function path() {
        return 'fcs_nsi/nsiOrganization/';
    }
    //источник файлов ZIP для контроллера
    public function pathResource (){
        return 'resource/customer/';
    }

    //еще добавляется номер файла и .sql  (для таблиц)
    public function pathDestination() {
        return [
            'customer'=>'files/customer/customer',
            'factAddress' => 'files/factAddress/factAddress'
            ];
    }

    public function resetFiles() {
        if (file_exists('resource/idcurrent/customer')) {
            unlink('resource/idcurrent/customer');
        }
        exec('rm -f files/customer/*');
        exec('rm -f files/factAddress/*');
    }

}
