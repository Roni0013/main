<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\commands;

use app\commands\MyController;
use app\models\mynotification;
use app\models\mypurchase;

/**
 * Description of NotificationController
 *
 * @author roni
 */
class NotificationController extends MyController {


    public function actionNotification($fileNumber = 1) {

        $xmlNotif = new mynotification();
        $xmlNotif->setAttributes(['sqlfilenumber'=>$fileNumber]);
        $text=$this->textArrays();
//        print_r ($text[0]); die;
        file_put_contents($this->pathDestination()['notification'].$fileNumber.'.sql', $xmlNotif->putXml($text));
        unset ($xmlNotif);
        echo "Создан Notification$fileNumber \n";
        return true;
    }


    public function actionPurchase($fileNumber = 1) {
        $xmlBits = $this->textArrays();
        $xmlPurchaseText='';
        foreach ($xmlBits as $xBit) {
            $start=strpos($xBit, 'id>');
            $end = strpos($xBit, '</id');
            $notifNumber = substr($xBit, $start+3, $end-$start-3);
            $productBit = $this->getXmlBits($xBit, 'purchaseObject');
//            print_r($productBit); die;
            $purchesObj = new mypurchase();
            $purchesObj->setAttributes(['notification_id'=>$notifNumber,'sqlfilenumber'=>$fileNumber]);
            $xmlPurchaseText .= $purchesObj->putXml($productBit);
            unset ($purchesObj,$productBit);
        }
        file_put_contents($this->pathDestination()['purchase'].$fileNumber.'.sql', $xmlPurchaseText);
        echo "Создан Purches$fileNumber \n";
        return true;


    }






    public function actionTofile($filename = 'resource/notif4.xml', $fileNumber = 1) {
//      проверка на обнуление ID первичного ключа
        if (file_exists('resource/idcurrent/notification')) {
            self::$autoinc = file_get_contents('resource/idcurrent/notification');
        } else {
            self::$autoinc = 1;
        }
        //сформировать  имя для notification
        $sqlFileNameNotification = $this->pathDestination()['notification'] . $fileNumber . '.sql';
        //сформировать  имя для purches
        $sqlFileNamePurchase = $this->pathDestination()['purchase'] . $fileNumber . '.sql';


        //вставка начальных строк  INSERT INTO contract
        $sqlInsertTextNotification = "INSERT INTO notification ";
        //вставка начальных строк  INSERT INTO purches
        $sqlInsertTextPurchase = "INSERT INTO purchase ";

//        fcsNotificationEP fcsNotificationEF

        $xmlArr = $this->getXmlArray($filename);

        if (isset($xmlArr['export']['fcsNotificationEP'])) {
            $xmlArray = $xmlArr['export']['fcsNotificationEP'];
        } elseif (isset($xmlArr['export']['fcsNotificationEF'])) {
            $xmlArray = $xmlArr['export']['fcsNotificationEF'];
        } elseif (isset($xmlArr['fcsNotificationEP'])) {
            $xmlArray = $xmlArr['fcsNotificationEP'];
        } elseif (isset($xmlArr['fcsNotificationEF'])) {
            $xmlArray = $xmlArr['fcsNotificationEF'];
        }

        if (!isset($xmlArray)) {
            $this->putToFile('mylog/notificationerror.log', $filename);
            exit;
        }
//      сформировать модель notification
        $xmlNotification = new mynotification();
        $xmlNotification->attributes = $xmlArray;
//        организатор торгов
        if (isset($xmlArray ['purchaseResponsible']['responsibleOrg']['regNum'])) {
            $xmlNotification->setAttributes(['responsibleOrg' => $xmlArray ['purchaseResponsible']['responsibleOrg']['regNum']]);
        }
//        способ определения поставщика
        if (isset($xmlArray ['placingWay']['code'])) {
            $xmlNotification->setAttributes(['placingWay' => $xmlArray ['placingWay']['code']]);
        }
//        ETP код электронной площадки то заполнить дату
        if (isset($xmlArray ['ETP']['code'])) {
            $xmlNotification->setAttributes(['ETP' => $xmlArray ['ETP']['code']]);
            $xmlNotification->attributes = $xmlArray['procedureInfo']['collecting'];

            if (isset($xmlArray['procedureInfo']['bidding']['date'])) {
                $xmlNotification->setAttributes(['biddingDate' => $xmlArray['procedureInfo']['bidding']['date']]);
            }
        }
//        место доставки и условия доставки

        if (isset($xmlArray ['lot']['customerRequirements']['customerRequirement']['deliveryPlace'])) {
            $xmlNotification->setAttributes(['deliveryPlace' => $xmlArray ['lot']['customerRequirements']['customerRequirement']['deliveryPlace']]);
        }
        if (isset($xmlArray ['lot']['customerRequirements']['customerRequirement']['deliveryTerm'])) {
            $xmlNotification->setAttributes(['deliveryTerm' => $xmlArray ['lot']['customerRequirements']['customerRequirement']['deliveryTerm']]);
        }

//        максимальная цена
        if (isset($xmlArray ['lot']['maxPrice'])) {
            $xmlNotification->setAttributes(['maxPrice' => $xmlArray ['lot']['maxPrice']]);
        }
//        непосредственный заказчик Customer
        if (isset($xmlArray ['lot']['customerRequirements']['customerRequirement']['customer']['regNum'])) {
            $xmlNotification->setAttributes(['customer' => $xmlArray ['lot']['customerRequirements']['customerRequirement']['customer']['regNum']]);
        }
//        ограничения
        if (isset($xmlArray ['lot']['restrictInfo'])) {
            $xmlNotification->setAttributes(['restrictInfo' => $xmlArray ['lot']['restrictInfo']]);
        }
        $xmlNotification->dateFormat();
        $xmlNotification->setAttributes(['sqlfilenumber'=>$fileNumber]);
        $keysNotification = $xmlNotification->getAttributes();
        $firstLineNotification = $this->getStrFirstLine(array_keys($keysNotification));
        $this->putToFile($sqlFileNameNotification, $sqlInsertTextNotification . $firstLineNotification . ' VALUES ');
        $lineNotification = $this->getStrVal($keysNotification, 6);  //количество целых в начале строки VALUES (,,,)
        $this->putToFile($sqlFileNameNotification, $lineNotification);
//      в конце файла ;
        $this->putToFile($sqlFileNameNotification, "; \n");

//      сформировать модель purchaseObject
        $xmlPurchase = $xmlArray['lot']['purchaseObjects']['purchaseObject'];

//         если много значений purchaseObject
        if (isset($xmlPurchase[0])) {
//          то  в цикле перечислить и сохранить в файл
            foreach ($xmlPurchase as $purchase) {
//              сформировать модель purchase
                $purchaseObj = new mypurchase();

                $pairsPurches = $this->getPairsPurchase($purchase);
                $purchaseObj->setAttributes($pairsPurches);
                $purchaseObj->setAttributes(['notification_id' => $xmlArray['id'],'sqlfilenumber'=>$fileNumber]);

                $keysPurchase = $purchaseObj->getAttributes();

                if (!self::$isFirst) {
                    $firstLinePurchase = $this->getStrFirstLine(array_keys($keysPurchase));
                    $this->putToFile($sqlFileNamePurchase, $sqlInsertTextPurchase . $firstLinePurchase . ' VALUES ');
                }
                $linePurchase = $this->getStrVal($keysPurchase, 6);  //количество целых в начале строки VALUES (,,,)
//                    print_r ($keysProduct); die;
                $this->putToFile($sqlFileNamePurchase, $linePurchase);
                self::$isFirst = TRUE;
            }
        } else {
            $purchaseObj = new mypurchase();
            $pairsPurches = $this->getPairsPurchase($xmlPurchase);
            $purchaseObj->setAttributes($pairsPurches);
            $purchaseObj->setAttributes(['notification_id' => $xmlArray['id'],'sqlfilenumber'=>$fileNumber]);
            $keysPurchase = $purchaseObj->getAttributes();
            $firstLinePurchase = $this->getStrFirstLine(array_keys($keysPurchase));
            $this->putToFile($sqlFileNamePurchase, $sqlInsertTextPurchase . $firstLinePurchase . ' VALUES ');
            $linePurchase = $this->getStrVal($keysPurchase, 6);  //количество целых в начале строки VALUES (,,,)
            $this->putToFile($sqlFileNamePurchase, $linePurchase);
        }
//        в конце запроса ;
        $this->putToFile($sqlFileNamePurchase, "; \n");


//        print_r ($xmlArray);die;
    }

