<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models;
use app\models\baseXmlSql;
/**
 * Description of mypurches
 *
 * @author roni
 */
class mypurchase extends baseXmlSql{

    public $OKEI;
    public $price;
    public $quantity;
    public $sum;
    public $notification_id;
    public $sqlfilenumber;

    public $OKPD;
    public $name;


    public function rules() {
        return [
            [['OKPD', 'name','OKEI', 'quantity', 'price', 'sum', 'notification_id','sqlfilenumber'], 'safe']
        ];
    }
    
     public static function tableSql() {
        return 'purchase';
    }

    public static function intValues() {
        return 6;
    }

    public function xrules() {
        return [
          'OKEI'=>['purchaseObject/OKEI/code'], 
          'price'=>['purchaseObject/price'], 
          'quantity'=>['purchaseObject/quantity/value'], 
          'sum'=>['purchaseObject/sum'], 
          'notification_id'=>[$this->notification_id], 
          'sqlfilenumber'=>[$this->sqlfilenumber], 
          'OKPD'=>['purchaseObject/OKPD/code'], 
          'name'=>['purchaseObject/name'], 

        ];
    }
}
