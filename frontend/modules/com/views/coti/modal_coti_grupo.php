<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\helpers\ComboHelper;
use common\helpers\h;
//use common\widgets\selectwidget\selectWidget;
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
          $operacion=($model->isNewRecord)?'modal-new-grupo-coti':'modal-edit-grupo-coti';
          
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
      <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">     
        <?= $form->field($model, 'item')->textInput(['disabled'=>true]) ?>
   </div> 
    <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">     
        <?= $form->field($model, 'descripartida')->textInput() ?>
   </div> 
     
    <?php ActiveForm::end(); ?>
     

</div>
    </div>
</div>
