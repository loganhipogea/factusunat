<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use common\widgets\inputajaxwidget\inputAjaxWidget;
use common\helpers\ComboHelper;
use common\helpers\h;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $model frontend\modules\com\models\ComOv */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="com-ov-form">
 
    <?php $form = ActiveForm::begin([
        'id'=>'Form_general',
        'enableAjaxValidation'=>true
        ]); ?>  
    <div class="form-group">
        <?= Html::submitButton(Yii::t('base.names', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
         <?= $form->field($model, 'user')->textInput(['maxlength' => true]) ?>
    </div>
    
     <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
          <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>
    </div>
   <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
          <?= $form->field($model, 'password1')->passwordInput(['maxlength' => true]) ?>
    </div>
    
 <?php ActiveForm::end(); ?>
       
    
  
</div>
  