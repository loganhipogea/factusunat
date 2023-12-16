<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\masters\VwSociedades;
USE common\widgets\imagewidget\ImageWidget;
/* @var $this yii\web\View */
/* @var $model frontend\modules\mat\models\MatActivos */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="mat-activos-form">
    <br>
    <?php $form = ActiveForm::begin([
    'fieldClass'=>'\common\components\MyActiveField'
    ]); ?>
      <div class="box-header">
        <div class="col-md-12">
            <div class="form-group no-margin">
                
        <?= Html::submitButton('<span class="fa fa-save"></span>   '.Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
            

            </div>
        </div>
    </div>
      <div class="box-body">
    
 <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
  </div>
  <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'codigo')->textInput(['maxlength' => true]) ?>

 </div>
  <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true]) ?>

 </div>
  <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'marca')->textInput(['maxlength' => true]) ?>

 </div>
  <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'modelo')->textInput(['maxlength' => true]) ?>

 </div>
  <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'serie')->textInput(['maxlength' => true]) ?>

 </div>
  <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'v_adquisicion')->textInput(['maxlength' => true]) ?>

 </div>
  <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'vida_util')->textInput() ?>

 </div>
  <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'v_rescate')->textInput(['maxlength' => true]) ?>

 </div>
  <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'parent_id')->textInput() ?>

 </div>
   <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">    
 <?= $form->field($model, 'tipo')->
            dropDownList($model->comboDataField('tipo'),
                  ['prompt'=>'--'.yii::t('base.verbs','Choose a Value')."--",
                    // 'class'=>'probandoSelect2',
                      //'disabled'=>$bloqueado,
                        ]
                    ) ?>
 </div> 
          

 <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">    
 <?= $form->field($model, 'codestado')->
            dropDownList($model->comboDataField('codestado'),
                  ['prompt'=>'--'.yii::t('base.verbs','Choose a Value')."--",
                    // 'class'=>'probandoSelect2',
                      //'disabled'=>$bloqueado,
                        ]
                    ) ?>
 </div>          
 <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">    
 <?= $form->field($model, 'modalidad')->
            dropDownList($model->comboDataField('modalidad'),
                  ['prompt'=>'--'.yii::t('base.verbs','Choose a Value')."--",
                    // 'class'=>'probandoSelect2',
                      //'disabled'=>$bloqueado,
                        ]
                    ) ?>
 </div>  
 <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">    
 <?= $form->field($model, 'codsoc')->
            dropDownList(VwSociedades::societyList(),
                  ['prompt'=>'--'.yii::t('base.verbs','Choose a Value')."--",
                    // 'class'=>'probandoSelect2',
                      //'disabled'=>$bloqueado,
                        ]
                    ) ?>
 </div>  
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">  
    <?php if(!$model->isNewRecord){  ?>
    <?= \common\widgets\imagewidget\ImageWidget::widget([
        'name'=>'imagenrep',
        'isImage'=>true,  
        'alto'=>200,
        'ancho'=>200, 
        'model'=>$model,
        'extensions'=>['png','jpg'],
            ]); ?>
   
    <?= \nemmo\attachments\components\AttachmentsTable::widget([
	'model' => $model,
	//'showDeleteButton' => false, // Optional. Default value is true
        ])?>
    <?php } ?> 
  </div>    
      
  <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
  </div>
  <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
  </div>
  <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
  </div>
  <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
  </div>
  <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
  </div>
     
    <?php ActiveForm::end(); ?>

</div>
    </div>
