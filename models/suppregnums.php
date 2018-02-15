<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models;
use yii\db\ActiveRecord;
/**
 * Description of suppliers_regnums
 *
 * @author roni
 */
class suppregnums extends ActiveRecord{
    public static function tableName() {
        return 'suppregnums';
    }

    public function getContracts() {
        return $this->hasOne(contracts::className(), ['regNum'=>'regNum']);
    }
}
