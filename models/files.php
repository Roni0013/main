<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models;
use yii\db\ActiveRecord;
/**
 * Description of files
 *
 * @author roni
 */
class files extends ActiveRecord{

    public function rules() {
        return [
          [['model','filename','time',]  , 'safe']
        ];
    }

}
