<?php
use yii\helpers\Html;
//debug ($allCustomData);
?>
<h1>Информация заказчика</h1>
<table class='table-bordered'>
    <tr class='row-px'>
        <td class='first-col'>Наименование</td>
        <td><?=$allCustomData['fullName']?></td>
    </tr>
    <tr class='row-px'>
        <td class='first-col'>ИНН</td>
        <td><?=$allCustomData['INN']?></td>
    </tr>
    <tr class='row-px'>
        <td class='first-col'>Дата регистрации</td>
        <td><?=$allCustomData['registrationDate']?></td>
    </tr>
    <tr class='row-px'>
        <td class='first-col'>Адрес</td>
        <td><?=$allCustomData['postalAddress']?></td>
    </tr>

</table>
<br>
<table  class='table-bordered'>
    <tr class='row-px'>
        <td>Исполнители</td>
        <td>Контрактов</td>
    </tr>
    <tr class='row-px'>
        <td>ОАО</td>
        <td>32</td>
    </tr>
    <tr class='row-px'>
        <td>ЗАО</td>
        <td>2</td>
    </tr>
</table>

<pre>
    контракты заказчика
    //<?php
//    foreach ($contractCustomers as $contract) {
//        print_r ($contract->regNum);
//        if (isset($contract->product[0])) {
//            print_r($contract->product[0]->name);
//        }
//        if (isset($contract->supplier[0])) {
//            print_r ($contract->supplier[0]->organizationName);
//        }
//        echo "<br>";
//    }
//    ?>
 </pre>


