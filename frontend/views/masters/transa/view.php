<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\masters\Transacciones */

$this->title = $model->codtrans;
$this->params['breadcrumbs'][] = ['label' => Yii::t('base.names', 'Transacciones'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="transacciones-view">

    <h4><?= Html::encode($this->title) ?></h4>

    <p>
        <?= Html::a(Yii::t('base.names', 'Update'), ['update', 'codtrans' => $model->codtrans], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('base.names', 'Delete'), ['delete', 'codtrans' => $model->codtrans], [
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
            'codtrans',
            'descripcion',
            'signo',
            'detalles:ntext',
        ],
    ]) ?>

</div>
