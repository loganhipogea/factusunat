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
        'action' => ['index-tareo-semana'],
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
  
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
     <?php 
  // $necesi=new Parametros;
    echo selectWidget::widget([
           // 'id'=>'mipapa',
            'model'=>$model,
            'tabular'=>false,
            'form'=>$form,
            'campo'=>'codtra',
              'ordenCampo'=>2,
                'addCampos'=>[1,2],
        ]);  ?>

   </div>
     <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"> 
    <?=$form->field($model, 'ap')->textInput()?>
   </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"> 
    <?=$form->field($model, 'nombres')->textInput()?>
   </div>
   <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"> 
    <?=$form->field($model, 'semana')->textInput()?>
   </div>
    
  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"> 
    <?=$form->field($model, 'semana1')->textInput()?>
   </div>
    
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"> 
    <?=$form->field($model, 'costo')->textInput()?>
   </div>
    
  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"> 
    <?=$form->field($model, 'costo1')->textInput()?>
   </div>
    
    
    

    <?php ActiveForm::end(); ?>

</div>