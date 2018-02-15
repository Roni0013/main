<?php
use yii\helpers\Html;
use yii\helpers\Url;
//    debug ($custContracts);
?>

<table class="t_supplier">
    <thead>
        <tr>
            <td width="50%">Название организации Заказчика</td>
            <td>ИНН</td>
            <td>КПП</td>
            <td>Дата регистрации</td>
            <td>Почтовый адрес</td>
            <td>Телефон</td>
        </tr>
    </thead>


    <tbody>

        <tr>


            <td><?= $custInfo[0]['fullName'] ?></td>
            <td><?= $custInfo[0]['inn']  ?></td>
            <td><?= $custInfo[0]['KPP']  ?></td>
            <td><?= $custInfo[0]['registrationDate']  ?></td>
            <td><?= $custInfo[0]['postalAddress']  ?></td>
            <td><?= $custInfo[0]['phone']  ?></td>

        </tr>

    </tbody>
</table>
<h2>С кем заключались контракты</h2>
<table class="t_supplier">
    <thead>
        <tr>
            <td width="50%">Название организации исполнителя</td>
            <td>ИНН</td>
            <td>Сумма контрактов</td>
            <td>Количество контрактов</td>

        </tr>
    </thead>
    <tbody>
        <?php foreach ($custContracts as $contract): ?>
        <tr>

            <td> <?= Html::a($contract['orgname'] , Url::to(['supplier/supplierinfo','id'=>$contract['inn']]))  ?></td>
            <td> <?= $contract['inn']  ?></td>
            <td> <?= $contract['price']  ?></td>
            <td> <?= $contract['kol']  ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>