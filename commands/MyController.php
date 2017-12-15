<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\commands;
use yii\console\Controller;

/**
 * Description of MyController
 *
 * @author roni
 */
class MyController extends Controller {
    //put your code here


    public function getXmlArray($xmlText) {
        $xmlObject = new xmlToArrayParser($xmlText);
        $xmlArray = $xmlObject->array;
        unset($xmlObject);
        return $xmlArray;
    }

    public function getXmlBits($xmlFileName, $tag) {
        $xmltext = file_get_contents($xmlFileName);
        $xmltext = preg_replace('/oos:/', '', $xmltext);
        $xmltext = preg_replace('/ns2:/', '', $xmltext);
        preg_match_all('/<' . $tag . '>.*?<\/' . $tag . '>/', $xmltext, $xmltextBits);
        return $xmltextBits[0];
    }

    public static function delArrays($arr) {
        $result = [];
        foreach ($arr as $key => $value) {
            if (!is_array($value)) {
                $result[$key] = $value;
            }
        }
        return $result;
    }
}
