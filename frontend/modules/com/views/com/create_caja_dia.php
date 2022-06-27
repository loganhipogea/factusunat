<?php
use yii\helpers\Html;
$this->title = Yii::t('base.names', 'Open daily cash');
$this->params['breadcrumbs'][] =
        ['label' => Yii::t('base.names', 'Daily'), 'url' => ['index-daily-cashes']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="clipro-update">
    <h4><?= Html::encode($this->title) ?></h4>
<div class="box box-success">
    <?= $this->render('_form_daily_cash', [
        'model' => $model,
    ]) ?>


</div>
</div>