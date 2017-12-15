<?php
use yii\helpers\Html;
use yii\bootstrap\Widget;
use yii\widgets\LinkPager;

//debug ($query);
?>
<div class="panel panel-default">
  <!-- Default panel contents -->
  <div class="panel-heading">Результат выборки</div>
  <div class="panel-body">
            <p>1-й столбец</p>
  </div>

  <!-- Table -->
  <table class="table table-condensed">
      <?php foreach ($spisok as $value) : ?>
      <tr class="row">
            <td><?= Html::encode ($value->number) ?>;</td>
            <td><?= Html::encode ($value->info) ?></td>
            <td><?= Html::encode ($value->maxPrice.' р.') ?></td>
            <td><?= Html::a('Подробнее', '/notif/item?id='.$value->id); ?></td>
       </tr>

       <?php endforeach;?>
  </table>
  <?= LinkPager::widget(['pagination' => $pagination, 'linkOptions' => ['gfd']])  ?>

</div>





