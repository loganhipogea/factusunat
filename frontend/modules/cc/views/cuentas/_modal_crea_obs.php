<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\helpers\h;
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
          
                $url=\yii\helpers\Url::to(['/cc/cuentas/modal-crea-obs','id'=>$id]);  
             
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
        <?= $form->field($model, 'obs')->textarea() ?>
       
   </div>       
    
    
          
          
     
    <?php ActiveForm::end(); ?>
     

</div>
    </div>
</div>
