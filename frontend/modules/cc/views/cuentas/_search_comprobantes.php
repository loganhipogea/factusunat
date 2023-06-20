<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use frontend\modules\cc\helpers\comboHelper;
use common\widgets\selectwidget\selectWidget;
use common\helpers\h;


/* @var $this yii\web\View */
/* @var $model frontend\modules\com\ComFacturaSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="com-factura-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index-comprobantes'],
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
    
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">    
        <?php 
  // $necesi=new Parametros;
     echo selectWidget::widget([
           // 'id'=>'mipapa',
            'model'=>$model,
            'form'=>$form,
            'campo'=>'codpro',
         'ordenCampo'=>0,
         'addCampos'=>[1,2],
        ]);  ?>
    </div>
   <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"> 
    <?=$form->field($model, 'glosa')->textInput()?>
   </div>
    
   <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
    .
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
         'name' => 'fecha',
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
                        <?= $form->field($model, 'codmon')->
                            dropDownList(comboHelper::getCboMonedas(),
                            ['prompt'=>'--'.yii::t('base.verbs','Escoja un valor')."--",
                    // 'class'=>'probandoSelect2',
                      //'disabled'=>($model->isBlockedField('codpuesto'))?'disabled':null,
                                    ]
                                ) ?>
     </div>  
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">    
                        <?= $form->field($model, 'codocu')->
                            dropDownList(comboHelper::getCboDocuments(),
                            ['prompt'=>'--'.yii::t('base.verbs','Escoja un valor')."--",
                    // 'class'=>'probandoSelect2',
                      //'disabled'=>($model->isBlockedField('codpuesto'))?'disabled':null,
                                    ]
                                ) ?>
     </div>  
    
   <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12"> 
    <?=$form->field($model, 'monto')->textInput()?>
   </div>
   <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12"> 
    <?=$form->field($model, 'monto1')->textInput()?>
   </div>
    
    <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12"> 
    <?=$form->field($model, 'rucpro')->textInput()?>
   </div>
  
  

    <?php ActiveForm::end(); ?>

</div>
