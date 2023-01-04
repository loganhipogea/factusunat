<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\masters\ServiciosTarifadosSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="servicios-tarifados-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'codserv') ?>

    <?= $form->field($model, 'descripcion') ?>

    <?= $form->field($model, 'detalle') ?>

    <?= $form->field($model, 'codum') ?>

    <?php // echo $form->field($model, 'precio') ?>

    <?php // echo $form->field($model, 'codmon') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
