<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models;
use yii\db\ActiveRecord;
/**
 * Description of okmoppo
 *
 * @author roni
 */
class oktmoppo extends ActiveRecord {


    public function rules() {
        return [
            [['id','code','parentCode','name','OKTMOCode','settlementType','actual'],'safe']
        ];
    }

    public function save( $runValidation = true, $attributeNames = null, $arr = []) {
//        var_dump ($arr); die;
        if (!in_array($this->getAttribute('code'), $arr)) {
            parent::save($runValidation, $attributeNames);
        }

    }


}
