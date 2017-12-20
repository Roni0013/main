<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models;
use yii\base\Model;

/**
 * Description of myfactualaddress
 *
 * @author roni
 */
class myfactualaddress extends Model {
   public $id;
   public $kladrCode;
   public $building;
   public $OKATO;
   public $addressLine;
   public $filledManually;
   public $shortStreet;


   public function rules() {
       return [
         [['id','OKATO','addressLine','building','filledManually','shortStreet','kladrCode'],'safe']
       ];
   }

}
