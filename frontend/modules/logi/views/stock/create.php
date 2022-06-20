<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\modules\logi\models\Stock */

$this->title = Yii::t('logi.labels', 'Create Stock');
$this->params['breadcrumbs'][] = ['label' => Yii::t('logi.labels', 'Stocks'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stock-create">

    <h4><?= Html::encode($this->title) ?></h4>
<div class="box box-success">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
</div>