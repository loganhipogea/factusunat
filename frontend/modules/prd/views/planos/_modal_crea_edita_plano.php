<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use common\helpers\h;
/* @var $this yii\web\View */
/* @var $model frontend\modules\prd\models\PrdPlanos */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="prd-planos-form">
    <br>
    <div class="box-body">
    <?php $form = ActiveForm::begin([
    'fieldClass'=>'\common\components\MyActiveField',
        'id'=>'myformulario',
    ]); ?>
       <div class="box-header">
        <div class="col-md-12">
            <div class="form-group no-margin">
            <?php
         
          if($model->isNewRecord){
            $url=\yii\helpers\Url::to(['/prd/planos/modal-crea-plano','id'=>$id]);   
          }else{
             $url=\yii\helpers\Url::to(['/prd/planos/modal-edita-plano','id'=>$id]);  
          }
         echo Html::button('hola', ['type'=>'submit']);
        
           ?>
           <?= \common\widgets\buttonsubmitwidget\buttonSubmitWidget::widget(
                  ['idModal'=>$idModal,
                    'idForm'=>'myformulario',
                      'url'=> $url,
                     'idGrilla'=>$gridName, 
                      ]
                  )?>
            </div>
        </div> 
    </div>  
      
 
  <?php 
    if(!empty($model->codart)){
   ?> 
          
     <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'id')->textInput(['maxlength' => true,'value'=>$model->material->descripcion, 'disabled'=>true])->label(yii::t('base.names','NP')) ?>

     </div>      
          
  <?php    }
   ?>  
          
          
  <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'descriplano')->textInput(['maxlength' => true]) ?>

 </div>
  <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'comentario')->textarea(['rows' => 6]) ?>

 </div>
  <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'activo_id')->textInput() ?>

 </div>
  <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'rol')->textInput(['maxlength' => true]) ?>

 </div>
  <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
     
 <?= $form->field($model, 'fecha')->widget(DatePicker::class, [
                            'language' => h::app()->language,
                           'pluginOptions'=>[
                                     'format' => h::gsetting('timeUser', 'date')  , 
                                   'changeMonth'=>true,
                                  'changeYear'=>true,
                                 'yearRange'=>'2014:'.date('Y'),
                               ],
                          
                            //'dateFormat' => h::getFormatShowDate(),
                            'options'=>['class'=>'form-control',
                               //'disabled'=>(!$bloqueado)?false:true  
                                ]
                            ]) ?>
 </div>
  <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'revision')->textInput(['maxlength' => true,'disabled'=>true]) ?>

 </div>
  
  <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'codigo')->textInput(['maxlength' => true]) ?>

 </div>
  <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'current_status')->textInput(['maxlength' => true,'disabled'=>true]) ?>

 </div>
  <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'status')->textInput(['maxlength' => true,'disabled'=>true]) ?>

 </div>
     
    <?php ActiveForm::end(); ?>

</div>
    </div>

