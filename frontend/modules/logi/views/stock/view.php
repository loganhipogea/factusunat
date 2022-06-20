<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\modules\logi\models\Stock */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('logi.labels', 'Stocks'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="stock-view">

    <h4><?= Html::encode($this->title) ?></h4>

    <p>
        <?= Html::a(Yii::t('logi.labels', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('logi.labels', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('logi.labels', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'codart',
            'codcen',
            'cant',
            'um',
            'ubicacion',
            'cantres',
            'codal',
            'valor',
            'lastmov',
            'pventa',
            'ceconomica',
            'creorden',
            'cminima',
            'clas_abc',
        ],
    ]) ?>

</div>
