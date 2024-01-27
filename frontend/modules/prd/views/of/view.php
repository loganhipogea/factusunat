<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\modules\prd\models\PrdOp */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('base', 'Prd Ops'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="prd-op-view">

    <h4><?= Html::encode($this->title) ?></h4>

    <p>
        <?= Html::a(Yii::t('base', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('base', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('base', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'parent_id',
            'numero',
            'codart',
            'descripcion',
            'textodetalle:ntext',
            'textocomercial:ntext',
            'cant',
            'username',
            'finicio',
            'finiciop',
            'ftermino',
            'fterminop',
            'fcrea',
            'avance',
            'tipo',
            'codestado',
        ],
    ]) ?>

</div>
