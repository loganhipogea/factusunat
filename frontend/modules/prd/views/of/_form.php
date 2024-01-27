<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use common\widgets\selectwidget\selectWidget;
use common\helpers\h;
/* @var $this yii\web\View */
/* @var $model frontend\modules\prd\models\PrdOp */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="prd-op-form">
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
  
          
  <div class="col-lg-8 col-md-8 col-sm-6 col-xs-12">
     <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true]) ?>

   </div>
   <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
      <?= $form->field($model, 'finicio')->widget(DatePicker::class, [
                            'language' => h::app()->language,
                           'pluginOptions'=>[
                                     'format' => h::gsetting('timeUser', 'date')  , 
                                   'changeMonth'=>true,
                                  'changeYear'=>true,
                                 'yearRange'=>'2014:'.date('Y'),
                               ],
                          
                            //'dateFormat' => h::getFormatShowDate(),
                            'options'=>['class'=>'form-control',
                              // 'disabled'=>(!$aprobado)?false:true  
                                ]
                            ]) ?>
 </div>
   <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
      <?= $form->field($model, 'finiciop')->widget(DatePicker::class, [
                            'language' => h::app()->language,
                           'pluginOptions'=>[
                                     'format' => h::gsetting('timeUser', 'date')  , 
                                   'changeMonth'=>true,
                                  'changeYear'=>true,
                                 'yearRange'=>'2014:'.date('Y'),
                               ],
                          
                            //'dateFormat' => h::getFormatShowDate(),
                            'options'=>['class'=>'form-control',
                            //   'disabled'=>(!$aprobado)?false:true  
                                ]
                            ]) ?>
 </div>
  <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
      <?= $form->field($model, 'ftermino')->widget(DatePicker::class, [
                            'language' => h::app()->language,
                           'pluginOptions'=>[
                                     'format' => h::gsetting('timeUser', 'date')  , 
                                   'changeMonth'=>true,
                                  'changeYear'=>true,
                                 'yearRange'=>'2014:'.date('Y'),
                               ],
                          
                            //'dateFormat' => h::getFormatShowDate(),
                            'options'=>['class'=>'form-control',
                              // 'disabled'=>(!$aprobado)?false:true  
                                ]
                            ]) ?>
 </div>
   <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
      <?= $form->field($model, 'fterminop')->widget(DatePicker::class, [
                            'language' => h::app()->language,
                           'pluginOptions'=>[
                                     'format' => h::gsetting('timeUser', 'date')  , 
                                   'changeMonth'=>true,
                                  'changeYear'=>true,
                                 'yearRange'=>'2014:'.date('Y'),
                               ],
                          
                            //'dateFormat' => h::getFormatShowDate(),
                            'options'=>['class'=>'form-control',
                            //   'disabled'=>(!$aprobado)?false:true  
                                ]
                            ]) ?>
 </div>
 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
     <?php 
  // $necesi=new Parametros;
    echo selectWidget::widget([
           // 'id'=>'mipapa',
            'model'=>$model,
            'form'=>$form,
            'campo'=>'codart',
         //'ordenCampo'=>1,
         'addCampos'=>[2],
        ]);  ?>

 </div>         
          
 
  
  <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'numero')->textInput(['maxlength' => true]) ?>

 </div>
 
  
  <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'textodetalle')->textarea(['rows' => 6]) ?>

 </div>
  <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'textocomercial')->textarea(['rows' => 6]) ?>

 </div>
  <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'cant')->textInput(['maxlength' => true]) ?>

 </div>
  
  
  
  
  <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'avance')->textInput() ?>

 </div>
  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
    <?php 
    
   // var_dump($model->comboDataField('tipo')); die();
           echo  $form->field($model, 'tipo')->
            dropDownList( $model->comboDataField('tipo'),
                    ['prompt'=>'--'.yii::t('base.verbs','Seleccione un valor')."--",
                    // 'class'=>'probandoSelect2',
                      //'disabled'=>($model->isBlockedField('codpuesto'))?'disabled':null,
                        ]
                    )  ?>

 </div>
  
     
    <?php ActiveForm::end(); ?>

</div>
    </div>
