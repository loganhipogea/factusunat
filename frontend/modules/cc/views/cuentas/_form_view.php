<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\helpers\ComboHelper;

use common\widgets\selectwidget\selectWidget;
use common\widgets\cbodepwidget\cboDepWidget as ComboDep;
/* @var $this yii\web\View */
/* @var $model frontend\modules\cc\models\CcCuentas */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cc-cuentas-form">
     <div class="box-body">
      <?php $form = ActiveForm::begin([
    'fieldClass'=>'\common\components\MyActiveField'
    ]); ?>
      <div class="box-header">
          
        <div class="col-md-12">
            <div class="form-group btn-group">
         
          <?= Html::submitButton('<span class="fa fa-save"></span>   '.Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
            

                  

            </div>
        </div>
    </div>
     
  
      <div class="box-body">
    
 
  
   <div class="col-lg-6 col-md-4 col-sm-12 col-xs-12">    
 <?= $form->field($model, 'codmon')->
            dropDownList(comboHelper::getCboMonedas(),
                  ['prompt'=>'--'.yii::t('base.verbs','Escoja un valor')."--",
                    // 'class'=>'probandoSelect2',
                    'disabled'=>true,
                      //'disabled'=>($model->isBlockedField('codpuesto'))?'disabled':null,
                        ]
                    ) ?>
 </div>
  
 <div class="col-lg-6 col-md-8 col-sm-12 col-xs-12">    
  <?php 
   echo  $form->field($model, 'codpro')->textInput(['disabled'=>true]);
   echo  $form->field($model, 'codpro')->textInput(['value'=>$model->clipro->despro,'disabled'=>true]);
  ?>
 </div>
  <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
     <?= 
            $form->field($model, 'tipo')->
            dropDownList($model->comboDataField('tipo') ,
                    ['prompt'=>'--'.yii::t('base.verbs','Seleccione un valor')."--",
                        'disabled'=>true,
                    // 'class'=>'probandoSelect2',
                      //'disabled'=>($model->isBlockedField('codpuesto'))?'disabled':null,
                        ]
                    )  ?>
</div>  
   <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
     <?= 
            $form->field($model, 'banco_id')->
            dropDownList(comboHelper::getCboBancos() ,
                    ['prompt'=>'--'.yii::t('base.verbs','Seleccione un valor')."--",
                         'disabled'=>true,
                    // 'class'=>'probandoSelect2',
                      //'disabled'=>($model->isBlockedField('codpuesto'))?'disabled':null,
                        ]
                    )  ?>
</div>  
  <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
    
 <?= $form->field($model, 'socio')->textInput(['disabled'=>true]) ?>

</div>  
   <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">    
 <?= $form->field($model, 'nombre')->textInput(['disabled'=>true]) ?>
 </div>
  <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">    
 <?= $form->field($model, 'numero')->textInput(['disabled'=>true])?>
 </div>
   <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">    
 <?= $form->field($model, 'cci')->textInput(['disabled'=>true])?>
 </div>        
 </div>
  <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">    
 <?= $form->field($model, 'activa')->checkbox(['disabled'=>true])?>
 </div> 
 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">    
 <?= $form->field($model, 'detalles')->
 textarea(['disabled'=>true]) ?>
 </div> 
          
     

     
    <?php ActiveForm::end(); ?>
     
    

</div>
    </div>
