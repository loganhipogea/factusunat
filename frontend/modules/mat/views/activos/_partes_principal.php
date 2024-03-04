<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\masters\VwSociedades;
USE common\widgets\imagewidget\ImageWidget;
use  common\widgets\selectwidget\selectWidget;
/* @var $this yii\web\View */
/* @var $model frontend\modules\mat\models\MatActivos */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="mat-activos-form">
    <br>
    <?php $form = ActiveForm::begin([
    'fieldClass'=>'\common\components\MyActiveField'
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
  </div>
  <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'codart')->textInput(['maxlength' => true,'disabled'=>true]) ?>

 </div>
  <div class="col-lg-9 col-md-8 col-sm-6 col-xs-12">
     <?= $form->field($model, 'codart')->textInput(['value' => $model->material->descripcion,'disabled'=>true])->label('Descripción') ?>

 </div>
  <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'cant')->textInput(['maxlength' => true,'disabled'=>true]) ?>

 </div>
 <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'status')->textInput(['disabled'=>true])->label('Estado actual'); ?>

 </div>
 <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">    
 <?= $form->field($model, 'current_status')->
            dropDownList($model->possibleStatus(),
                  ['prompt'=>'--'.yii::t('base.verbs','Choose a Value')."--",
                    // 'class'=>'probandoSelect2',
                      //'disabled'=>$bloqueado,
                        ]
                    ) ?>
 </div> 
  <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'codart')->textInput([
         'maxlength' => true,
         'value'=>$model->materialSolicitado->fecha_cre,
         'disabled'=>true,
         ])->label('Fecha de solicitud de apertura') ?>

 </div>
          
  <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'codart')->textInput([
         'maxlength' => true,
         'value'=>$model->materialSolicitado->user_name,
          'disabled'=>true,
         ])->label('Usuario solicitante') ?>

 </div>
          
 <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'id')->textInput([
         'maxlength' => true,
         'value'=>$model->creado,
          'disabled'=>true,
         ])->label('Fecha creación') ?>

 </div>
          
  <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'id')->textInput([
         'maxlength' => true,
         'value'=>$model->username,
          'disabled'=>true,
         ])->label('Usuario creador') ?>

 </div>
 
     
    <?php ActiveForm::end(); ?>

</div>
    </div>
