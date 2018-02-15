<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models;
use app\models\baseXmlSql;

/**
 * Description of myokpd
 *
 * @author roni
 */
class myokpd extends baseXmlSql{
    public $id;
    public $parentId;

    public $code;
    public $name;
    public $actual;
    public $parentCode;


    public function rules() {
        return [
            [['id', 'code','name', 'actual', 'parentId', 'parentCode'], 'safe']
        ];
    }

    public static function tableSql() {
        return 'okpd';
    }


    public static function intValues() {
        return 2;
    }

    public function xrules() {
        return [
          'id'=>['nsiOKPD/id'],
          'parentId'=>['nsiOKPD/parentId'],
          'code'=>['nsiOKPD/code'],
          'name'=>['nsiOKPD/name'],
          'actual'=>['nsiOKPD/actual'],
          'parentCode'=>['nsiOKPD/parentCode'],

        ];
    }

}
