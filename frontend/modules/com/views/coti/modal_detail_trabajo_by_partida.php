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
      <?php
       $unidad=h::gsetting('op', 'um_hora');
      $form = ActiveForm::begin([
       'id'=>'myformulario',
    'fieldClass'=>'\common\components\MyActiveField'
    ]); ?>
      <div class="box-header">
          
        <div class="col-md-12">
            <div class="form-group no-margin">
          <?php
          $operacion=($model->isNewRecord)?'modal-new-detcoti-by-partida':'modal-edit-detcoti-by-partida';
          
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
      <?php /*$form->field($model, 'servicio_id')->
            dropDownList(ComboHelper::getCboServicios(),
                    ['prompt'=>'--'.yii::t('base.verbs','Seleccione un valor')."--",
                    // 'class'=>'probandoSelect2',
                      //'disabled'=>($model->isBlockedField('codpuesto'))?'disabled':null,
                        ]
                    )  */
       /// echo $form->field($model, 'descripcion')->textInput([]) ; 
      ?>
          <?php echo $model->getScenario()  ?>
        </div>
       <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <?= 
                   //$model->activo=false;
            $form->field($model, 'codcargo')->
            dropDownList(ComboHelper::getCboCargos(),
                    ['prompt'=>'--'.yii::t('base.verbs','Seleccione un valor')."--",
                    // 'class'=>'probandoSelect2',
                      //'disabled'=>($model->isBlockedField('codpuesto'))?'disabled':null,
                        ]
                    )  ?>

        </div>       
     <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <?php 
                   //$model->activo=false;
           /*echo  $form->field($model, 'codum')->
            dropDownList(ComboHelper::getCboUms(),
                    ['prompt'=>'--'.yii::t('base.verbs','Seleccione un valor')."--",
                    ]
                    )*/ 
                echo $form->field($model,'codum')->
                     textInput(['value'=>$unidad,'disabled'=>true]);
                
                ?>

        </div>  
     
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <?php  
                   
           /*echo $form->field($model, 'punitcalculado',
                    []
                    )->textInput(['value'=>$model->valorUnitario()]) */ ?>

        </div> 
     <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">     
        <?= $form->field($model, 'cant')->textInput([]) ?>
     </div>
      <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">     
        <?php //echo $form->field($model, 'punit')->textInput([]) ?>
     </div>
          <?= $form->field($model, 'codum')->hiddenInput(['value'=> $unidad])->label('') ?>
            <?= $form->field($model, 'cotigrupo_id')->hiddenInput([])->label('') ?>
            <?= $form->field($model, 'tipo')->hiddenInput([])->label('') ?>
              
              <?php ActiveForm::end(); ?>
     

</div>
    </div>
</div>
