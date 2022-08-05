<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use frontend\modules\com\helpers\comboHelper;
use common\widgets\selectwidget\selectWidget;
use common\helpers\h;

/* @var $this yii\web\View */
/* @var $model frontend\modules\com\ComFacturaSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="com-factura-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>
     <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
    <div class="form-group btn-group">
        <?= Html::submitButton("<span class='fa fa-search'></span>     ".Yii::t('base.names', 'buscar'), ['class' => 'btn btn-primary']) ?>
         <?php // Html::resetButton("<span class='fa fa-eye'></span>     ".Yii::t('base.names', 'Limpiar'), ['class' => 'btn btn-success']) ?>
       <?php // Html::button("<span class='fa fa-eye'></span>     ".Yii::t('base.names', 'Ver'), ['onClick'=>"$('#buscador').toggle()",  'class' => 'btn btn-success']) ?>
        <?= Html::a(Yii::t('app', 'Create Op Tareo'), ['create'], ['class' => 'btn btn-success']) ?>
        
    </div>
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
    <?=$form->field($model, 'semana')->textInput()?>
   </div>
    
  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"> 
    <?=$form->field($model, 'semana1')->textInput()?>
   </div>
    
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
     <?php 
  // $necesi=new Parametros;
    echo selectWidget::widget([
           // 'id'=>'mipapa',
            'model'=>$model,
            'tabular'=>false,
            'form'=>$form,
            'campo'=>'direcc_id',
              'ordenCampo'=>2,
                'addCampos'=>[1,2],
        ]);  ?>

   </div>
    

    <?php ActiveForm::end(); ?>

</div>