<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models;
use yii\db\ActiveRecord;
/**
 * Description of Contract
 *
 * @author roni
 */
class Contract extends ActiveRecord {



    public static function tableName() {
        return 'contract';
    }

    public function save($runValidation = true, $attributeNames = null, $arr = []) {
//        var_dump ($arr); var_dump ($this->getAttribute('id')); var_dump(in_array($this->getAttribute('id'), $arr));  die;
        if (!in_array($this->getAttribute('id'), $arr)) {
            parent::save($runValidation, $attributeNames);
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function rules() {
        return [
            [['id', 'regNum', 'number', 'publishDate', 'signDate', 'versionNumber',
            'price', 'href', 'currentContractStage', 'protocolDate', 'protocolDate', 'documentBase',
            'customer_id',  'supplier_id', 'priceInfo_id', 'placer_id', 'fileName', 'fileName'], 'safe']
        ];
    }

    public function getSupplier() {
        return $this->hasOne(supplier::className(), ['id'=>'supplier_id'])->inverseOf('contract');
    }

    public function getProduct() {
        return $this->hasMany(product::className(), ['id'=>'product_id'])->viaTable('contract_product', ['contract_id'=>'id']);
    }


    public function dateFormat() {
        $pattern = '/^\d{4}-\d{2}-\d{2}/';


        if ($this->getAttribute('publishDate')) {
            preg_match($pattern, $this->getAttribute('publishDate'), $resMatch1);
        }
        if ($this->getAttribute('signDate')) {
            preg_match($pattern, $this->getAttribute('signDate'), $resMatch2);
        }
        if ($this->getAttribute('protocolDate')) {
            preg_match($pattern, $this->getAttribute('protocolDate'), $resMatch3);
        }
        if (isset($resMatch1)) {
        $this->setAttribute('publishDate', $resMatch1[0]);
        }
        if (isset($resMatch2)) {
        $this->setAttribute('signDate', $resMatch2[0]);
        }
        if (isset($resMatch3)) {
        $this->setAttribute('protocolDate', $resMatch3[0]);
        }
    }

}
