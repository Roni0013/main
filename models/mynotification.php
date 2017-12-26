<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models;
use app\models\baseXmlSql;
/**
 * Description of mynotification
 *
 * @author roni
 */
class mynotification extends baseXmlSql{
    public  $id;
    public  $purchaseNumber;
    public  $customer;
    public  $maxPrice;
    public  $responsibleOrg;
    public  $sqlfilenumber;


    public  $purchaseObjectInfo;
    public  $docPublishDate;
    public  $ETP;  // электронная площадка
    public  $startDate;
    public  $endDate;
    public  $biddingDate;
    public  $deliveryPlace;
    public  $href;
    public  $restrictInfo;
    public  $deliveryTerm;
    public  $placingWay;










    public function rules() {
        return [
            [['id', 'purchaseNumber','docPublishDate', 'href', 'purchaseObjectInfo', 'customer', 'maxPrice',
            'restrictInfo', 'ETP','biddingDate', 'deliveryPlace','responsibleOrg','placingWay','startDate','endDate','deliveryTerm','sqlfilenumber'], 'safe']
        ];
    }

   

    public static function tableSql() {
        return 'notification';
    }

    public static function intValues() {
        return 6;
    }

    public function xrules() {
        return [
          'id'=>['export/fcsNotificationEP/id', 
                'export/fcsNotificationEF/id', 
                'export/fcsNotificationEP/id', 
                'export/fcsNotificationZK/id', 
                'export/fcsNotificationEF/id'],
          'purchaseNumber'=>['export/fcsNotificationEP/purchaseNumber', 
                            'export/fcsNotificationEF/purchaseNumber', 
                            'export/fcsNotificationEP/purchaseNumber',
                            'export/fcsNotificationZK/purchaseNumber',
                            'export/fcsNotificationEF/purchaseNumber'],
          'customer'=>['export/fcsNotificationEP/lot/customerRequirements/customerRequirement/customer/regNum',
                        'export/fcsNotificationEF/lot/customerRequirements/customerRequirement/customer/regNum',
                        'export/fcsNotificationEP/lot/customerRequirements/customerRequirement/customer/regNum',
                        'export/fcsNotificationZK/lot/customerRequirements/customerRequirement/customer/regNum',
                        'export/fcsNotificationEF/lot/customerRequirements/customerRequirement/customer/regNum'],
          'maxPrice'=>['export/fcsNotificationEP/lot/maxPrice', 
                        'export/fcsNotificationEF/lot/maxPrice',
                        'export/fcsNotificationEP/lot/maxPrice',
                        'export/fcsNotificationZK/lot/maxPrice',
                        'export/fcsNotificationEF/lot/maxPrice'],
          'esponsibleOrg'=>['export/fcsNotificationEP/purchaseResponsible/responsibleOrg/regNum',
                            'export/fcsNotificationEF/purchaseResponsible/responsibleOrg/regNum',
                            'export/fcsNotificationEP/purchaseResponsible/responsibleOrg/regNum',
                            'export/fcsNotificationZK/purchaseResponsible/responsibleOrg/regNum',
                            'export/fcsNotificationEF/purchaseResponsible/responsibleOrg/regNum'],
          'sqlfilenumber'=>['export/fcsNotificationEP/sqlfilenumber', 
                            'export/fcsNotificationEF/sqlfilenumber', 
                            'export/fcsNotificationEP/sqlfilenumber', 
                            'export/fcsNotificationZK/sqlfilenumber', 
                            'export/fcsNotificationEF/sqlfilenumber'],
          'purchaseObjectInfo'=>['export/fcsNotificationEP/purchaseObjectInfo', 
                                'export/fcsNotificationEF/purchaseObjectInfo',
                                'export/fcsNotificationEP/purchaseObjectInfo',
                                'export/fcsNotificationZK/purchaseObjectInfo',
                                'export/fcsNotificationEF/purchaseObjectInfo'],
          'docPublishDate'=>['export/fcsNotificationEP/docPublishDate', 
                            'export/fcsNotificationEF/docPublishDate', 
                            'export/fcsNotificationEP/docPublishDate', 
                            'export/fcsNotificationZK/docPublishDate', 
                            'export/fcsNotificationEF/docPublishDate'],
          'ETP'=>['export/fcsNotificationEP/ETP/code', 
                    'export/fcsNotificationEF/ETP/code', 
                    'export/fcsNotificationEP/ETP/code', 
                    'export/fcsNotificationZK/ETP/code', 
                    'export/fcsNotificationEF/ETP/code'],
          'startDate'=>['export/fcsNotificationEP/startDate', 
                        'export/fcsNotificationEF/startDate', 
                        'export/fcsNotificationEP/startDate', 
                        'export/fcsNotificationZK/startDate', 
                        'export/fcsNotificationEF/startDate'],
          'endDate'=>['export/fcsNotificationEP/endDate', 
                        'export/fcsNotificationEF/endDate', 
                        'export/fcsNotificationEP/endDate', 
                        'export/fcsNotificationZK/endDate', 
                        'export/fcsNotificationEF/endDate'],
          'biddingDate'=>['export/fcsNotificationEP/procedureInfo/bidding/date', 
                        'export/fcsNotificationEF/procedureInfo/bidding/date', 
                        'export/fcsNotificationEP/procedureInfo/bidding/date',
                        'export/fcsNotificationZK/procedureInfo/bidding/date',
                        'export/fcsNotificationEF/procedureInfo/bidding/date'],
          'deliveryPlace'=>['export/fcsNotificationEP/lot/customerRequirements/customerRequirement/deliveryPlace',
                            'export/fcsNotificationEF/lot/customerRequirements/customerRequirement/deliveryPlace',
                            'export/fcsNotificationEP/lot/customerRequirements/customerRequirement/deliveryPlace',
                            'export/fcsNotificationZK/lot/customerRequirements/customerRequirement/deliveryPlace',
                            'export/fcsNotificationEF/lot/customerRequirements/customerRequirement/deliveryPlace'],
          'href'=>['export/fcsNotificationEP/href', 
                'export/fcsNotificationEF/href',
                'export/fcsNotificationEP/href', 
                'export/fcsNotificationZK/href', 
                'export/fcsNotificationEF/href'],
          'restrictInfo'=>['export/fcsNotificationEP/lot/restrictInfo',
                            'export/fcsNotificationEF/lot/restrictInfo', 
                            'export/fcsNotificationEP/lot/restrictInfo', 
                            'export/fcsNotificationZK/lot/restrictInfo', 
                            'export/fcsNotificationEF/lot/restrictInfo'],
          'deliveryTerm'=>['export/fcsNotificationEP/lot/customerRequirements/customerRequirement/deliveryTerm',
                            'export/fcsNotificationEF/lot/customerRequirements/customerRequirement/deliveryTerm',
                             'export/fcsNotificationEP/lot/customerRequirements/customerRequirement/deliveryTerm',
                             'export/fcsNotificationZK/lot/customerRequirements/customerRequirement/deliveryTerm',
                            'export/fcsNotificationEF/lot/customerRequirements/customerRequirement/deliveryTerm'],
          'placingWay'=>['export/fcsNotificationEP/placingWay/code', 
                        'export/fcsNotificationEF/placingWay/code', 
                        'export/fcsNotificationEP/placingWay/code',
                        'export/fcsNotificationZK/placingWay/code',
                        'export/fcsNotificationEF/placingWay/code'],

        ];
    }

    public function replace($key, $text) {
        if (($key == 'docPublishDate') or ($key == 'startDate') or ($key == 'endDate') or ($key == 'biddingDate')) {
            $pattern = '/^\d{4}-\d{2}-\d{2}/';
//            print_r($key . '  '. $text);
            preg_match($pattern, $text, $resMatch);
//            print_r($resMatch)[0]; sleep (1);
            if (isset ($resMatch[0])) {
                return $resMatch[0];
            }else {
                return '';
            }
        }
        return trim($text);
    }


}
