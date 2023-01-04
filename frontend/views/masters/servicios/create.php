<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\masters\ServiciosTarifados */

$this->title = Yii::t('app', 'Create Servicios Tarifados');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Servicios Tarifados'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="servicios-tarifados-create">

    <h4><?= Html::encode($this->title) ?></h4>
<div class="box box-success">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
</div>