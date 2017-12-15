<?php

namespace app\models;
use yii\db\ActiveRecord;

class notification extends ActiveRecord{
    public function rules () {
        return ['okpd' ,'request'];

    }

    public function getOkpd() {
        return $this->hasOne(okpd::className(),['code'=>'OKPD']);

    }
    public function getCustomer () {
        return $this->hasOne(customer::className(),['id'=>'custNumber']);
    }
}
