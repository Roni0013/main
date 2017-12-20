<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models;
use yii\base\Model;

/**
 * Description of myproduct
 *
 * @author roni
 */
class myproduct extends Model{

    public  $sid;
    public  $price;
    public  $quantity;
    public  $sum;
    public  $contract_id;
    public  $OKPD;
    public  $name;



    public function rules() {
        return [
            [['sid', 'name', 'price', 'quantity', 'sum', 'OKPD', 'contract_id'], 'safe']
        ];
    }

}

