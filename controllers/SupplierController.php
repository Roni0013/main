<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\controllers;

use yii\web\Controller;
use yii\helpers\Html;

/**
 * Description of SupplierController
 *
 * @author roni
 */
class SupplierController extends Controller {

    public function actionFormsupplier() {
        $post = \Yii::$app->request->post();
        $supp_obj = new \app\models\suppliers;
        $suppInfo='';
        if (!empty( $post['suppliers']['orgname'])) {
            $suppName = $post['suppliers']['orgname'];
            $suppInfo = $supp_obj->find()->where(['like','orgname',$suppName])->all();
        } elseif (!empty($post['suppliers']['inn'])) {
           $suppInn =  $post['suppliers']['inn'];
           $suppInfo = $supp_obj->find()->where(['inn'=>$suppInn])->all();
        }

        return $this->render('formsupp',compact('suppInfo'));
    }

    public function actionItemsupplier() {
        $post = \Yii::$app->request->post();
//        debug ($post);
        $supp_obj = new \app\models\suppliers;
        if (!empty( $post['suppliers']['orgname'])) {
            $suppName = $post['suppliers']['orgname'];
            $suppInfo = $supp_obj->find()->where(['like','orgname',$suppName])->all();
        } elseif (!empty($post['suppliers']['inn'])) {
           $suppInn =  $post['suppliers']['inn'];
           $suppInfo = $supp_obj->find()->where(['inn'=>$suppInn])->all();
//            debug ($suppInfo);

           if (isset($suppInfo[0]['inn'])) {

               return $this->actionSupplierinfo($suppInfo[0]['inn']);

           } else {
//             нет с таким ИНН
           }
           exit;
        }
//        debug ($suppInfo);
//        echo "item supplier";
        return $this->render('findsupp',compact('suppInfo'));
    }

    public function actionSupplierinfo($inn='') {
        if (empty($inn) ) {
            $get = \Yii::$app->request->get();
            $inn=$get['id'];
        }
        $supp_obj = new \app\models\suppliers;
        $suppContracts = new \app\models\suppregnums;
//            $sql="SELECT id,fullName,INN,price,kol FROM customer INNER JOIN (SELECT DISTINCT customer,sum(price) price, count(*) kol FROM contract INNER JOIN (SELECT DISTINCT id from contract WHERE (regNum,versionNumber) in (SELECT regNum, max(versionNumber) ver from contract WHERE id IN (SELECT contract_id from supplier where inn=:inn) group by regNum)) ids on contract.id=ids.id GROUP BY (customer)) cuscont ON customer.regNumber=cuscont.customer";
//        debug ($inn);
        $suppInfo=$supp_obj->find()->where(['inn'=>$inn])->all();
        $sql='SELECT count(*) as kol,cu.fullName,cu.inn,sum(c.price) as price from suppregnums s INNER JOIN contracts c ON s.regNum=c.regNum INNER JOIN customers cu ON cu.regNumber=c.customer

WHERE s.inn=:inn GROUP BY c.customer,cu.inn;';
        $suppCont = \Yii::$app->db->createCommand($sql)->bindValue(':inn', $inn)->queryAll();
//           debug ($suppCont);
        return $this->render('supplierinfo', compact('suppInfo','suppCont'));
    }

    public function actionFindsupplier() {
        $suppObj = new \app\models\suppliers;
        if (\Yii::$app->request->isAjax) {
//            debug (\Yii::$app->request->post());
            $inn=\Yii::$app->request->post('id');
            $suppls = $suppObj->find()->where(['inn'=>$inn])->asArray()->limit(100)->all();
            return json_encode($suppls);
        }
//        return $this->render('test');
    }
}
