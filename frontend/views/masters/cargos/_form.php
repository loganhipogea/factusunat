<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\masters\Cargos */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cargos-form">
    <br>
    <?php $form = ActiveForm::begin([
          'id'=>'my-form-cargo',
         'fieldClass'=>'\common\components\MyActiveField',
        'enableAjaxValidation'=>true,
     
    ]); ?>
      <div class="box-header">
        <div class="col-md-12">
            <div class="form-group no-margin">
                
        <?= Html::submitButton('<span class="fa fa-save"></span>   '.Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
            

            </div>
        </div>
    </div>
      <div class="box-body">
    <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'codcargo')->textInput(['maxlength' => true]) ?>

 </div> 
 
  <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'descricargo')->textInput(['maxlength' => true]) ?>

 </div>
 
  <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'hh')->textInput(['maxlength' => true]) ?>

 </div>
     
    <?php ActiveForm::end(); ?>

</div>
    </div>
