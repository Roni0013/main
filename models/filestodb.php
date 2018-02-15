<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models;
use yii\db\ActiveRecord;
/**
 * Description of filestodb
 *
 * @author roni
 */
class filestodb extends ActiveRecord{
    //put your code here

    public function rules() {
        return [
            [['id', 'tablename','number'], 'safe']
        ];
    }
}
