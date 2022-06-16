<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\masters\Transacciones */

$this->title = Yii::t('base.names', 'Create Transacciones');
$this->params['breadcrumbs'][] = ['label' => Yii::t('base.names', 'Transacciones'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="transacciones-create">

    <h4><?= Html::encode($this->title) ?></h4>
<div class="box box-success">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
</div>