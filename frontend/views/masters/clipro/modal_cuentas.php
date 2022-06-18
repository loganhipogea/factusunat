<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\helpers\h;
 use common\helpers\ComboHelper;  
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
          $operacion=($model->isNewRecord)?'crea-cuenta':'edita-cuenta';             
          $url=\yii\helpers\Url::to(['/masters/clipro/'.$operacion,'id'=>$id]); 
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
      
    
   <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
        <?= $form->field($model, 'nombre')->textInput(['disabled'=>($model->isNewRecord)?false:true]) ?>
   </div>
          
   <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">    
        <?= $form->field($model, 'numero')->textInput(['disabled'=>($model->isNewRecord)?false:true]) ?>
   </div> 
   <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">    
        <?= $form->field($model, 'cci')->textInput(['disabled'=>($model->isNewRecord)?false:true]) ?>
   </div> 
  
   <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
    <?= $form->field($model, 'tipo')->
            dropDownList(ComboHelper::getTablesValues('cuentas.tipo') ,
                    ['prompt'=>'--'.yii::t('base.verbs','Choose a Value')."--",
                    // 'class'=>'probandoSelect2',
                        ]
                    ) ?>
    </div>       
     <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">    
        <?= $form->field($model, 'banco_id')->
            dropDownList(ComboHelper::getCboBancos(),
                  ['prompt'=>'--'.yii::t('base.verbs','Choose a Value')."--",
                    // 'class'=>'probandoSelect2',
                      //'disabled'=>($model->isBlockedField('codpuesto'))?'disabled':null,
                        ]
                    ) ?>
   </div> 
    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">    
        <?= $form->field($model, 'codmon')->
            dropDownList(ComboHelper::getCboMonedas(),
                  ['prompt'=>'--'.yii::t('base.verbs','Choose a Value')."--",
                    // 'class'=>'probandoSelect2',
                      //'disabled'=>($model->isBlockedField('codpuesto'))?'disabled':null,
                        ]
                    ) ?>
   </div> 
   <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">    
        <?= $form->field($model, 'detalles')->textarea(); ?>
 </div>  
    
   
            
     
    <?php ActiveForm::end(); ?>
     

</div>
    </div>
</div>
