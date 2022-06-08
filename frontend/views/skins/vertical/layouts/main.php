<?php

/* @var $this \yii\web\View */
/* @var $content string */

use frontend\assets\tabler\AppAssetTabler;

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;

AppAssetTabler::register($this);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
        
    <!-- CSS files -->
    
 
 <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>

     <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/c3/0.6.7/c3.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/d3/4.13.0/d3.min.js"></script> -->
    <?php $this->head() ?>
   

    <?php 
        // $this->registerJsFile('plugins/charts-c3/js/c3.min.js');
        // $this->registerJsFile('plugins/charts-c3/js/d3.v4.min.js');
    ?>

</head>
<body >
<?php 
    
$this->beginBody() ?>

<div class="wrapper">
        <?= $this->render('left.php');?>
        <?= $this->render('container-fluid.php');?>
          <?= $content ?>
        <?php //echo $this->render('header.php');?>
        <?= $this->render('footer.php');?>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
