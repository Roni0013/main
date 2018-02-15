<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models;
use app\models\baseXmlSql;
/**
 * Description of myokopf
 *
 * @author roni
 */
class myokopf extends baseXmlSql{
    public $code;

    public $fullName;
    public $singularName;
    public $actual;


    public function rules() {
        return [
            [['code', 'fullName','singularName', 'actual'], 'safe']
        ];
    }

    public static function tableSql() {
        return 'okopf';
    }


    public static function intValues() {
        return 1;
    }

    public function xrules() {
        return [
          'code'=>['nsiOKOPF/code'],
          'fullName'=>['nsiOKOPF/fullName'],
          'singularName'=>['nsiOKOPF/singularName'],
          'actual'=>['nsiOKOPF/actual'],
        ];
    }
}
