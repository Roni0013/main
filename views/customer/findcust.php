<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use app\models\customers;
//debug ($custInfo);
?>


<?php $customerObj = new customers(); ?>

<div class="inp-form">
    <?php $form1= ActiveForm::begin(); ?>
        <fieldset>
            <legend>Поиск заказчиков</legend>
            <?= $form1->field($customerObj, 'fullName')->hint('Поиск по названию')  ?>

            <br>
            <?= $form1->field($customerObj, 'inn')->options(['name'=>'inn','placeholder'=>'Поиск по ИНН'])  ?>

            <input type="submit" name="find" value="Поиск" class="buttn">
        </fieldset>
    <?php ActiveForm::end(); ?>
</div>
<form action="#" name="orgs">
    <div class="result-find">

        <div class="result-left">
            <h2>Заказчики</h2>
            <div class="text-result">
                <input type="radio" name="orgs" id="1" class="radio" value="1">
                <label for="1">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Repellendus, nemo consequuntur recusandae nam atque perspiciatis. <br>
                    <small class="inn">ИНН 0231654652</small></label><br>
                <input type="radio" name="orgs" id="2" class="radio" value="2">
                <label for="2">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Repellendus, nemo consequuntur recusandae nam atque perspiciatis. <br>
                    <small class="inn">ИНН 0231654652</small></label><br>
                <input type="radio" name="orgs" id="3" class="radio" value="3">
                <label for="3">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Repellendus, nemo consequuntur recusandae nam atque perspiciatis. <br>
                    <small class="inn">ИНН 0231654652</small></label><br>
                <input type="radio" name="orgs" id="4" class="radio" value="4">
                <label for="4">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Repellendus, nemo consequuntur recusandae nam atque perspiciatis. <br>
                    <small class="inn">ИНН 0231654652</small></label><br>
                <input type="radio" name="orgs" id="3" class="radio">
                <label for="3">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Repellendus, nemo consequuntur recusandae nam atque perspiciatis. <br>
                    <small class="inn">ИНН 0231654652</small></label><br>
                <input type="radio" name="orgs" id="3" class="radio">
                <label for="3">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Repellendus, nemo consequuntur recusandae nam atque perspiciatis. <br>
                    <small class="inn">ИНН 0231654652</small></label><br>

            </div>
        </div>
        <div class="result-right">
            <h2>Подробная информация</h2>
            <div class="result-item">
                <p>ООО Lorem ipsum dolor sit amet.</p>
                <p>ИНН 1231345646</p>
                <p>Адрес: Lorem ipsum dolor sit amet, consectetur adipisicing elit. Placeat, eius.</p>

            </div>
        </div>


    </div>
    <div style="clear: right;"></div>
    <input type="submit" name="orgs" value="Анализ заказчика" class="buttn">
</form>













<table class="t_supplier">
    <thead>
        <tr>
            <td width="50%">Название организации Заказчика</td>
            <td>ИНН</td>
            <td>КПП</td>
        </tr>
    </thead>


    <tbody>
        <?php foreach ($custInfo as $cust): ?>
        <tr>


            <td><?= Html::a($cust['fullName'] , Url::to(['customer/customerinfo','id'=>$cust['regNumber']])) ?></td>
            <td><?= $cust['inn']  ?></td>
            <td><a href="#" title="Подробнее" >64</a></td>
            <td><a href="#" title="Подробнее" >3223</a></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>