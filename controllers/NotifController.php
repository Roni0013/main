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
/**
 * Description of NotifController
 *
 * @author roni
 */

class NotifController extends Controller
 {
    public function actionIndex() {
        $OKPD = new okpd();
        //$spisok=$OKPD->find()->where(['like','code','__', false])->all();
        $spisok=$OKPD->find()->asArray()->all();
//        foreach ($spisok as $value) {
//            $keyval [$value->code] = $value->name;
//        }
        
        return $this->render('okpd', compact('OKPD', 'spisok'));
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

}
