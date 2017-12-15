<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models;
use yii\db\ActiveRecord;
/**
 * Description of area
 *
 * @author roni
 */
class area extends ActiveRecord{



    public function rules() {
        return [
            [['id', 'kladrType','kladrCode', 'fullName'], 'safe']
        ];
    }

    public function getFactualAddress() {
        return $this->hasMany(factualAddress::className(), ['area_id'=>'id'])->inverseOf('area');
    }
}
