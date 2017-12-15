<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models;

use yii\db\ActiveRecord;
/**
 * Description of okpd
 *
 * @author roni
 */


class okpd  extends ActiveRecord {

public static  function tableName() {
        return 'okpd';
    }

public function save($runValidation = true, $attributeNames = null, $arr = []) {
//        var_dump ($arr); die;
        if (!in_array($this->getAttribute('code'), $arr)) {
            parent::save($runValidation, $attributeNames);
        }
    }



    public function getNotification() {
        $this->hasMany (notification::className(), ['OKPD'=>'code']);
    }

    public function rules() {
        return [
            [['id', 'code','name','actual','parentId','parentCode'], 'safe']
        ];
    }


}