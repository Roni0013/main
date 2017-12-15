<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models;
use yii\db\ActiveRecord;

/**
 * Description of organiztionType
 *
 * @author roni
 */
class organizationType extends ActiveRecord {

    public static  function tableName() {
        return 'organizationType';
    }

    public function save($runValidation = true, $attributeNames = null, $arr = []) {
//        var_dump ($arr); die;
        if (!in_array($this->getAttribute('code'), $arr)) {
            parent::save($runValidation, $attributeNames);
        }
    }

    public function rules() {
        return [
            [['id','code','name','description'],'safe']
        ];
    }
}

