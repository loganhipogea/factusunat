<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\helpers\ComboHelper;
/* @var $this yii\web\View */
/* @var $model common\models\masters\Cuadrillas */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cuadrillas-form">
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
      <?= 
            $form->field($model, 'codarea_id')->
            dropDownList(ComboHelper::getCboAreas() ,
                    ['prompt'=>'--'.yii::t('base.verbs','Seleccione un valor')."--",
                    // 'class'=>'probandoSelect2',
                      //'disabled'=>($model->isBlockedField('codpuesto'))?'disabled':null,
                        ]
                    )  ?>

 </div>
  <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
     <?=  $form->field($model, 'codgrupo_id')->
            dropDownList(ComboHelper::getCboGruposTrabajo() ,
                    ['prompt'=>'--'.yii::t('base.verbs','Seleccione un valor')."--",
                    // 'class'=>'probandoSelect2',
                      //'disabled'=>($model->isBlockedField('codpuesto'))?'disabled':null,
                        ]
                    )  ?>

 </div>
  <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true]) ?>

 </div>
  <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">
     <?= $form->field($model, 'textodetalle')->textarea(['rows' => 6]) ?>

 </div>
     
    <?php ActiveForm::end(); ?>

</div>
    </div>
