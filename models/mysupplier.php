<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models;
use app\models\baseXmlSql;
/**
 * Description of mysupplier
 *
 * @author roni
 */
class mysupplier extends baseXmlSql{

//    public $id;
    public $inn;
    public $kpp;
    public $sqlfilenumber;



    public $participantType;
    public $organizationName;
    public $factualAddress;
    public $postAddress;
    public $contactEmail;
    public $contactPhone;
    public $contactFax;
    public $isIP;
    public $lastName;


    public function rules() {
        return [
            [[
//                'id',
                'participantType',
            'inn', 'kpp', 'organizationName', 'factualAddress', 'postAddress',
            'contactEmail', 'contactPhone','contactFax', 'isIP',
            'lastName','sqlfilenumber'], 'safe']
        ];
    }

     public static function tableSql() {
        return 'supplier';
    }



    public static function intValues() {
        return 3;
    }

    public function xrules() {
        return [
          'inn'=>[
              'export/contract/suppliers/supplier/legalEntityRF/inn',
              'export/contract/suppliers/supplier/individualPersonRF/inn',
              'export/contract/suppliers/supplier/inn'],
          'kpp'=>[
              'export/contract/suppliers/supplier/legalEntityRF/kpp',
              'export/contract/suppliers/supplier/individualPersonRF/kpp',
              'export/contract/suppliers/supplier/kpp'],
          'sqlfilenumber' => [$this->sqlfilenumber],
          'participantType'=>[
              'export/contract/suppliers/supplier/legalEntityRF/participantType',
              'export/contract/suppliers/supplier/individualPersonRF/participantType',
              'export/contract/suppliers/supplier/participantType'],
            'organizationName'=>[
                'export/contract/suppliers/supplier/legalEntityRF/fullName',
                'export/contract/suppliers/supplier/organizationName'],
            'factualAddress'=>[
              'export/contract/suppliers/supplier/legalEntityRF/factualAddress',
              'export/contract/suppliers/supplier/individualPersonRF/factualAddress',
              'export/contract/suppliers/supplier/factualAddress'],
            'postAddress'=>[
              'export/contract/suppliers/supplier/legalEntityRF/postAddress',
              'export/contract/suppliers/supplier/individualPersonRF/postAddress',
              'export/contract/suppliers/supplier/postAddress'],
            'contactEmail'=>[
              'export/contract/suppliers/supplier/legalEntityRF/contactEmail',
              'export/contract/suppliers/supplier/individualPersonRF/contactEmail',
              'export/contract/suppliers/supplier/contactEmail'],
            'contactPhone'=>[
              'export/contract/suppliers/supplier/legalEntityRF/contactPhone',
              'export/contract/suppliers/supplier/individualPersonRF/contactPhone',
              'export/contract/suppliers/supplier/contactPhone'],
            'contactFax'=>[
              'export/contract/suppliers/supplier/legalEntityRF/contactFax',
              'export/contract/suppliers/supplier/individualPersonRF/contactFax',
              'export/contract/suppliers/supplier/contactFax'],
            'isIP'=>[
              'export/contract/suppliers/supplier/legalEntityRF/isIP',
              'export/contract/suppliers/supplier/individualPersonRF/isIP',
              'export/contract/suppliers/supplier/isIP'],
            'lastName'=>[
              'export/contract/suppliers/supplier/contactInfo/lastName']
        ];
    }
}
