<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\widgets\cbodepwidget\cboDepWidget as ComboDep;
use common\widgets\selectwidget\selectWidget;
use common\helpers\ComboHelper;
/* @var $this yii\web\View */
/* @var $model frontend\modules\logi\models\Stock */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="stock-form">
    <br>
    <?php $form = ActiveForm::begin([
    'fieldClass'=>'\common\components\MyActiveField'
    ]); ?>
      <div class="box-header">
        <div class="col-md-12">
            <div class="form-group no-margin">
                
        <?= Html::submitButton('<span class="fa fa-save"></span>   '.Yii::t('logi.labels', 'Save'), ['class' => 'btn btn-success']) ?>
            

            </div>
        </div>
    </div>
      <div class="box-body">
    
 
  <div class="col-lg-6 col-md-8 col-sm-12 col-xs-12"> 
     <?php 
  // $necesi=new Parametros;
    echo selectWidget::widget([
           // 'id'=>'mipapa',
            'model'=>$model,
            'form'=>$form,
            'campo'=>'codart',
         'ordenCampo'=>2,
         'addCampos'=>[2,3],
        ]);  ?>

 </div> 
 <div class="col-lg-6 col-md-4 col-sm-12 col-xs-12">
     <?= $form->field($model, 'cant')->textInput(['maxlength' => true]) ?>

 </div>
  <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
    <?= ComboDep::widget([
               'model'=>$model,               
               'form'=>$form,
               'data'=> ComboHelper::getCboCentros(),
               'campo'=>'codcen',
               'idcombodep'=>'stock-codal',
              
                   'source'=>[\common\models\masters\Almacenes::className()=>
                                [
                                       'campoclave'=>'codal' , //columna clave del modelo ; se almacena en el value del option del select 
                                        'camporef'=>'nomal',//columna a mostrar 
                                        'campofiltro'=>'codcen'  
                                ]
                                ],
                            ]
               
               
        )  ?>
 </div> 
  <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">    
 <?= $form->field($model, 'codal')->
            dropDownList(($model->isNewRecord)?[]:ComboHelper::getCboAlmacenes($model->codcen),
                  ['prompt'=>'--'.yii::t('base.verbs','Choose a Value')."--",
                    // 'class'=>'probandoSelect2',
                      //'disabled'=>($model->isBlockedField('codpuesto'))?'disabled':null,
                        ]
                    ) ?>
 </div> 
 
  <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'ubicacion')->textInput(['maxlength' => true]) ?>

 </div>
  
    
  <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'valor')->textInput(['maxlength' => true]) ?>

 </div>
  
  <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'pventa')->textInput(['maxlength' => true]) ?>

 </div>
  
  
     
    <?php ActiveForm::end(); ?>

</div>
    </div>
