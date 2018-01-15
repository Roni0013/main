<?php

use yii\helpers\Html;
use app\assets\AppAsset;
use yii\bootstrap\NavBar;
use yii\bootstrap\Nav;
AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap container">
    <div class="navbar navbar-default navbar-static-top">
        меню1
    </div>

    <div class="row">
        <div class="col-xs-2">
            2 колонки
            <p>меню сайта</p>
        </div>
        <div class="col-xs-10">
            10 колонок
          <?= $content  ?>
        </div>
    </div>

</div>



<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

