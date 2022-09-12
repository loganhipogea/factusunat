<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\com\models\ComCotizacionSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="com-cotizacion-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'numero') ?>

    <?= $form->field($model, 'serie') ?>

    <?= $form->field($model, 'codsoc') ?>

    <?= $form->field($model, 'codcen') ?>

    <?php // echo $form->field($model, 'codcli') ?>

    <?php // echo $form->field($model, 'codcli1') ?>

    <?php // echo $form->field($model, 'estado') ?>

    <?php // echo $form->field($model, 'descripcion') ?>

    <?php // echo $form->field($model, 'detalle_interno') ?>

    <?php // echo $form->field($model, 'detalle_externo') ?>

    <?php // echo $form->field($model, 'femision') ?>

    <?php // echo $form->field($model, 'validez') ?>

    <?php // echo $form->field($model, 'codtra') ?>

    <?php // echo $form->field($model, 'n_direcc') ?>

    <?php // echo $form->field($model, 'codmon') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
