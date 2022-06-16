<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\masters\TransaccionesSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="transacciones-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'codtrans') ?>

    <?= $form->field($model, 'descripcion') ?>

    <?= $form->field($model, 'signo') ?>

    <?= $form->field($model, 'detalles') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('base.names', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('base.names', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
