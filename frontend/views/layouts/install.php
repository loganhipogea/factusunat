<?php
use yii\helpers\Html;
?>    
    
    <?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
           <?php //$this->registerCssFile("@web/css/bootstrap.min.css", [], 'css-install2'); ?>
 <?php //$this->registerCssFile("@web/css/install.css", [], 'css-install'); ?>
         <?php //$this->registerCssFile("@web/css/personal.css", [], 'css-install22'); ?>
         <?php //$this->registerCssFile("@web/css/font-awesome.min.css", [], 'css-install22'); ?>
         <?php //$this->registerCssFile("@web/css/AdminLTE.min.css", [], 'css-install222'); ?>
         <?php //$this->registerCssFile("@web/css/skin-green-light.min.css", [], 'css-install22222'); ?> 
         <?php //$this->registerCssFile("@web/css/akaunting-green.css", [], 'css-install2222222'); ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
   <body class="" style="overflow-y: scroll;">
       
 <?php $this->beginBody() ?>   
        <?= $content ?>
    <?php $this->endBody() ?>
    </body>
    </html>
    <?php $this->endPage() ?>