<?php

use yii\helpers\Html;
use common\helpers\ComboHelper;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\masters\Maestrocompo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="maestrocompo-form">
    <?php $form = ActiveForm::begin([
       'id'=>'myformulario',
    'fieldClass'=>'\common\components\MyActiveField'
    ]); ?>
      <div class="box-header">
          
        <div class="col-md-12">
            <div class="form-group no-margin">
            <?php
          $operacion=($model->isNewRecord)?'creaconversion':'editacontacto';             
          $url=\yii\helpers\Url::to(['/masters/materials/'.$operacion,'id'=>$id]); 
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
     
  <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
    <?php $elementos =ComboHelper::getCboUms() ;
      unset($elementos[$model->material->codum]);
     
    ?>
    
    <?= $form->field($model, 'codum')->
            dropDownList($elementos ,
                    ['prompt'=>'--'.yii::t('base.verbs','Choose a Value')."--",
                    // 'class'=>'probandoSelect2',
                      //'disabled'=>($model->isBlockedField('codum1'))?'disabled':null,
                        ]
                    )->label(yii::t('base.names','Esta unidad de medida ')); ?>
</div>
   
    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
    <?php 
    $etiqueta=yii::t('base.names','Equivale a '.$model->material->codum.' s');
    echo $form->field($model, 'valor1')->textInput(['maxlength' => true])
            ->label($etiqueta); ?>
</div>
   
  <?= $form->field($model, 'codart')->hiddenInput(['value'=>$codigo])->label(''); ?>
    
    <?php ActiveForm::end(); ?>
</div>

