<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\com\models\ComOv */

$this->title = Yii::t('base.names', 'Update daily: {name}', [
    'name' => $model->codcaja,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('base.names', 'Daily'), 'url' => ['index-daily-cashes']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('base.names', 'Update');
?>
<div class="com-ov-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form_daily_cash', [
        'model' => $model,
    ]) ?>

</div>
