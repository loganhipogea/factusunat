<?php

use yii\helpers\Html;
use yii\helpers\Url;
use frontend\modules\clasi\helpers\ComboHelper;
use yii\widgets\ActiveForm;
use common\widgets\cbodepwidget\cboDepWidget as ComboDep;

use common\widgets\selectwidget\selectWidget;


/* @var $this yii\web\View */
/* @var $model frontend\modules\sigi\models\Edificios */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="edificios-form">
    <br>
    <?=$gridName?>
    <?php $form = ActiveForm::begin([
        'id'=>'myformulario',
    'fieldClass'=>'\common\components\MyActiveField'
    ]); ?>
      <div class="box-header">
        <div class="col-md-12">
            <div class="form-group no-margin">
           <?PHP 
             IF($model->isNewRecord){
               $url=\yii\helpers\Url::to(['site/modal-crear-contenido']);  
                 //$operacion=($model->isNewRecord)?'mod-agrega-mat':'mod-edit-mat';
             }else{
                $url=\yii\helpers\Url::to(['site/modal-editar-contenido','id'=>$model->id]);  
             }
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
     
     <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <?= $form->field($model, 'clave')->textInput(['maxlength' => true,'disabled'=>true]) ?>

    </div>
    
 
 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
     <?= $form->field($model, 'titulo')->textInput(['maxlength' => true]) ?>

 </div>
 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <?PHP
     echo $form->field($model, 'cuerpo')
             ->widget(\dosamigos\ckeditor\CKEditor::className(), [
        'options' => ['rows' => 2],
         'clientOptions'=>['language'=>'es',
             ],
        ]);
      ?>
 </div>
  
      
          
     
    <?php ActiveForm::end(); ?>

</div>
    </div>
 <?php 

 
  ?>


