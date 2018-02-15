<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models;
use app\models\baseXmlSql;
/**
 * Description of myokei
 *
 * @author roni
 */
class myokei extends baseXmlSql{
    public $code;

    public $fullName;
    public $localName;
    public $actual;

    public function rules() {
        return [
            [['code', 'fullName','localName', 'actual'], 'safe']
        ];
    }

    public static function tableSql() {
        return 'okei';
    }

//     public static function path() {
//        return 'resource/okei';
//    }

    public static function intValues() {
        return 1;
    }

    public function xrules() {
        return [
          'code'=>['nsiOKEI/code'],
          'fullName'=>['nsiOKEI/fullName'],
          'localName'=>['nsiOKEI/localName'],
          'actual'=>['nsiOKEI/actual'],

        ];
    }

}
