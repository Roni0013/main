<?php


namespace app\models;

use yii\db\ActiveRecord;

/**
 * Description of product
 *
 * @author roni
 */
class product extends ActiveRecord {


    public static function tableName() {
        return 'product';
    }

 public function getContract() {
        return $this->hasOne(contract::className(), ['id'=>'contract_id']);
    }


    public function rules() {
        return [
            [['id', 'sid', 'name', 'price', 'quantity', 'sum'], 'safe']

        ];
    }

}
