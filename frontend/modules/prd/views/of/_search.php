<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\prd\models\PrdOpSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="prd-op-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'parent_id') ?>

    <?= $form->field($model, 'numero') ?>

    <?= $form->field($model, 'codart') ?>

    <?= $form->field($model, 'descripcion') ?>

    <?php // echo $form->field($model, 'textodetalle') ?>

    <?php // echo $form->field($model, 'textocomercial') ?>

    <?php // echo $form->field($model, 'cant') ?>

    <?php // echo $form->field($model, 'username') ?>

    <?php // echo $form->field($model, 'finicio') ?>

    <?php // echo $form->field($model, 'finiciop') ?>

    <?php // echo $form->field($model, 'ftermino') ?>

    <?php // echo $form->field($model, 'fterminop') ?>

    <?php // echo $form->field($model, 'fcrea') ?>

    <?php // echo $form->field($model, 'avance') ?>

    <?php // echo $form->field($model, 'tipo') ?>

    <?php // echo $form->field($model, 'codestado') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('base.names', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('base.names', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
