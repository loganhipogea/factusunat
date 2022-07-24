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
          $operacion=($model->isNewRecord)?'modal-assign-document':'modal-edit-document';             
          $url=\yii\helpers\Url::to(['/masters/trabajadores/'.$operacion,'id'=>$id]); 
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
    <?= $form->field($model, 'codocu')->
            dropDownList(ComboHelper::getCboDocuments() ,
                    ['prompt'=>'--'.yii::t('base.verbs','Choose a Value')."--",
                    // 'class'=>'probandoSelect2',
                        ]
                    ) ?>
    </div>
  
   <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">    
        <?= $form->field($model, 'numero')->textInput() ?>
   </div>
   <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">    
        <?= $form->field($model, 'descripcion')->textInput() ?>
   </div>
   <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">    
        <?= $form->field($model, 'textointerno')->textArea() ?>
   </div>       
       
   
            
     
    <?php ActiveForm::end(); ?>
     

</div>
    </div>
</div>



