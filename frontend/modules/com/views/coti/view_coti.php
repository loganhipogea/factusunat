<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\modules\com\models\ComCotizacion */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Ofertas'), 'url' => ['index-coti']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="com-cotizacion-view">

    <h4><?= Html::encode($this->title) ?></h4>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update-coti', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'numero',
            'serie',
            'codsoc',
            'codcen',
            'codcli',
            'codcli1',
            'estado',
            'descripcion',
            'detalle_interno:ntext',
            'detalle_externo:ntext',
            'femision',
            'validez',
            'codtra',
            'n_direcc',
            'codmon',
        ],
    ]) ?>

</div>
