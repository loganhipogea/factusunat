<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\com\models\ComOv */

$this->title = Yii::t('base.names', 'Update daily cash: {name}', [
    'name' => $model->caja->nombre,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('base.names', 'Cashes'), 'url' => ['index-cashes']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('base.names', 'Update');
?>
<div class="com-ov-update">

    <h4><?= Html::encode($this->title) ?></h4>

    <?= $this->render('_form_daily_cash', [
        'model' => $model,
    ]) ?>

</div>
