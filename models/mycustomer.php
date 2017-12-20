<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models;
use yii\base\Model;


/**
 * Description of mycontract
 *
 * @author roni
 */
class mycustomer extends Model{

    public  $id;
    public  $KPP;
    public  $OGRN;
    public  $OKPO;
    public  $subordinationType;
    public  $timeZone;
    public  $regNumber;



    public  $shortName;
    public  $fullName;
    public  $INN;
    public  $registrationDate;
    public  $timeZoneUtcOffset;
    public  $timeZoneOlson;
    public  $actual;
    public  $register;
    public  $postalAddress;
    public  $phone;
    public  $fax;

//    public function table() {
//        return 'customer';
//    }



    public function rules() {
        return [
            [['id', 'regNumber',
            'shortName', 'fullName', 'INN', 'KPP', 'registrationDate',
            'OGRN', 'OKPO',
//                'organizationRole',
                'subordinationType', 'timeZone',
            'timeZoneUtcOffset', 'timeZoneOlson', 'actual', 'register', 'postalAddress', 'phone', 'fax'], 'safe']
        ];
    }
}
