<?php
use yii\helpers\Html;
?>
<table class="t_supplier">
    <?php // debug ($suppCont) ?>

    <tbody>

        <tr>
            <td width="20%">Название</td>
            <td><?= $suppInfo[0]['orgname']  ?></td>
        </tr>
        <tr>
            <td width="20%">ИНН</td>
            <td><a><?= $suppInfo[0]['inn']  ?></td>
        </tr>
        <tr>
            <td width="20%">Адрес</td>
            <td><?= $suppInfo[0]['address']  ?></td>
        </tr>

        <tr>
            <td width="20%">Телефон</td>
            <td><?= $suppInfo[0]['phone']  ?></td>
        </tr>

    </tbody>
</table>
<h2> С кем заключались контракты </h2>


<table class="t_supplier">



    <thead>
        <tr>
            <td width="50%">Наименование организации</td>
            <td>ИНН</td>
            <td>Сумма заключенных контрактов</td>
            <td width="15%">Количество заключенных контрактов</td>
        </tr>
    </thead>
    <tbody>
        <?php $count=0; $sum=0; ?>
        <?php foreach ($suppCont as $info): ?>
            <tr>

                <td><?= Html::a($info['fullName'], "/customer/customerinfo?id={$info['inn']}")   ?></td>
                <td><?= $info['inn'] ?></td>
                <td><?= $info['price'] ?></td>
                <td><a><?= $info['kol'] ?></a></td>

            </tr>
                <?php $count++; $sum +=$info['price'];  ?>
        <?php endforeach; ?>
            <tr>
                <td><?= $count ?></td>
                <td></td>
                <td><?= $sum ?></td>

            </tr>

    </tbody>
</table>
         <?php // debug ($suppCont) ?>