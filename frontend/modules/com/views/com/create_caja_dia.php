<?php
use yii\helpers\Html;
$this->title = Yii::t('base.names', 'Open daily cash');
$this->params['breadcrumbs'][] =
        ['label' => Yii::t('base.names', 'Daily'), 'url' => ['index-daily-cashes']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="com-factura-index">
   
    
    <?= $this->render('_form_daily_cash', [
        'model' => $model,
    ]) ?>



</div>