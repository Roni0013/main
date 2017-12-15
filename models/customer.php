<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models;
use yii\db\ActiveRecord;

/**
 * Description of customer
 *
 * @author roni
 */
class customer extends ActiveRecord {

//    public static $id;
//    public static $regNumber;
//
//    public static $shortName;
//    public static $fullName;
//    public static $INN;
//    public static $KPP;
//    public static $registrationDate;
//    public static $OGRN;
//    public static $OKPO;
//    public static $organizationRole;
//    public static $subordinationType;
//    public static $timeZone;
//    public static $timeZoneUtcOffset;
//    public static $timeZoneOlson;
//    public static $actual;
//    public static $register;
//    public static $postalAddress;
//    public static $phone;
//    public static $fax;





    public static function tableName() {
        return 'customer';
    }

    //с проверкой на наличие regNumber в массиве arr
    public function save($runValidation = true, $attributeNames = null, $arr = []) {
//        var_dump ($arr);
        if (!in_array($this->getAttribute('regNumber'), $arr)) {
            parent::save($runValidation, $attributeNames);
            return TRUE;
        }
        else {
            return FALSE;
        }
    }

    public function rules() {
        return [
            [['id', 'regNumber',
            'shortName', 'fullName', 'INN', 'KPP', 'registrationDate',
            'OGRN', 'OKPO', 'organizationRole', 'subordinationType', 'timeZone',
            'timeZoneUtcOffset', 'timeZoneOlson', 'actual', 'register', 'postalAddress', 'phone', 'fax'], 'safe']
        ];
    }

    public function getAddress (){
        return $this->hasOne (factualAddress::className(),['id'=>'factualAddress_id'])->inverseOf('customer');
    }


}
