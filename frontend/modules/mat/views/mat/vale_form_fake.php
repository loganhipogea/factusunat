<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use common\widgets\linkajaxgridwidget\linkAjaxGridWidget;
use yii\widgets\Pjax;
use common\helpers\h;
use yii\grid\GridView;
 use kartik\date\DatePicker;
 use common\widgets\selectwidget\selectWidget;
 use common\helpers\ComboHelper;
/* @var $this yii\web\View */
/* @var $model frontend\modules\mat\models\MatReq */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="mat-req-form">
    <br>
    <?php $form = ActiveForm::begin([
   // 'fieldClass'=>'\common\components\MyActiveField',
        'enableAjaxValidation'=>true,
    ]); ?>
      <div class="box-header">
        <div class="col-md-12">
            <div class="form-group no-margin">
                
        <?= Html::submitButton('<span class="fa fa-close"></span>   '.Yii::t('app', 'Anular'), ['class' => 'btn btn-success']) ?>
        
            </div>
        </div>
    </div>
      <div class="box-body">
    

  <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
     <?= $form->field($model, 'numerovale')->textInput(['maxlength' => true,
         'style'=>"font-weight:600;color:#740fd6;",
         ]) ?>

 </div>
   <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
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
 <?= $form->field($model, 'codal')->
            dropDownList(ComboHelper::getCboAlmacenes(null),
                  ['prompt'=>'--'.yii::t('base.verbs','Choose a Value')."--",
                    // 'class'=>'probandoSelect2',
                    // 'disabled'=>($model->hasChilds())?'disabled':null,
                        ]
                    ) ?>
 </div> 
    <?php ActiveForm::end(); ?>
 
          
</div>
    </div>