    public function getPairsPurchase($xmlArr) {

        if (isset($xmlArr['OKPD']['code'])) {
            $pairs['OKPD'] = $xmlArr['OKPD']['code'];
        }
        if (isset($xmlArr['name'])) {
            $pairs['name'] = $xmlArr['name'];
        }
        if (isset($xmlArr['OKEI']['code'])) {
            $pairs['OKEI'] = $xmlArr['OKEI']['code'];
        }
        if (isset($xmlArr['customerQuantities']['customerQuantity']['quantity'])) {
            $pairs['quantity'] = $xmlArr['customerQuantities']['customerQuantity']['quantity'];
        }
        if (isset($xmlArr['price'])) {
            $pairs['price'] = $xmlArr['price'];
        }
        if (isset($xmlArr['quantity']['value'])) {
            $pairs['quantity'] = $xmlArr['quantity']['value'];
        }
        if (isset($xmlArr['sum'])) {
            $pairs['sum'] = $xmlArr['sum'];
        }


        return $pairs;
    }

    public function getXmlArray($xmlFileName) {
        $xmltext = file_get_contents($xmlFileName);
        $xmltext = preg_replace('/oos:/', '', $xmltext);
        $xmltext = preg_replace('/ns2:/', '', $xmltext);
        $xmltext = preg_replace('/&apos;/', '', $xmltext);
        $xmltext = preg_replace('/\\\/', '', $xmltext);
        $xmltext = preg_replace('/\'/', '"', $xmltext);
        return $xmltext;
    }

    public function path() {
        return ['notification'=> 'fcs_regions/Krasnodarskij_kraj/notifications/'];
    }

    public function pathResource() {
        return ['notification'=>  'resource/notification/',
                'purchase'=>  'resource/notification/'];
    }

    public function pathDestination() {
        return [
            'notification' => 'files/notification/notification',
            'purchase' => 'files/purchase/purchase'
        ];
    }

    public function resetFiles($tableName) {
        $table = strtolower($tableName);
        switch ($table) {
            case 'notification':
                exec('rm -f files/notification/*');
                $this->putToFile($this->pathDestination()['notification'].'0.sql', 'TRUNCATE TABLE notification;');
                break;
              case 'purchase':
                exec('rm -f files/purchase/*');
                $this->putToFile($this->pathDestination()['purchase'].'0.sql', 'TRUNCATE TABLE purchase;');
                break;
        }
    }
    public function delSqlFile($tableName,$number) {

         $table = strtolower($tableName);
        switch ($table) {
            case 'notification':
        if (file_exists($this->pathDestination()['notification'] . $number . '.sql')) {
            unlink($this->pathDestination()['notification'] . $number . '.sql');
        }
        break;
        case 'purchase':
        if (file_exists($this->pathDestination()['purchase'] . $number . '.sql')) {
            unlink($this->pathDestination()['purchase'] . $number . '.sql');
        }
        break;
        }
    }

}
