<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models;
use yii\db\ActiveRecord;

/**
 * Description of contract
 *
 * @author roni
 *
 *
 */
class contract  extends ActiveRecord{

    public function getProduct() {
        return $this->hasMany(product::className(), ['contract_id'=>'id']);
    }

    public function getSupplier() {
        return $this->hasMany(supplier::className(), ['contract_id'=>'id']);
    }

    public static function tableName() {
        return 'contract';
    }
}
