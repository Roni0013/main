<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use app\models\suppliers;
use yii\helpers\Url;
?>


<?php $supplierObj = new suppliers(); ?>

<div class="inp-form">

    <?php $form1 = ActiveForm::begin(['action'=>Url::to('/supplier/formsupplier')])  ?>
    <div class="bord">
        <h2>Поиск исполнителей</h2>

            <?= $form1->field($supplierObj, 'orgname')->input('text', ['placeholder'=>'Поиск по названию'])->label('') ?>
            <br>
            <!--<input type="text" name="inn" placeholder="Поиск по ИНН">-->
            <?= $form1->field($supplierObj, 'inn')->input('text', ['placeholder'=>'Поиск по ИНН'])->label('');  ?>
            <?= Html::submitButton('Поиск', ['class'=>'buttn'])  ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>

<?php $form2 = ActiveForm::begin(['action'=>Url::to('/supplier/findsupplier')]); ?>
<div class="result-find">
    <div class="result-left">
        <h2>Исполнители</h2>
        <div class="text-result">
            <?php If (isset($suppInfo[0])): ?>
                <?php Foreach ($suppInfo as $supplierItem): ?>
                    <?= Html::input('radio', 'orgs', $supplierItem['inn'], ['class' => 'radio', 'id' => $supplierItem['inn']]); ?>
                    <?= Html::label($supplierItem['orgname'] . '<br>' . Html::tag('small', 'ИНН ' . $supplierItem['inn'], ['class' => 'inn']), $supplierItem['inn']) ?>
            <br>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
    <div class="result-right">
        <h2>Подробная информация</h2>
        <div class="result-item">


        </div>
    </div>


</div>
<div style="clear: right;"></div>
    <input type="submit" name="orgs" value="Анализ заказчика" class="buttn">
    <?php ActiveForm::end() ?>

    <?php
//$js = <<<JS
//$('.text-result input').on('click',function(){
//   $.ajax({
//		url:'/supplier/findsupplier',
//		data:{id:this.value},
//		type:'POST',
//		success: function (res) {
//			var data=jQuery.parseJSON(res);
//                        //console.log ('<p>'+data[0].orgname);
//                        $('.result-item').html(
//                            '<p>'+data[0].orgname+'</p>'+
//                            '<p>ИНН: '+data[0].inn+'</p>'+
//                            '<p>КПП: '+data[0].kpp+'</p>'+
//                            '<p>Адрес: '+data[0].address+'</p>'+
//                            '<p>Телефон: '+data[0].phone+'</p>'
//                                );
//		}
//	});
//});
//JS;
//$this->registerJs($js);
    ?>



