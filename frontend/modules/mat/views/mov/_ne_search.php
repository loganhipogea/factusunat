<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
 use kartik\date\DatePicker;
 use common\helpers\h;
 use frontend\modules\mat\helpers\comboHelper;
/* @var $this yii\web\View */
/* @var $model frontend\modules\mat\models\MatReqSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="mat-req-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index-ne'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>
     <div class="form-group">
        <div class="btn-group">
        <?= Html::submitButton(Yii::t('app', 'Buscar'), ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Crear Ingreso'), ['crea-ne'], ['class' => 'btn btn-success']) ?>
        </div>
     </div>
     <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <?= $form->field($model, 'numero')->textInput(['maxlength' => true]) ?>
    </div>  
    
    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
     <?= $form->field($model, 'descri')->textInput(['maxlength' => true,  ]) ?>
     
 </div>
    
    
    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
     <?= $form->field($model, 'serie')->textInput(['maxlength' => true,  ]) ?>
     
 </div>
    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">    
 <?= $form->field($model, 'rotativo')->
            dropDownList(['1'=>'ROTATIVO','0'=>'CONVENCIONAL'],
                  ['prompt'=>'--'.yii::t('base.verbs','Choose a Value')."--",
                    // 'class'=>'probandoSelect2',
                      //'disabled'=>($model->isBlockedField('codpuesto'))?'disabled':null,
                        ]
                    ) ?>
 </div>  
    
   <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">    
 <?= $form->field($model, 'codcen')->
            dropDownList(comboHelper::getCboCentros(null),
                  ['prompt'=>'--'.yii::t('base.verbs','Choose a Value')."--",
                    // 'class'=>'probandoSelect2',
                      //'disabled'=>($model->isBlockedField('codpuesto'))?'disabled':null,
                        ]
                    ) ?>
 </div> 
  <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">    
 <?= $form->field($model, 'codcencli')->
            dropDownList(comboHelper::getCboCentros(null),
                  ['prompt'=>'--'.yii::t('base.verbs','Choose a Value')."--",
                    // 'class'=>'probandoSelect2',
                      //'disabled'=>($model->isBlockedField('codpuesto'))?'disabled':null,
                        ]
                    ) ?>
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

   
    

    <?php ActiveForm::end(); ?>

</div>
