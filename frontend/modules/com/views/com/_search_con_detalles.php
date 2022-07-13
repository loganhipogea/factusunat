<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use frontend\modules\com\helpers\ComboHelper;
use common\widgets\selectwidget\selectWidget;
use common\helpers\h;

/* @var $this yii\web\View */
/* @var $model frontend\modules\com\ComFacturaSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="com-factura-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index-invoices'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>
     <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
    <div class="form-group">
        <?= Html::submitButton("<span class='fa fa-search'></span>     ".Yii::t('base.names', 'buscar'), ['class' => 'btn btn-primary']) ?>
         <?php // Html::resetButton("<span class='fa fa-eye'></span>     ".Yii::t('base.names', 'Limpiar'), ['class' => 'btn btn-success']) ?>
       <?php // Html::button("<span class='fa fa-eye'></span>     ".Yii::t('base.names', 'Ver'), ['onClick'=>"$('#buscador').toggle()",  'class' => 'btn btn-success']) ?>
   
        
    </div>
     </div>
  <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
      <?php 
      
        echo $form->field($model, 'femision')->widget(
        DatePicker::classname(), [
         'name' => 'femision',
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
      <?php 
        echo $form->field($model, 'femision1')->widget(
        DatePicker::classname(), [
         'name' => 'femision1',
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
        <?= 
            $form->field($model, 'codestado')->
            dropDownList($model->estados(),
                    ['prompt'=>'--'.yii::t('base.verbs','Escoja un valor')."--",
                        //'enableAjaxValidation' => true,
                    // 'class'=>'probandoSelect2',
                      //'disabled'=>($model->isBlockedField('codpuesto'))?'disabled':null,
                        ]
                    )  ?>
     <?php //echo cboperiodos::widget(['model'=>$model,'attribute'=>'codperiodo', 'form'=>$form]) ?>
  </div>
    
    
    
   <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12"> 
    <?=$form->field($model, 'rucpro')->textInput()?>
   </div>
    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12"> 
    <?=$form->field($model, 'nombre_cliente')->textInput()?>
   </div>
    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
        <?= 
            $form->field($model, 'sunat_tipodoc')->
            dropDownList(
                    h::sunat()->graw('s.01.tdoc')->combo()->data
                    ,
                    ['prompt'=>'--'.yii::t('base.verbs','Escoja un valor')."--",
                        //'enableAjaxValidation' => true,
                    // 'class'=>'probandoSelect2',
                      //'disabled'=>($model->isBlockedField('codpuesto'))?'disabled':null,
                        ]
                    )  ?>
     <?php //echo cboperiodos::widget(['model'=>$model,'attribute'=>'codperiodo', 'form'=>$form]) ?>
  </div>
    
    
    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12"> 
    <?=$form->field($model, 'total')->textInput()?>
    </div>
     <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12"> 
    <?=$form->field($model, 'total1')->textInput()?>
    </div>
 <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
        <?= 
            $form->field($model, 'codmon')->
            dropDownList(['PEN'=>'PEN','USD'=>'USD'] ,
                    ['prompt'=>'--'.yii::t('base.verbs','Escoja un valor')."--",
                        //'enableAjaxValidation' => true,
                    // 'class'=>'probandoSelect2',
                      //'disabled'=>($model->isBlockedField('codpuesto'))?'disabled':null,
                        ]
                    )  ?>
     <?php //echo cboperiodos::widget(['model'=>$model,'attribute'=>'codperiodo', 'form'=>$form]) ?>
  </div>
   <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
    <?=$form->field($model, 'descripcion')->textInput()?>
    </div>
    

    <?php ActiveForm::end(); ?>

</div>
