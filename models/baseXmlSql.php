<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models;
use yii\base\Model;
use app\commands\xmlToArrayParser;
use SimpleXMLElement;
/**
 * Description of baseXmlSql
 * Принимает XML текст и формирует строку sql
 *
 * @author roni
 */
class baseXmlSql extends Model{



    //сформировать начальную строку для INSERT INTO table () VALUES
    protected function _sqlInsert () {
        $table = static::tableSql();
        $fields = $this->_firstKeys();
        return "INSERT INTO $table $fields VALUES ";
    }

    //прием и обработка массива тесктов xml

    public function putXml (array $xmlText) {
        $insertLine = $this->_sqlInsert();
        $valueLine='';
        foreach ($xmlText as $xText) {

//          заполнить свойства из массива по
//          print_r ($xText); die;
            $valueLine .= $this->_getValuesLine($xText).",\n";
        }
        if (!empty($valueLine)) {
            $resultLine = $insertLine.$valueLine;
            $resultLine=rtrim($resultLine);
            $resultLine=rtrim($resultLine,',');
            $resultLine .= "; \n";
            return $resultLine;
        } else {
            return '';
        }
    }

    private function _firstKeys () {
        $keys = array_keys ($this->getAttributes());
        $stroka='(';
        foreach ($keys as $value) {
            $stroka .= $value . ',';
        }
        $stroka = rtrim($stroka, ',');
        $stroka .= ')';
        return $stroka;
    }

    protected function _removeUnnesesery ($text) {
        $text = preg_replace('/oos:/', '', $text);
        $text = preg_replace('/ns2:/', '', $text);
        $text = preg_replace('/<signature>.*?<\/signature>/', '', $text);
        $text = preg_replace('/<consRegistryNum>.*?<\/consRegistryNum>/', '', $text);
        $text = preg_replace('/<organizationRole>.*?<\/organizationRole>/', '', $text);
        $text = preg_replace('/&apos;/', '', $text);
        return $text;
    }
     private function _getValuesLine($xmlText = '') {
//         print_r ($xmlText); die;
//         массив из значений
         $valuesArr= $this->_setValuesSql($xmlText);
//         print_r ($valuesArr); die;
//        строка из значений
         $valuesLine = $this->_getLineFromArr ($valuesArr, $this->intValues());
         return $valuesLine;
     }


     private function _getLineFromArr ($values, $intCount) {
//        запомнить состояние обеъкта
         $objPrev=$this->getAttributes();

         $i = 1;
         $stroka = '(';
        $this->setAttributes($values);
//        print_r ($values); die;
//        $this->validate();
        foreach ($this as $key=>$value) {
            if (!is_array($value)) {
                if (!$this->validate([$key]) or $value=='') {
                    $value = 'NULL';
                }
                if (($i > $intCount) and ( $value <> 'NULL')) {
                    $stroka .= "'" . $value . "',";
                } else {
                    $stroka .= $value . ",";
                    $i++;
                }
            }
                $this->setAttributes([$key=>NULL]);
//            print_r ($stroka);
        }
//        print_r ($stroka); die;
        $this->setAttributes($objPrev);
        $stroka = rtrim($stroka, ',');
        $stroka .= ")";
        return $stroka;

     }


//  сформировать массив xml ключей и значений
    private function _setValuesSql($xmlText = '') {
        $resValuesArr = [];
        $xml = new xmlToArrayParser($xmlText);
        $xmlArray = $xml->array;
//        print_r ($xmlArray); die;
        foreach ($this->xrules() as $tableKey => $xValue) {
//            если поле установлено, то не заполнять
            if (!empty($this->{$tableKey})) {
                $resValuesArr[$tableKey] = $this->{$tableKey};
                continue;
            }
//            print_r ($resValuesArr); die;
            foreach ($xValue as $xVal) {
                $expl = explode('/', $xVal);
//                print_r ($expl); die;

                $resValuesArr[$tableKey] =   $this->replace($tableKey, $this->_getValFromArr($xmlArray, $expl));
//                print_r ($resValuesArr); die;
                if (!empty($resValuesArr[$tableKey])) {
                    break;
                }
            }
        }
        return $resValuesArr;
    }

//     получить значение по пути a/b/c рекурсия
     private function _getValFromArr(array $arrSearch, array $arrPath) {

        $key = array_shift($arrPath);
        if (isset($arrSearch[$key])) {
//                    print_r ($arrSearch[$key]); die;
            if (is_array($arrSearch[$key])) {
                return $this->_getValFromArr($arrSearch[$key], $arrPath);
            } elseif (empty($arrPath)) {
                return $arrSearch[$key];
            } else {
                return '';
            }
        }
    }

//    массив ключ=>значение, где ключ поле модели для заполнения, значение путь до значения в по дереву xml
    public function xrules() {
        return [];
    }

    public static function intValues() {
        return 0;
    }

    // определить имя в какую таблицу вставлять
    public static function tableSql() {
        return '';
    }
//               функция обработки, если нужно для date обрезать и т.д.
    public function replace($key, $text) {
        return trim($text);
    }

}
