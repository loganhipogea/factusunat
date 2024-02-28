<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use frontend\assets\AppAsset;
//$bundle = yiister\gentelella\assets\Asset::register($this);
AppAsset::register($this);
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
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <link href="<?=yii::getAlias(Yii::$app->params['ico'])?>" rel="icon">
    
    <?php $this->registerCssFile(Yii::$app->params['estilo_login'], []); ?>
    <?php $this->registerJsFile ( Yii::$app->params['js_login'],['depends'=>['yii\web\JqueryAsset'],'position'=> yii\web\View::POS_END], null ); ?>
    
</head>
<body >
           <?php $this->beginBody(); ?>
            <?= $content ?>
            
            <?php $this->endBody(); ?>
</body>
</html>
<?php $this->endPage(); ?>





