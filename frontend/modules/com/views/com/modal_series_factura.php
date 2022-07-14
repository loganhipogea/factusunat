<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

use frontend\modules\com\helpers\ComboHelper;
use common\helpers\h;

use common\models\masters\VwSociedades;
USE common\models\masters\Centros;


use yii\widgets\Pjax;


/* @var $this yii\web\View */
/* @var $model frontend\modules\com\models\ComOv */
/* @var $form yii\widgets\ActiveForm */
?>


 
     <div class="box box-success">
    <?php
    
    $form = ActiveForm::begin([
        'id'=>'myformulario',
        //'enableAjaxValidation'=>true
        ]); ?>  
    <div class="col-md-12">
            <div class="form-group">
            <?php
            echo h::gsetting('com','formatoSeries');
          $operacion=($model->isNewRecord)?'create':'edit';
          
          $url=\yii\helpers\Url::to(['/com/com/modal-'.$operacion.'-serie','id'=>$id]);
              
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
     <?= $form->field($model,'codcen')->hiddenInput() ?>
    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
     <?= $form->field($model, 'tipodoc')->
            dropDownList(h::sunat()->graw('s.01.tdoc')->combo()->data ,
                    ['prompt'=>'--'.yii::t('base.verbs','Choose a Value')."--",
                    // 'class'=>'probandoSelect2',
                       // 'disabled'=>$hasChilds
                        ]
                    ) ?>
    </div>
         
   <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
     <?= $form->field($model, 'serie')->textInput()
            ?>
    </div>
    
   
   
    <?php 
     
    ActiveForm::end()
        ?>
     
         
      
     
     
</div>
  
  