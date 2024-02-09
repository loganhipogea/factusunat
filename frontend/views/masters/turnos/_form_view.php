<?php

use yii\widgets\ActiveForm;
use common\helpers\ComboHelper;
use common\widgets\linkajaxgridwidget\linkAjaxGridWidget;
USE yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $model common\models\masters\Turnos */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="turnos-form">
    <br>
    <?php $form = ActiveForm::begin([
    'fieldClass'=>'\common\components\MyActiveField'
    ]); ?>
      
      <div class="box-body">
 
  <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
      <?= 
            $form->field($model, 'codarea_id')->
            dropDownList(ComboHelper::getCboAreas() ,
                    ['prompt'=>'--'.yii::t('base.verbs','Seleccione un valor')."--",
                    // 'class'=>'probandoSelect2',
                      'disabled'=>true,
                        ]
                    )  ?>

 </div>
  <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'desturno')->textInput(['maxlength' => true,'disabled'=>true]) ?>

 </div>
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
     <?= $form->field($model, 'detalle')->textarea(['rows' => 3,'disabled'=>true]) ?>

 </div>
  <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">
     <?= $form->field($model, 'activo')->checkbox(['disabled'=>true]) ?>

 </div>
     
    <?php ActiveForm::end(); ?>
     
          
          
          
          
          
</div>
    </div>
