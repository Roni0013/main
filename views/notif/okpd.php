
<?php
    use edwinhaq\simpleduallistbox\SimpleDualListbox;
    use yii\widgets\ActiveForm;
    use yii\helpers\Html;
    use kartik\select2\Select2;

  ?>


$form= ActiveForm::begin(['action'=>'notif/notif']) ;
// $form->field($OKPD,'name')->label('Выберите отрасль')->widget(Select2::className(),[
//    'data'=>$keyval,
//    'size'=> Select2::SMALL,
//    'pluginOptions' => ['allowClear'=>TRUE],
//    'theme' => 'bootstrap',
//    'options' => [
//            'multiple' => TRUE,
//            'placeholder'=> 'Выберите отрасль'
//            ]
//    ]);

<?=  Html::submitButton('Отправить')  ?>
php ActiveForm::end()?>


<?php //debug ($spisok) ?>









