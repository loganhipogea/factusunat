<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use frontend\modules\op\helpers\ComboHelper;
 
use common\helpers\h;

/* @var $this yii\web\View */
/* @var $model frontend\modules\sigi\models\Edificios */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="edificios-form">
    <br>
    <?php $form = ActiveForm::begin([
        'id'=>'myformulario',
   // 'fieldClass'=>'\common\components\MyActiveField'
    ]); ?>
      <div class="box-header">
        
    </div>

     <div class="box-body">
          
            <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
                <?= $form->field($modelTarifa, 'costohora')->textInput(['disabled'=>true]);?>
            </div>
            <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
                <?= $form->field($modelTarifa, 'costohora')
                     ->textInput([
                         'disabled'=>true,
                         'value'=>$modelTarifa->costohora*$modelTarifa->plan->nhoras,
                         ])-> 
                    label('Diario base');?>
            </div>
            <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
                <?= $form->field($modelTarifa, 'activo')->checkbox(['disabled'=>true]);?>
            </div>
         <br>
     <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
         <hr>
     </div>
           <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <?= $form->field($modelPlan, 'codigo')->textInput(['disabled'=>true]);?>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <?= $form->field($modelPlan, 'porc_dominical')->textInput(['disabled'=>true]);?>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <?= $form->field($modelPlan, 'porc_feriado')->textInput(['disabled'=>true]);?>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <?= $form->field($modelPlan, 'porc_nocturno')->textInput(['disabled'=>true]);?>
            </div>
           <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <?= $form->field($modelPlan, 'porc_localizacion')->textInput(['disabled'=>true]);?>
            </div>
           <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <?= $form->field($modelPlan, 'porc_refrigerio')->textInput(['disabled'=>true]);?>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <?= $form->field($modelPlan, 'porc_hextras')->textInput(['disabled'=>true]);?>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <?= $form->field($modelPlan, 'nhoras')->textInput(['disabled'=>true]);?>
            </div>
   
          
     
    <?php ActiveForm::end(); ?>

</div>


    </div>



