<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models;
use app\models\baseXmlSql;

/**
 * Description of myokpd2
 *
 * @author roni
 */
class myokpd2 extends baseXmlSql{

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
          'id'=>['nsiOKPD2/id'],
          'parentId'=>['nsiOKPD2/parentId'],
          'code'=>['nsiOKPD2/code'],
          'name'=>['nsiOKPD2/name'],
          'actual'=>['nsiOKPD2/actual'],
          'parentCode'=>['nsiOKPD2/parentCode'],

        ];
    }
}
