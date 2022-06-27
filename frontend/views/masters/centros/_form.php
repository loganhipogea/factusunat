<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\masters\Centros */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="centros-form">
    <br>
    <?php $form = ActiveForm::begin([
    'fieldClass'=>'\common\components\MyActiveField'
    ]); ?>
      <div class="box-header">
        <div class="col-md-12">
            <div class="form-group no-margin">
                
        <?= Html::submitButton('<span class="fa fa-save"></span>   '.Yii::t('base.names', 'Save'), ['class' => 'btn btn-success']) ?>
            

            </div>
        </div>
    </div>
      <div class="box-body">
    
 <div class="col-lg-6 col-md-4 col-sm-4 col-xs-12">
     <?= $form->field($model, 'codcen')->textInput(['maxlength' => true]) ?>

 </div>
  <div class="col-lg-6 col-md-8 col-sm-8 col-xs-12">
     <?= $form->field($model, 'nomcen')->textInput(['maxlength' => true]) ?>

 </div>
  
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
     <?= $form->field($model, 'descricen')->textarea(['rows' => 6]) ?>

 </div>
     
    <?php ActiveForm::end(); ?>

</div>
    </div>
