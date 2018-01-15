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
             'factualAddress', 'postAddress','organizationName',
            'contactEmail', 'contactPhone','contactFax', 'isIP',
            'lastName'], 'string'],
            [['inn','kpp','sqlfilenumber'],'integer']
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
              'export/contract/suppliers/supplier/inn',
              'export/contract/suppliers/supplier/legalEntityRF/INN',
              'export/contract/suppliers/supplier/individualPersonRF/INN',
              'export/contract/suppliers/supplier/INN'

              ],
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
            'contactEMail'=>[
              'export/contract/suppliers/supplier/legalEntityRF/contactEMail',
              'export/contract/suppliers/supplier/individualPersonRF/contactEMail',
              'export/contract/suppliers/supplier/contactEMail'],
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
              'export/contract/suppliers/supplier/contactInfo/lastName',
              'export/contract/suppliers/supplier/individualPersonRF/lastName',
              'export/contract/suppliers/supplier/legalEntityRF/lastName',
                ]
        ];
    }
}
