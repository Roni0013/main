<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models;
use app\models\baseXmlSql;

/**
 * Description of myproduct
 *
 * @author roni
 */
class myproduct extends baseXmlSql{

    public  $sid;
    public  $price;
    public  $quantity;
    public  $sum;
    public  $contract_id;
    public  $sqlfilenumber;


    public  $OKPD;
    public  $name;



    public function rules() {
        return [
            [['sid', 'name', 'price', 'quantity', 'sum', 'OKPD', 'contract_id', 'sqlfilenumber'], 'safe']
        ];
    }

    public static function tableSql() {
        return 'product';
    }

    public static function intValues() {
        return 6;
    }

    public function xrules() {
        return [
          'sid'=>['product/sid'],
          'price'=>['product/price'],
          'quantity'=>['product/quantity'],
          'sum'=>['product/sum'],
          'contract_id'=>[$this->contract_id],
          'sqlfilenumber'=>[$this->sqlfilenumber],
          'OKPD'=>['product/OKPD/code', 'product/OKPD'],
          'name'=>['product/name'],
        ];
    }
}

