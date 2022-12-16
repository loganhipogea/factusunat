<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use frontend\modules\com\helpers\ComboHelper;
use common\widgets\selectwidget\selectWidget;
use kartik\date\DatePicker;
use common\helpers\h;
/* @var $this yii\web\View */
/* @var $model frontend\modules\mat\models\MatPetofertaSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="mat-petoferta-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
    <div class="btn-group">
        <?= Html::submitButton(Yii::t('base.names', 'Buscar'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('base.names', 'Reset'), ['class' => 'btn btn-default']) ?>
         <?= Html::a(Yii::t('app', 'Crear Petición'), ['crea-pet-oferta'], ['class' => 'btn btn-success']) ?>
    </div>
    </div>
     <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"> 
     <?php 
  // $necesi=new Parametros;
    echo selectWidget::widget([
           // 'id'=>'mipapa',
            'model'=>$model,
            'tabular'=>false,
            'form'=>$form,
            'campo'=>'codpro',
              'ordenCampo'=>2,
                'addCampos'=>[1,2],
        ]);  ?>

   </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"> 
     <?php 
  // $necesi=new Parametros;
    echo selectWidget::widget([
           // 'id'=>'mipapa',
            'model'=>$model,
            'tabular'=>false,
            'form'=>$form,
            'campo'=>'codart',
              'ordenCampo'=>2,
                'addCampos'=>[1,2],
        ]);  ?>

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
    <?=$form->field($model, 'pventa')->textInput()?>
   </div>
    
  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"> 
    <?=$form->field($model, 'pventa1')->textInput()?>
   </div>
    
    <?php ActiveForm::end(); ?>

</div>
