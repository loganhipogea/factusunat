<?php

use yii\helpers\Html;
use common\helpers\h;
use yii\widgets\ActiveForm;
use common\helpers\ComboHelper;

/* @var $this yii\web\View */
/* @var $model common\models\masters\Ums */
/* @var $form yii\widgets\ActiveForm */
?>
 
    


    <?php $form = ActiveForm::begin(['id'=>'migorun','enableAjaxValidation'=>true]); ?>
    <div class="header">
     <div class="form-group no-margin">
         <div class="btn-group">
              <?= Html::submitButton(h::awe('floppy-disk').Yii::t('base.verbs', 'Save'), ['class' => 'btn btn-success']) ?>
  
         </div>
      </div>
     </div>
     <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
         .
     </div>
 <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
    <?= $form->field($model, 'codum')->textInput([ 'disabled'=>($model->isNewRecord)?null:'disabled',   'maxlength' => true]) ?>
 </div>
     <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
    <?= $form->field($model, 'desum')->textInput(['maxlength' => true]) ?>
 </div>
     <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
    <?= $form->field($model,'dimension')->
            dropDownList(
            ComboHelper::getCboUms() ,
                    ['prompt'=>'--'.yii::t('base.verbs','Choose a Value')."--",
                     //'class'=>'probandoSelect2',
                        ]
                    ) ?> </div>
     <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
    <?= $form->field($model, 'escala')->textInput() ?>
 </div>
    
    

     
    <?php ActiveForm::end(); ?>


