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
          $operacion=($model->isNewRecord)?'modal-agrega-documento':'modal-edita-documento';             
          $url=\yii\helpers\Url::to(['/masters/transa/'.$operacion,'codtrans'=>$codtrans]); 
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
    <?php 
    /*
     * Si la transacción exige validacion de documento
     * entonces debemos filtrar solo aquellos documentos
     * que tengan asociado una clase al campo 'modelo'
     */
        if($model->transa->exigirValidacion){
            $datos=ComboHelper::getCboDocumentsWithModel();
        }else{
            $datos=ComboHelper::getCboDocuments();
        }
    
    ?>
    <?= $form->field($model, 'codocu')->
            dropDownList($datos ,
                    ['prompt'=>'--'.yii::t('base.verbs','Choose a Value')."--",
                    // 'class'=>'probandoSelect2',
                        ]
                    ) ?>
    </div>
            
     
    <?php ActiveForm::end(); ?>
     

</div>
    </div>
</div>



