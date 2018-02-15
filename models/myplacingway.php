<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models;
use app\models\baseXmlSql;
/**
 * Description of placingway
 *
 * @author roni
 */
class myplacingway extends baseXmlSql{
    public $id;

    public $actual;
    public $code;
    public $name;
    public $type;
    public $subsystemType;


     public function rules() {
        return [
            [['code','name', 'type', 'subsystemType','actual'], 'safe'],
            [['id'], 'integer'],

        ];
    }

     public static function tableSql() {
        return 'placingway';
    }

    public static function intValues() {
        return 1;
    }

    public function xrules() {
        return [
          'id'=>['nsiPlacingWay/placingWayId'],
          'code'=>['nsiPlacingWay/code'],
          'name'=>['nsiPlacingWay/name'],
          'type'=>['nsiPlacingWay/type'],
          'subsystemType'=>['nsiPlacingWay/subsystemType'],
          'actual'=>['nsiPlacingWay/actual'],


        ];
    }

}
