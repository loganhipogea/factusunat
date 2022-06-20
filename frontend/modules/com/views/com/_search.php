<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\com\ComOvSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="com-ov-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'rucodni') ?>

    <?= $form->field($model, 'codcen') ?>

    <?= $form->field($model, 'codsoc') ?>

    <?= $form->field($model, 'tipodoc') ?>

    <?php // echo $form->field($model, 'tipopago') ?>

    <?php // echo $form->field($model, 'numero') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('base.names', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('base.names', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
