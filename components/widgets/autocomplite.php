<?php
namespace app\components\widgets;
use yii\base\Widget;
use yii\jui\AutoComplete;
use yii\helpers\Url;

class autocomplite extends Widget{

    public $data;




    public function run() {
//debug ($this->data);
//        foreach ($this->data as $val) {
//            $text[]=$val['value'];
//        }

        return AutoComplete::widget([
            'options'=>[
                'class'=>'mystyle.css',
                'id'=>'autocomp'
            ],

            'clientOptions' => [
                'source' => Url::to('/notif/complete'),
                'minLength'=>'3',
                'delay'=>'700'
            ]
        ]);
    }
}
