<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models;

/**
 * Description of suppliers
 *
 * @author roni
 */
class suppliers extends \yii\db\ActiveRecord{




    public static function tableName() {
        return 'suppliers';
    }

//
//    public function rules() {
//        return [
//            [['id', 'participantType', 'inn', 'kpp', 'organizationName', 'factualAddress',
//            'postAddress', 'contactEMail', 'contactPhone', 'contactFax'], 'safe']
//        ];
//    }

}
