<?php

use yii\helpers\Html;
use app\assets\AppAsset;
use yii\bootstrap\NavBar;
use yii\bootstrap\Nav;
use yii\helpers\Url;
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
    <header>
        <div class="sitecapt">
            Аналитика госзакупок
        </div>
        <div class="site_nav wraper" >
            <nav>
                <ul>
                    <li><a href="#">Главная</a></li>
                    <li><a href="#">О проекте</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <main class="wraper">
		<div class="left_menu">
			<h2>Информация по участникам</h2>
			<ul>
                            <li><?= Html::a('Заказчики', Url::to('/customer/formcustomer'))  ?></li>
				<li><?= Html::a('Исполнители', Url::to('/supplier/formsupplier'))  ?></li>
				<li><a href="#">Тендеры</a></li>
			</ul>
		</div>
        <div class="midcont">
            <?= $content  ?>
        </div>
    </main>


<div style="clear: both;"></div>
<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

