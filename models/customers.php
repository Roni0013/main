<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models;
use yii\db\ActiveRecord;
/**
 * Description of customers
 *
 * @author roni
 */
class customers extends ActiveRecord{
    public static function tableName() {
        return 'customers';
    }
}
