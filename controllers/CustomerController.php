<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\controllers;
use yii\web\Controller;
use app\models\customers;

/**
 * Description of CustomerController
 *
 * @author roni
 */
class CustomerController  extends Controller{

    public function actionFormcustomer() {
        return $this->render('formcust');
    }

    public function actionItemcustomer() {
           $post = \Yii::$app->request->post();
           $fullName = $post['customers']['fullName'];

           $custObj = new customers();
           $custInfo = $custObj->find()->where(['like','fullName',$fullName])->limit(100)->all();
//           debug ($custInfo);
           return $this->render('findcust', compact('custInfo'));
    }
    public function actionCustomerinfo($regNum='') {
        if (empty($regNum)) {
            $get = \Yii::$app->request->get();
            $regNum = $get['id'];
        }

        $custInfo = customers::findAll($regNum);
        $sql="SELECT su.orgname,su.inn,count(*) as kol, sum(c.price) as price FROM customers cu INNER JOIN contracts c ON cu.regNumber = c.customer INNER JOIN suppregnums sr ON sr.regNum = c.regNum Inner join suppliers su on su.inn=sr.inn WHERE cu.regNumber = :regNumber group by su.orgname,su.inn";
        $custContracts=\Yii::$app->db->createCommand($sql)->bindValue(':regNumber', $regNum)->queryAll();
//              debug ($custContracts);
        return $this->render ('custinfo', compact ('custInfo','custContracts'));
    }
}
