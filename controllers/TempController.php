<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\controllers;
use app\models\Contract;
/**
 * Description of tempController
 *
 * @author roni
 */
class TempController extends \yii\web\Controller {
    //put your code here

    public function actionIndex() {

        $contract = new \app\models\Contract;
        $contract->number = '15';
        $contract->save();
        return $this->render('temp', compact('contract'));

}

}
