<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\modules\logi\models\StockSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="stock-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'codart') ?>

    <?= $form->field($model, 'codcen') ?>

    <?= $form->field($model, 'cant') ?>

    <?= $form->field($model, 'um') ?>

    <?php // echo $form->field($model, 'ubicacion') ?>

    <?php // echo $form->field($model, 'cantres') ?>

    <?php // echo $form->field($model, 'codal') ?>

    <?php // echo $form->field($model, 'valor') ?>

    <?php // echo $form->field($model, 'lastmov') ?>

    <?php // echo $form->field($model, 'pventa') ?>

    <?php // echo $form->field($model, 'ceconomica') ?>

    <?php // echo $form->field($model, 'creorden') ?>

    <?php // echo $form->field($model, 'cminima') ?>

    <?php // echo $form->field($model, 'clas_abc') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('logi.labels', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('logi.labels', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
