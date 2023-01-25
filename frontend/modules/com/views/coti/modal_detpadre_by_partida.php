<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use frontend\modules\com\helpers\ComboHelper;
use common\helpers\h;
use common\widgets\selectwidget\selectWidget;
use yii\helpers\Url;

//use common\widgets\cbodepwidget\cboDepWidget as ComboDep;
   
/* @var $this yii\web\View */
/* @var $model frontend\modules\cc\models\CcCuentas */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cc-cuentas-form">
     <div class="box-body">
      <?php $form = ActiveForm::begin([
       'id'=>'myformulario',
    'fieldClass'=>'\common\components\MyActiveField'
    ]); ?>
      <div class="box-header">
          
        <div class="col-md-12">
            <div class="form-group no-margin">
            <?php
          $operacion=($model->isNewRecord)?'modal-new-detpadre-by-partida':'modal-edit-detpadre-by-partida';
          
          $url=\yii\helpers\Url::to(['/com/coti/'.$operacion,'id'=>$id]);
              
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
                <?= 
                   //$model->activo=false;
            $form->field($model, 'codum')->
            dropDownList(ComboHelper::getCboUms(),
                    ['prompt'=>'--'.yii::t('base.verbs','Seleccione un valor')."--",
                    // 'class'=>'probandoSelect2',
                      //'disabled'=>($model->isBlockedField('codpuesto'))?'disabled':null,
                        ]
                    )  ?>

        </div>
     <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">     
        <?= $form->field($model, 'cant')->textInput([]) ?>
     </div>
      <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">     
        <?= $form->field($model, 'descripcion')->textInput([]) ?>
     </div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <?= 
                   //$model->activo=false;
            $form->field($model, 'coticeco_id')->
            dropDownList(ComboHelper::cecosCoti($model->coti_id),
                    ['prompt'=>'--'.yii::t('base.verbs','Seleccione un valor')."--",
                    // 'class'=>'probandoSelect2',
                      //'disabled'=>($model->isBlockedField('codpuesto'))?'disabled':null,
                        ]
                    )  ?>

        </div>  
    
     
     
      <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">     
        <?= $form->field($model, 'punit')->textInput(['disabled'=>true]) ?>
     </div>
     <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">     
        <?= $form->field($model, 'ptotal')->textInput(['disabled'=>true]) ?>
     </div>
     <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">     
        <?= $form->field($model, 'mostrar')->checkbox([]) ?>
     </div>
          <?= $form->field($model, 'coticeco_id')->hiddenInput([]) ?>
    <?php ActiveForm::end(); ?>
     

</div>
    </div>
</div>
