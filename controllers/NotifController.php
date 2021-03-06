<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\controllers;

use yii\web\Controller;
use app\models\okpd;
use app\models\notification;
use yii\web\Application;
use yii\data\Pagination;
use app\models\customer;
use Yii;
/**
 * Description of NotifController
 *
 * @author roni
 */

class NotifController extends Controller
 {
    public function actionIndex() {

//        $supplier_obj = new \app\models\supplier();
        $this->view->title = 'Начало';
        return $this->render('index');
    }

    public function actionIndex1() {

//        phpinfo(); die;
        $OKPD = new okpd();


//        debug ($text);

//$spisok=$OKPD->find()->where(['like','code','__', false])->all();
        $spisok=$OKPD->find()->where(['like','code','__', FALSE])->asArray()->all();
//        debug ($spisok);
        foreach ($spisok as $key=>$value) {
//        debug ($value);
            $keyval[$value['code']] = $value['name'];
        }
//        debug ($keyval);
        $this->view->title = 'Заголовок';
        return $this->render('startfind', compact('OKPD', 'keyval'),['tittle'=>'Название']);
    }

    public function actionNotif() {
        $session=\Yii::$app->session;
        $session->open();
        $notif = new notification ();
        $request = \yii::$app->request;
        $code = $request->post();
        //запомнить выбор отрасли в сессии
        if ($code) {
            foreach ($code['okpd']['name'] as $value) {
                $codes[]=$value.'%';
            }
            $session['codes']=$codes;
         }
         else {
             $codes=$session['codes'];
         }
         $query=$notif->find();
        $pagination = new Pagination(['defaultPageSize' => '20', 'totalCount' => $query->count()]);
        $spisok= $query->where(['or like','OKPD',$codes,FALSE])->limit($pagination->limit)->offset($pagination->offset)->orderBy('maxPrice')->all();
        return $this->render('notif',compact ('spisok', 'pagination'));
    }


    public function actionItem() {
        $id=\Yii::$app->request->get();
        $notif = new notification ();
        //debug ($id['id']);
        $query = $notif->findOne($id['id']);//->with('customer');

        return $this->render('item', compact('query'));

    }

    public function actionComplete() {
        $get=Yii::$app->request->get();

        $customer = new customer();
        $data=$customer->find()->select('fullName')->where(['like','fullName',$get['term']])->limit(20)->all();
//        debug ($data);
        foreach ($data as $val) {
            $text[]=$val['fullName'];
        }
//        debug ($text);

        echo \yii\helpers\Json::encode($text);
    }

    public function actionOnecustom() {
        $id=Yii::$app->request->post();
        $fullName = $id['customer']['fullName'];
        $customObj = new customer;
        $allCustomData = $customObj->find()->where(['like','fullName',$fullName,FALSE])->one();
        $contractObj = new \app\models\contract();
        $regNumber=$allCustomData['regNumber'];
//        debug ($regNumber);
        $contractCustomers = $contractObj->find()->where(['customer' =>$regNumber])->with('product','supplier')->limit(20)->all();
//        $prod=$contractCustomer->getProduct();
//        debug ($contractCustomers);
        return $this->render('onecustomer', compact('allCustomData','contractCustomers'));
    }


}
