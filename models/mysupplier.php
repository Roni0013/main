<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models;
use yii\base\Model;
/**
 * Description of mysupplier
 *
 * @author roni
 */
class mysupplier extends Model{

    public $id;
    public $inn;
    public $kpp;
    


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
            [['id', 'participantType',
            'inn', 'kpp', 'organizationName', 'factualAddress', 'postAddress',
            'contactEmail', 'contactPhone','contactFax', 'isIP',
            'lastName'], 'safe']
        ];
    }
}
