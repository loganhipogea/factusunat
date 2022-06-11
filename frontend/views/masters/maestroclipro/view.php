<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\masters\Maestroclipro */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('base.names', 'Maestroclipros'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="maestroclipro-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('base.names', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('base.names', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('base.names', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'venta',
            'codpro',
            'codart',
            'vencimiento',
            'tiempoentrega',
            'codcen',
            'precio',
            'codmon',
            'param1',
            'param2',
            'param3',
            'param4',
        ],
    ]) ?>

</div>
