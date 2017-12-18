
<?php
    use edwinhaq\simpleduallistbox\SimpleDualListbox;
    use yii\widgets\ActiveForm;
    use yii\helpers\Html;
    use kartik\select2\Select2;
    use app\components\widgets\autocomplite;
    use app\models\notification;
    use kartik\daterange\DateRangePicker;

  ?>


<div class="form-wrapper">
    <h2>Выберите организацию</h2>
    <?php $form1 = ActiveForm::begin() ?>


<?= autocomplite::widget()?>



<?php ActiveForm::end() ?>

 </div>
<div>
    <H2>Выберите даты</H2>
        <?= DateRangePicker::widget([
                'name'=>'data'
                ])  ?>

</div>

<?php
$form= ActiveForm::begin(['action'=>'notif/notif']) ;
 echo $form->field($OKPD,'name')->label('Выберите отрасль')->widget(Select2::className(),[
    'data'=>$keyval,
    'size'=> Select2::SMALL,
    'pluginOptions' => ['allowClear'=>TRUE],
    'theme' => 'bootstrap',
    'options' => [
            'multiple' => TRUE,
            'placeholder'=> 'Выберите отрасль'
            ]
    ]);
?>
<?=  Html::submitButton('Отправить')  ?>
<?php  ActiveForm::end()?>


<?php //debug ($spisok) ?>









