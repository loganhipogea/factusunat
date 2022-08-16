<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use common\helpers\ComboHelper;
?>

<div class="edificios-form">
    <br>
    <?php $form = ActiveForm::begin([
        'id'=>'myformulario',
    'fieldClass'=>'\common\components\MyActiveField'
    ]); ?>
      <div class="col-md-12">
            <div class="form-group ">
            <div class="btn-group">
          <?= Html::submitButton('<span class="fa fa-save"></span>   '.Yii::t('app', 'Guardar'), ['class' => 'btn btn-success']) ?>
           
              </div>       
            </div>
        </div>

     <div class="box-body">
         <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                 <?= $form->field($model, 'codocu')->
                            dropDownList(ComboHelper::getCboDocuments(),
                            ['prompt'=>'--'.yii::t('base.verbs','Escoja un valor')."--",
                    // 'class'=>'probandoSelect2',
                      //'disabled'=>($model->isBlockedField('codpuesto'))?'disabled':null,
                                    ]
                                ) ?>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <?= $form->field($model, 'titulo')->textInput(['maxlength' => true,]) ?>

            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <?= $form->field($model, 'detalle')->textArea(['maxlength' => true,]) ?>
            </div>
       <?php echo Html::hiddenInput('grillas',is_array($grillas)?Json::encode($grillas):$grillas); ?>
    <?php ActiveForm::end(); ?>

    </div>


    </div>



