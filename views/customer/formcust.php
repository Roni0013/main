<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use app\models\customers;
?>

<h2>Поиск организации заказчика</h2>
<?php $f_findCust = ActiveForm::begin(['action'=>'itemcustomer']) ?>
<?php $customer_obj = new customers() ?>
<?= $f_findCust->field($customer_obj, 'fullName')->textInput()->label('По названию')  ?>
<?= $f_findCust->field($customer_obj, 'inn')->textInput()->label('По ИНН')  ?>
<?= Html::submitButton('Поиск')  ?>

<?php ActiveForm::end() ?>