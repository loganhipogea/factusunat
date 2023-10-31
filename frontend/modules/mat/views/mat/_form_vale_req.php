<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

use yii\widgets\Pjax;
use common\helpers\h;
use frontend\modules\mat\helpers\comboHelper;
 use kartik\date\DatePicker;
 use common\widgets\selectwidget\selectWidget;
 use common\widgets\inputajaxwidget\inputAjaxWidget;
/* @var $this yii\web\View */
/* @var $model frontend\modules\mat\models\MatReq */
/* @var $form yii\widgets\ActiveForm */
?>

<?php

?>

<div class="mat-req-form">
    <br>
    <?php $form = ActiveForm::begin([
       //'action'=>'crea-vale-req-all',
   // 'fieldClass'=>'\common\components\MyActiveField'
      'enableAjaxValidation'=>true
    ]); ?>
      <div class="box-header">
    
        <div class="col-md-12">
            <div class="btn-group">
             
        <?= Html::submitButton('<span class="fa fa-save"></span>   '.Yii::t('app', 'Grabar'), ['class' => 'btn btn-success']) ?>
            <?php  
              
              echo Html::button( '<span class="fa fa-check-circle"></span>   '.Yii::t('base.names', 'Aprobar'),
                  ['class' => 'btn btn-success','href' => '#','id'=>'btn-aprobar']
                 );
              ?> 
             
            </div>
        </div>
        
    </div>
      <div class="box-body">
  <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">    
 <?= $form->field($model, 'codal')->
            dropDownList(comboHelper::getCboAlmacenes(null),
                  ['prompt'=>'--'.yii::t('base.verbs','Choose a Value')."--",
                    // 'class'=>'probandoSelect2',
                     //'disabled'=>($model->hasChilds())?'disabled':null,
                        ]
                    ) ?>
 </div>   

  
  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
     <?php 
  // $necesi=new Parametros;
     
    echo selectWidget::widget([
           // 'id'=>'mipapa',
            'model'=>$model,
            'form'=>$form,
            'campo'=>'numerodoc',
         //'ordenCampo'=>0,
         //'addCampos'=>[0],
        //'disabled'=>true,
        ]);  ?>


 </div>

     
    <?php ActiveForm::end(); ?>
  
       
</div>
    </div>
