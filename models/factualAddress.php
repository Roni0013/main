<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models;
use yii\db\ActiveRecord;

/**
 * Description of factualAddress
 *
 * @author roni
 */
class factualAddress extends ActiveRecord {


    public static function tableName() {
        return 'factualAddress';
    }

    public function rules() {
        return [
            [['id', 'OKATO', 'addressLine', 'building', 'filledManually', 'shortStreet'], 'safe']
        ];
    }

    public function getCustomer() {
        return $this->hasMany(customer::className(), ['factualAddress_id' => 'id'])->inverseOf('factualAddress');
    }

    public function getArea() {
        return $this->hasOne(area::className(),['id'=>'area_id'])->inverseOf('factualAddress');
    }

    public function getRegion() {
        return $this->hasOne(region::className(),['id'=>'region_id'])->inverseOf('factualAddress');
    }

    public function getSettlement () {
        return $this->hasOne(region::className(),['id'=>'settlement_id'])->inverseOf('factualAddress');
    }



}