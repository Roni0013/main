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
class mycontract extends Model{
    public $id;
    public $regNum;
    public $price;
    public $supplier_id;
    public $customer;
    public $singlereason_id;


    public $number;
    public $signDate;
    public $publishDate;
    public $versionNumber;
    public $href;
    public $currentContractStage;
    public $protocolDate;
    public $documentBase;

    public function rules() {
        return [
            [['id', 'regNum',
            'price', 'supplier_id', 'customer', 'singlereason_id', 'number',
            'signDate', 'publishDate','versionNumber', 'href',
            'currentContractStage', 'protocolDate', 'documentBase'], 'safe']
        ];
    }


    public function dateFormat() {
        $pattern = '/^\d{4}-\d{2}-\d{2}/';
        $attrs = $this->getAttributes();

        if (isset($attrs['publishDate'])) {
            preg_match($pattern, $attrs['publishDate'], $resMatch1);
        }
        if (isset($attrs['signDate'])) {
            preg_match($pattern, $attrs['signDate'], $resMatch2);
        }
        if (isset($attrs['protocolDate'])) {
            preg_match($pattern, $attrs['protocolDate'], $resMatch3);
        }
        if (isset($resMatch1)) {
        $this->setAttributes(['publishDate' => $resMatch1[0]]);
        }
        if (isset($resMatch2)) {
        $this->setAttributes(['signDate' => $resMatch2[0]]);
        }
        if (isset($resMatch3)) {
        $this->setAttributes(['protocolDate' => $resMatch3[0]]);
        }
    }


}
