<?php
use yii\helpers\Html;
?>



<?php // debug ($suppInfo); ?>



<table class="t_supplier">
    <thead>
        <tr>
            <td width="50%">Название организации исполнителя</td>
            <td>ИНН</td>
            <td>Примечание</td>
            <td>Примечание</td>
        </tr>
    </thead>


    <tbody>
        <?php foreach ($suppInfo as $supp): ?>
        <tr>


            <td><?= Html::a($supp['orgname'] , "/supplier/supplierinfo?id={$supp['inn']}") ?></td>
            <td><?= $supp['inn']  ?></a></td>
            <td><a href="#" title="Подробнее" >64</a></td>
            <td><a href="#" title="Подробнее" >3223</a></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>