<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use common\widgets\inputajaxwidget\inputAjaxWidget;
use frontend\modules\com\helpers\ComboHelper;
use common\helpers\h;
use yii\widgets\Pjax;
use kartik\date\DatePicker;
/* @var $this yii\web\View */
/* @var $model frontend\modules\com\models\ComOv */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="com-ov-form">
 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
     <br>
     <br>
     <div class="box box-success">
    <?php $form = ActiveForm::begin([
        'id'=>'Form_general',
        'enableAjaxValidation'=>true
        ]); ?>  
    <div class="form-group">
        <?= Html::submitButton(Yii::t('base.names', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>
   <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
     <?= $form->field($model, 'caja_id')->
            dropDownList(ComboHelper::getCboCajas() ,
                    ['prompt'=>'--'.yii::t('base.verbs','Choose a Value')."--",
                    // 'class'=>'probandoSelect2',
                        ]
                    ) ?>
    </div>
     <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12"> 
      <?= $form->field($model, 'fecha')->widget(DatePicker::class, [
                            'language' => h::app()->language,
                           'pluginOptions'=>[
                                       'format' => h::getFormatShowDate(),
                                   'changeMonth'=>true,
                                  'changeYear'=>true,
                                 'yearRange'=>'2010:'.date('Y'),
                               ],
                          
                            //'dateFormat' => h::getFormatShowDate(),
                            'options'=>[
                                'class'=>'form-control',
                                'disabled'=>!$model->hasDocuments()
                                ]
                            ]) ?>

   </div>
    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
     <?= $form->field($model, 'codcen')->
            dropDownList(ComboHelper::getCboCentros() ,
                    ['prompt'=>'--'.yii::t('base.verbs','Choose a Value')."--",
                    // 'class'=>'probandoSelect2',
                        ]
                    ) ?>
    </div>
   <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12"> 
     <span class="badge badge-pill badge-primary"><?php 
     //echo  $model->getInvoices()->createCommand()->rawSql;
     echo $model->getInvoices()->count()?></span>
      <span class="badge badge-pill badge-danger"><?=$model->getVouchers()->count()?></span>

   </div>
   
    
   
    <?php  ActiveForm::end() ?>
    
      
    
  </div>
</div>
    </div>
  