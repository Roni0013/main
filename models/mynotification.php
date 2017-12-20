<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models;
use yii\base\Model;
/**
 * Description of mynotification
 *
 * @author roni
 */
class mynotification extends Model{
    public  $id;
    public  $purchaseNumber;
    public  $docPublishDate;
    public  $href;
    public  $purchaseObjectInfo;
    public  $customer;
    public  $maxPrice;
    public  $OKPD;
    public  $OKEI;
    public  $restrictInfo;
    public  $ETP;  // электронная площадка
    public  $biddingDate;
    public  $deliveryPlace;








    public function rules() {
        return [
            [['id', 'regNum',
            'price', 'supplier_id', 'customer', 'singlereason_id', 'number',
            'signDate', 'publishDate','versionNumber', 'href',
            'currentContractStage', 'protocolDate', 'documentBase'], 'safe']
        ];
    }
}
