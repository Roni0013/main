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
    public  $contract_id;



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
            [['inn','kpp','sqlfilenumber','contract_id'],'integer']
        ];
    }

     public static function tableSql() {
        return 'supplier';
    }



    public static function intValues() {
        return 4;
    }

    public function xrules() {
        return [
          'inn'=>[
              'supplier/legalEntityRF/inn',
              'supplier/individualPersonRF/inn',
              'supplier/inn',
              'supplier/legalEntityRF/INN',
              'supplier/individualPersonRF/INN',
              'supplier/INN'

              ],
          'kpp'=>[
              'supplier/legalEntityRF/kpp',
              'supplier/individualPersonRF/kpp',
              'supplier/kpp'],
          'sqlfilenumber' => [$this->sqlfilenumber],
          'participantType'=>[
              'supplier/legalEntityRF/participantType',
              'supplier/individualPersonRF/participantType',
              'supplier/participantType'],
            'organizationName'=>[
                'supplier/legalEntityRF/fullName',
                'supplier/organizationName'],
            'factualAddress'=>[
              'supplier/legalEntityRF/factualAddress',
              'supplier/individualPersonRF/factualAddress',
              'supplier/factualAddress'],
            'postAddress'=>[
              'supplier/legalEntityRF/postAddress',
              'supplier/individualPersonRF/postAddress',
              'supplier/postAddress'],
            'contactEMail'=>[
              'supplier/legalEntityRF/contactEMail',
              'supplier/individualPersonRF/contactEMail',
              'supplier/contactEMail'],
            'contactPhone'=>[
              'supplier/legalEntityRF/contactPhone',
              'supplier/individualPersonRF/contactPhone',
              'supplier/contactPhone'],
            'contactFax'=>[
              'supplier/legalEntityRF/contactFax',
              'supplier/individualPersonRF/contactFax',
              'supplier/contactFax'],
            'isIP'=>[
              'supplier/legalEntityRF/isIP',
              'supplier/individualPersonRF/isIP',
              'supplier/isIP'],
            'lastName'=>[
              'supplier/contactInfo/lastName',
              'supplier/individualPersonRF/lastName',
              'supplier/legalEntityRF/lastName',
                ],
            'contract_id'=>[$this->contract_id],
        ];
    }
}
