<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
 use kartik\date\DatePicker;
 use common\helpers\h;
 use frontend\modules\mat\helpers\ComboHelper;
/* @var $this yii\web\View */
/* @var $model frontend\modules\mat\models\MatReqSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="mat-req-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index-vale'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>
     <div class="form-group">
        <div class="btn-group">
        <?= Html::submitButton(Yii::t('app', 'Buscar'), ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Crear vale'), ['crea-vale'], ['class' => 'btn btn-success']) ?>
        </div>
     </div>
     <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <?= $form->field($model, 'numero')->textInput(['maxlength' => true]) ?>
    </div>  
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true]) ?>
    </div>
    
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
      <?php 
      
        echo $form->field($model, 'fecha')->widget(
        DatePicker::classname(), [
         'name' => 'fecha',
            'language' => h::app()->language,
            'options' => ['placeholder' =>yii::t('base.names', '--Seleccione un valor--')],
    //'convertFormat' => true,
                'pluginOptions' => [
                'format' => h::getFormatShowDate(),
                //'startDate' => '01-Mar-2014 12:00 AM',
                'todayHighlight' => true
                                ]
                    ]);
                ?>
  </div> 
    
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
      <?php 
      
        echo $form->field($model, 'fecha1')->widget(
        DatePicker::classname(), [
         'name' => 'fecha1',
            'language' => h::app()->language,
            'options' => ['placeholder' =>yii::t('base.names', '--Seleccione un valor--')],
    //'convertFormat' => true,
                'pluginOptions' => [
                'format' => h::getFormatShowDate(),
                //'startDate' => '01-Mar-2014 12:00 AM',
                'todayHighlight' => true
                                ]
                    ]);
                ?>
  </div> 

    
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
      <?php 
      
        echo $form->field($model, 'fechacon')->widget(
        DatePicker::classname(), [
         'name' => 'fechacon',
            'language' => h::app()->language,
            'options' => ['placeholder' =>yii::t('base.names', '--Seleccione un valor--')],
    //'convertFormat' => true,
                'pluginOptions' => [
                'format' => h::getFormatShowDate(),
                //'startDate' => '01-Mar-2014 12:00 AM',
                'todayHighlight' => true
                                ]
                    ]);
                ?>
  </div> 
    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">    
 <?= $form->field($model, 'codal')->
            dropDownList(ComboHelper::getCboAlmacenes(null),
                  ['prompt'=>'--'.yii::t('base.verbs','Choose a Value')."--",
                    // 'class'=>'probandoSelect2',
                      //'disabled'=>($model->isBlockedField('codpuesto'))?'disabled':null,
                        ]
                    ) ?>
 </div> 
   <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">    
 <?= $form->field($model, 'codmov')->
            dropDownList(ComboHelper::getCboTransaccionesAlmacen(),
                  ['prompt'=>'--'.yii::t('base.verbs','Choose a Value')."--",
                    // 'class'=>'probandoSelect2',
                      //'disabled'=>($model->isBlockedField('codpuesto'))?'disabled':null,
                        ]
                    ) ?>
 </div>  
    
    
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
      <?php 
      
        echo $form->field($model, 'fechacon1')->widget(
        DatePicker::classname(), [
         'name' => 'fechacon1',
            'language' => h::app()->language,
            'options' => ['placeholder' =>yii::t('base.names', '--Seleccione un valor--')],
    //'convertFormat' => true,
                'pluginOptions' => [
                'format' => h::getFormatShowDate(),
                //'startDate' => '01-Mar-2014 12:00 AM',
                'todayHighlight' => true
                                ]
                    ]);
                ?>
  </div> 

    
    
    
    

    <?php ActiveForm::end(); ?>

</div>
