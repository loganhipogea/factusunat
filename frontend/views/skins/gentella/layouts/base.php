<?php

use yii\helpers\Html;
use yii\helpers\Url;
//$bundle = yiister\gentelella\assets\Asset::register($this);

?>
<?php $this->beginPage(); ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta charset="<?= Yii::$app->charset ?>" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <?= Html::csrfMetaTags() ?>
    <title>ala<?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
   
</head>
<body >
           <?php $this->beginBody(); ?>
            <?= $content ?>
            <?php $this->endBody(); ?>
</body>
</html>
<?php $this->endPage(); ?>


