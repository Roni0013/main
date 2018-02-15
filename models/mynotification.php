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
    public  $price;


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
    public  $canselId;
    public  $prolongId;
    public  $contractNumber;










    public function rules() {
        return [
            [['id', 'purchaseNumber','docPublishDate', 'href', 'purchaseObjectInfo', 'customer', 'maxPrice',
            'restrictInfo', 'ETP','biddingDate', 'deliveryPlace','responsibleOrg','placingWay','startDate','endDate','deliveryTerm',
                'sqlfilenumber','canselId','prolongId','contractNumber','price'], 'safe']
        ];
    }



    public static function tableSql() {
        return 'notification';
    }

    public static function intValues() {
        return 7;
    }

    public function xrules() {
        return [
          'id'=>['export/fcsNotificationEP/id',
                'export/fcsNotificationEF/id',
                'export/fcsNotificationOK/id',
                'export/fcsNotificationZK/id',
                'fcsNotificationZK/id',
                'fcsNotificationEP/id',
                'export/fcsNotificationZP/id',
                'export/fcsNotificationPO/id',
                'export/fcsNotificationISM/id',
                'export/fcsNotificationOKOU/id'],
          'purchaseNumber'=>['export/fcsNotificationEP/purchaseNumber',
                            'export/fcsNotificationEF/purchaseNumber',
                            'export/fcsNotificationOK/purchaseNumber',
                            'export/fcsNotificationZK/purchaseNumber',
                            'fcsNotificationZK/purchaseNumber',
                            'fcsNotificationEP/purchaseNumber',
                            'export/fcsNotificationZP/purchaseNumber',
                            'export/fcsNotificationPO/purchaseNumber',
                            'export/fcsNotificationISM/purchaseNumber',
                            'export/fcsNotificationOKOU/purchaseNumber',
                            'export/fcsPurchaseDocument/purchaseNumber',
                            'export/fcsClarification/purchaseNumber',
                            'export/fcsContractSign/foundation/order/purchaseNumber'],
          'customer'=>['export/fcsNotificationEP/lot/customerRequirements/customerRequirement/customer/regNum',
                        'export/fcsNotificationEF/lot/customerRequirements/customerRequirement/customer/regNum',
                        'export/fcsNotificationOK/lot/customerRequirements/customerRequirement/customer/regNum',
                        'export/fcsNotificationZK/lot/customerRequirements/customerRequirement/customer/regNum',
                        'fcsNotificationZK/lot/customerRequirements/customerRequirement/customer/regNum',
                        'fcsNotificationEP/lot/customerRequirements/customerRequirement/customer/regNum',
                        'export/fcsNotificationZP/lot/customerRequirements/customerRequirement/customer/regNum',
                        'export/fcsNotificationPO/lot/customerRequirements/customerRequirement/customer/regNum',
                        'export/fcsNotificationISM/lot/customerRequirements/customerRequirement/customer/regNum',
                        'export/fcsNotificationOKOU/lot/customerRequirements/customerRequirement/customer/regNum'],
          'maxPrice'=>['export/fcsNotificationEP/lot/maxPrice',
                        'export/fcsNotificationEF/lot/maxPrice',
                        'export/fcsNotificationOK/lot/maxPrice',
                        'export/fcsNotificationZK/lot/maxPrice',
                        'fcsNotificationZK/lot/maxPrice',
                        'fcsNotificationEP/lot/maxPrice',
                        'export/fcsNotificationPO/lot/maxPrice',
                        'export/fcsNotificationZP/lot/maxPrice',
                        'export/fcsNotificationISM/lot/maxPrice',
                        'export/fcsNotificationOKOU/lot/maxPrice'],
          'esponsibleOrg'=>['export/fcsNotificationEP/purchaseResponsible/responsibleOrg/regNum',
                            'export/fcsNotificationEF/purchaseResponsible/responsibleOrg/regNum',
                            'export/fcsNotificationOK/purchaseResponsible/responsibleOrg/regNum',
                            'export/fcsNotificationZK/purchaseResponsible/responsibleOrg/regNum',
                            'fcsNotificationZK/purchaseResponsible/responsibleOrg/regNum',
                            'fcsNotificationEP/purchaseResponsible/responsibleOrg/regNum',
                            'export/fcsNotificationZP/purchaseResponsible/responsibleOrg/regNum',
                            'export/fcsNotificationPO/purchaseResponsible/responsibleOrg/regNum',
                            'export/fcsNotificationISM/purchaseResponsible/responsibleOrg/regNum',
                            'export/fcsNotificationOKOU/purchaseResponsible/responsibleOrg/regNum'],
          'sqlfilenumber'=>['export/fcsNotificationEP/sqlfilenumber',
                            'export/fcsNotificationEF/sqlfilenumber',
                            'export/fcsNotificationOK/sqlfilenumber',
                            'export/fcsNotificationZK/sqlfilenumber',
                            'fcsNotificationZK/sqlfilenumber',
                            'fcsNotificationEP/sqlfilenumber',
                            'export/fcsNotificationZP/sqlfilenumber',
                            'export/fcsNotificationPO/sqlfilenumber',
                            'export/fcsNotificationISM/sqlfilenumber',
                            'export/fcsNotificationOKOU/sqlfilenumber'],
          'purchaseObjectInfo'=>['export/fcsNotificationEP/purchaseObjectInfo',
                                'export/fcsNotificationEF/purchaseObjectInfo',
                                'export/fcsNotificationOK/purchaseObjectInfo',
                                'export/fcsNotificationZK/purchaseObjectInfo',
                                'fcsNotificationZK/purchaseObjectInfo',
                                'fcsNotificationEP/purchaseObjectInfo',
                                'export/fcsNotificationZP/purchaseObjectInfo',
                                'export/fcsNotificationPO/purchaseObjectInfo',
                                'export/fcsNotificationISM/purchaseObjectInfo',
                                'export/fcsNotificationOKOU/purchaseObjectInfo',
                                'export/fcsClarification/addInfo',
                                'export/fcsPurchaseDocument/addInfo'],
          'docPublishDate'=>['export/fcsNotificationEP/docPublishDate',
                            'export/fcsNotificationEF/docPublishDate',
                            'export/fcsNotificationOK/docPublishDate',
                            'export/fcsNotificationZK/docPublishDate',
                            'fcsNotificationZK/docPublishDate',
                            'fcsNotificationEP/docPublishDate',
                            'export/fcsNotificationZP/docPublishDate',
                            'export/fcsNotificationPO/docPublishDate',
                            'export/fcsNotificationISM/docPublishDate',
                            'export/fcsNotificationOKOU/docPublishDate',
                            'export/fcsClarification/docPublishDate',
                            'export/fcsPurchaseDocument/docPublishDate'],
          'ETP'=>['export/fcsNotificationEP/ETP/code',
                    'export/fcsNotificationEF/ETP/code',
                    'export/fcsNotificationOK/ETP/code',
                    'export/fcsNotificationZK/ETP/code',
                    'fcsNotificationZK/ETP/code',
                    'fcsNotificationEP/ETP/code',
                    'export/fcsNotificationZP/ETP/code',
                    'export/fcsNotificationPO/ETP/code',
                    'export/fcsNotificationISM/ETP/code',
                    'export/fcsNotificationOKOU/ETP/code'],
          'startDate'=>['export/fcsNotificationEP/procedureInfo/collecting/startDate',
                        'export/fcsNotificationEF/procedureInfo/collecting/startDate',
                        'export/fcsNotificationOK/procedureInfo/collecting/startDate',
                        'export/fcsNotificationZK/procedureInfo/collecting/startDate',
                        'fcsNotificationZK/procedureInfo/collecting/startDate',
                        'fcsNotificationEP/procedureInfo/collecting/startDate',
                        'export/fcsNotificationPO/procedureInfo/collecting/startDate',
                        'export/fcsNotificationZP/procedureInfo/collecting/startDate',
                        'export/fcsNotificationISM/procedureInfo/collecting/startDate',
                        'export/fcsNotificationOKOU/procedureInfo/collecting/startDate'],
          'endDate'=>['export/fcsNotificationEP/procedureInfo/collecting/endDate',
                        'export/fcsNotificationEF/procedureInfo/collecting/endDate',
                        'export/fcsNotificationOK/procedureInfo/collecting/endDate',
                        'export/fcsNotificationZK/procedureInfo/collecting/endDate',
                        'fcsNotificationZK/procedureInfo/collecting/endDate',
                        'fcsNotificationEP/procedureInfo/collecting/endDate',
                        'export/fcsNotificationPO/procedureInfo/collecting/endDate',
                        'export/fcsNotificationZP/procedureInfo/collecting/endDate',
                        'export/fcsNotificationISM/procedureInfo/collecting/endDate',
                        'export/fcsNotificationOKOU/procedureInfo/collecting/endDate'],
          'biddingDate'=>['export/fcsNotificationEP/procedureInfo/bidding/date',
                        'export/fcsNotificationEF/procedureInfo/bidding/date',
                        'export/fcsNotificationOK/procedureInfo/bidding/date',
                        'export/fcsNotificationZK/procedureInfo/bidding/date',
                        'fcsNotificationZK/procedureInfo/bidding/date',
                        'fcsNotificationEP/procedureInfo/bidding/date',
                        'export/fcsNotificationPO/procedureInfo/bidding/date',
                        'export/fcsNotificationZP/procedureInfo/bidding/date',
                        'export/fcsNotificationISM/procedureInfo/bidding/date',
                        'export/fcsNotificationOKOU/procedureInfo/bidding/date'],
          'deliveryPlace'=>['export/fcsNotificationEP/lot/customerRequirements/customerRequirement/deliveryPlace',
                            'export/fcsNotificationEF/lot/customerRequirements/customerRequirement/deliveryPlace',
                            'export/fcsNotificationOK/lot/customerRequirements/customerRequirement/deliveryPlace',
                            'export/fcsNotificationZK/lot/customerRequirements/customerRequirement/deliveryPlace',
                            'fcsNotificationZK/lot/customerRequirements/customerRequirement/deliveryPlace',
                            'fcsNotificationEP/lot/customerRequirements/customerRequirement/deliveryPlace',
                            'export/fcsNotificationPO/lot/customerRequirements/customerRequirement/deliveryPlace',
                            'export/fcsNotificationZP/lot/customerRequirements/customerRequirement/deliveryPlace',
                            'export/fcsNotificationISM/lot/customerRequirements/customerRequirement/deliveryPlace',
                            'export/fcsNotificationOKOU/lot/customerRequirements/customerRequirement/deliveryPlace'],
          'href'=>['export/fcsNotificationEP/href',
                'export/fcsNotificationEF/href',
                'export/fcsNotificationOK/href',
                'export/fcsNotificationZK/href',
                'fcsNotificationZK/href',
                'fcsNotificationEP/href',
                'export/fcsNotificationPO/href',
                'export/fcsNotificationZP/href',
                'export/fcsNotificationISM/href',
                'export/fcsNotificationOKOU/href',
                'export/fcsClarification/attachments/attachment/url',
                'export/fcsPurchaseDocument/attachments/attachment/url'],
          'restrictInfo'=>['export/fcsNotificationEP/lot/restrictInfo',
                            'export/fcsNotificationEF/lot/restrictInfo',
                            'export/fcsNotificationOK/lot/restrictInfo',
                            'export/fcsNotificationZK/lot/restrictInfo',
                            'fcsNotificationZK/lot/restrictInfo',
                            'fcsNotificationEP/lot/restrictInfo',
                            'export/fcsNotificationZP/lot/restrictInfo',
                            'export/fcsNotificationPO/lot/restrictInfo',
                            'export/fcsNotificationISM/lot/restrictInfo',
                            'export/fcsNotificationOKOU/lot/restrictInfo'],
          'deliveryTerm'=>['export/fcsNotificationEP/lot/customerRequirements/customerRequirement/deliveryTerm',
                            'export/fcsNotificationEF/lot/customerRequirements/customerRequirement/deliveryTerm',
                             'export/fcsNotificationOK/lot/customerRequirements/customerRequirement/deliveryTerm',
                             'export/fcsNotificationZK/lot/customerRequirements/customerRequirement/deliveryTerm',
                             'fcsNotificationZK/lot/customerRequirements/customerRequirement/deliveryTerm',
                             'fcsNotificationEP/lot/customerRequirements/customerRequirement/deliveryTerm',
                            'export/fcsNotificationZP/lot/customerRequirements/customerRequirement/deliveryTerm',
                            'export/fcsNotificationPO/lot/customerRequirements/customerRequirement/deliveryTerm',
                            'export/fcsNotificationISM/lot/customerRequirements/customerRequirement/deliveryTerm',
                            'export/fcsNotificationOKOU/lot/customerRequirements/customerRequirement/deliveryTerm'],
          'placingWay'=>['export/fcsNotificationEP/placingWay/code',
                        'export/fcsNotificationEF/placingWay/code',
                        'export/fcsNotificationOK/placingWay/code',
                        'export/fcsNotificationZK/placingWay/code',
                        'fcsNotificationZK/placingWay/code',
                        'fcsNotificationEP/placingWay/code',
                        'export/fcsNotificationZP/placingWay/code',
                        'export/fcsNotificationPO/placingWay/code',
                        'export/fcsNotificationISM/placingWay/code',
                        'export/fcsNotificationOKOU/placingWay/code'],
            'canselId'=>['export/fcsNotificationCancel/purchaseNumber'],
            'prolongId'=>['export/fcsPurchaseProlongationZK/purchaseNumber',
                'export/fcsPurchaseProlongationEP/purchaseNumber',
                'export/fcsPurchaseProlongationEF/purchaseNumber',
                'export/fcsPurchaseProlongationOK/purchaseNumber',
                'export/fcsPurchaseProlongationZP/purchaseNumber',
                'export/fcsPurchaseProlongationPO/purchaseNumber',
                'export/fcsPurchaseProlongationISM/purchaseNumber',
                'export/fcsPurchaseProlongationOKOU/purchaseNumber',
                ],
            'contractNumber'=>['export/fcsContractSign/number'],
            'price'=>['export/fcsContractSign/price']

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
