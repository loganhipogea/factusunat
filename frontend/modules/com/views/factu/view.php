<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\modules\com\models\ComFactura */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('base.names', 'Com Facturas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="com-factura-view">

    <h4><?= Html::encode($this->title) ?></h4>

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
            'codsoc',
            'numero',
            'femision',
            'fvencimiento',
            'sunat_tipodoc',
            'codmon',
            'tipopago',
            'rucpro',
            'sunat_hemision',
            'codcen',
            'serie',
            'codestado',
            'nombre_cliente',
            'hemision',
            'sunat_totgrav',
            'sunat_totexo',
            'sunat_totigv',
            'sunat_totimpuestos',
            'descuento',
            'subtotal',
            'sunat_totisc',
            'totalventa',
            'total',
        ],
    ]) ?>

</div>
