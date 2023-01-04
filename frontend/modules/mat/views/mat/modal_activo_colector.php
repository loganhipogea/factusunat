<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use common\widgets\cbodepwidget\cboDepWidget as ComboDep;
use frontend\modules\op\helpers\ComboHelper;
use common\widgets\selectwidget\selectWidget;


/* @var $this yii\web\View */
/* @var $model frontend\modules\sigi\models\Edificios */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="edificios-form">
    <br>
    <?php $form = ActiveForm::begin([
        'id'=>'myformulario',
    'fieldClass'=>'\common\components\MyActiveField'
    ]); ?>
      <div class="box-header">
        <div class="col-md-12">
            <div class="form-group no-margin">
           <?PHP 
           $operacion=($model->isNewRecord)?'modal-crea-activo-colector':'modal-edita-activo-colector';
             
                 $url=\yii\helpers\Url::to(['/mat/mat/'.$operacion,'id'=>$id,]);  
              
             
           ?>
           <?= \common\widgets\buttonsubmitwidget\buttonSubmitWidget::widget(
                  ['idModal'=>$idModal,
                    'idForm'=>'myformulario',
                      'url'=> $url,
                     'idGrilla'=>$gridName, 
                      ]
                  )?>
            </div>
        </div>
    </div>
      <div class="box-body">
     
    
 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
     <?php 
  // $necesi=new Parametros;
    echo selectWidget::widget([
           // 'id'=>'mipapa',
            'model'=>$model,
            'form'=>$form,
            'campo'=>'ceco_id',
         'ordenCampo'=>1,
         'addCampos'=>[3],
        'options'=>['disabled'=>!$model->activo]
        ]);  ?>

 </div> 
 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
     <?php 
  // $necesi=new Parametros;
   /* echo selectWidget::widget([
           // 'id'=>'mipapa',
            'model'=>$model,
            'form'=>$form,
            'campo'=>'activo_id',
         'ordenCampo'=>2,
         'addCampos'=>[2,],
        'options'=>['disabled'=>!$model->activo]
        ]);  */?>

 </div> 
 
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
     <?= $form->field($model, 'valor')->textInput(['maxlength' => true,'disabled'=>!$model->activo,]) ?>

 </div>

   
   
 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
     
     
 <?= $form->field($model, 'codmon')->
            dropDownList(\frontend\modules\cc\helpers\comboHelper::getCboMonedas(),
                  ['prompt'=>'--'.yii::t('base.verbs','Choose a Value')."--",
                    // 'class'=>'probandoSelect2',
                      //'disabled'=>($model->isBlockedField('codpuesto'))?'disabled':null,
                        ]
                    ) ?>
 </div> 
  
      
          
     
    <?php ActiveForm::end(); ?>

</div>
    </div>
 

