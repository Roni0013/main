<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models;
use app\models\baseXmlSql;
/**
 * Description of mycontract
 *
 * @author roni
 */
class mycontract extends baseXmlSql{
    public $id;
    public $regNum;
    public $price;
//    public $price2;
    public $supplierInn;
    public $customer;
    public $singlereason_id;
    public $sqlfilenumber;



    public $number;
    public $signDate;
    public $publishDate;
    public $versionNumber;
    public $href;
    public $currentContractStage;
    public $protocolDate;
    public $documentBase;
    public $responsible_id;


    public function rules() {
        return [
            [['id', 'regNum',
            'price',
//                'price2',
                'supplier_id', 'customer', 'singlereason_id', 'number',
            'signDate', 'publishDate','versionNumber', 'href',
            'currentContractStage', 'protocolDate', 'documentBase','sqlfilenumber','supplierInn'], 'safe']
        ];
    }

    public static function tableSql() {
        return 'contract';
    }

    public static function intValues() {
        return 7;
    }

    public function xrules() {
        return [
          'id'=>['export/contract/id'],
          'regNum'=>['export/contract/regNum'],
          'price'=>['export/contract/priceInfo/price', 'export/contract/price'],
          'supplierInn'=>[
                            'export/contract/suppliers/supplier/legalEntityRF/INN',
                            'export/contract/suppliers/supplier/INN',
                            'export/contract/suppliers/individualPersonRF/INN',
                            'export/contract/suppliers/supplier/legalEntityRF/inn',
                            'export/contract/suppliers/supplier/inn',
                            'export/contract/suppliers/individualPersonRF/inn',
              ],
          'customer'=>['export/contract/customer/regNum'],
          'singlereason_id'=>['export/contract/singleCustomerReason/id','export/contract/foundation/fcsOrder/order/singleCustomer/reason/code'],
          'sqlfilenumber'=>[$this->sqlfilenumber],
          'singlereason_id'=>['export/contract/singleCustomerReason/id'],
          'number'=>['export/contract/number'],
          'signDate'=>['export/contract/signDate'],
          'publishDate'=>['export/contract/publishDate'],
          'versionNumber'=>['export/contract/versionNumber'],
          'href'=>['export/contract/href'],
          'currentContractStage'=>['export/contract/currentContractStage'],
          'protocolDate'=>['export/contract/protocolDate'],
          'documentBase'=>['export/contract/documentBase'],
          'responsible_id'=>['export/contract/placer/responsibleOrg/regNum','export/contract/'],

        ];
    }

    public function replace($key, $text) {
        if (($key == 'publishDate') or ($key == 'signDate') or ($key == 'protocolDate')) {
            $pattern = '/^\d{4}-\d{2}-\d{2}/';
//            print_r($key . '  '. $text);
            preg_match($pattern, $text, $resMatch);
//            print_r($resMatch)[0]; sleep (1);
            if (isset ($resMatch[0])) {
                return $resMatch[0];
            }else {
                return '';
            }
        }
        return trim($text);
    }


}
