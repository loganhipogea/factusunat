<?php
 use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\helpers\Url;
USE common\helpers\h;
use yii\widgets\ActiveForm;
use common\widgets\linkajaxgridwidget\linkAjaxGridWidget;
use  common\widgets\selectwidget\selectWidget;
use frontend\modules\mat\helpers\ComboHelper;
use yii\widgets\Pjax;
use yii\grid\GridView;
use common\widgets\inputajaxwidget\inputAjaxWidget;
use common\widgets\cbodepwidget\cboDepWidget as ComboDep;
/* @var $this yii\web\View */
/* @var $model frontend\modules\mat\models\MatReq */
/* @var $form yii\widgets\ActiveForm */
?>


  <div class="box-body">
    <?php $form = ActiveForm::begin([
    'fieldClass'=>'\common\components\MyActiveField',
        'enableAjaxValidation'=>true,
    ]); 
    $bloqueado=false;
   
    ?>
      <div class="box-header">
        <div class="col-md-12">
            <div class="form-group no-margin">
              <div class="btn-group">  
        <?= Html::submitButton('<span class="fa fa-save"></span>   '.Yii::t('app', 'Grabar'), ['class' => 'btn btn-success']) ?>
           <?php 
            
           echo Html::button( '<span class="fa fa-chek"></span>   '.Yii::t('base.names', 'Aprobar'),
                  ['class' => 'btn btn-success','href' => '#','id'=>'btn-aprobar']
                 );
           
        
               ?> 
             </div>     
            </div>
        </div>
    </div>
      
    

  <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'codal')->textInput(['maxlength' => true,'disabled'=>true]) ?>

 </div>
 <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'nomal')->textInput(['maxlength' => true,'disabled'=>true  ]) ?>
     
 </div>
      
  <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
     <?= $form->field($model, 'novalorado')->checkBox([]) ?>
     
 </div>    
   <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
     <?= $form->field($model, 'tolstockres')->checkBox([]) ?>
     
 </div>    
  <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
     <?= $form->field($model, 'agregarauto')->checkBox([]) ?>
     
  </div> 
  <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
     <?= $form->field($model, 'codal')->textInput(['value'=>$model->valor,'maxlength' => true,'disabled'=>true  ]) ?>
     
  </div> 
  <?php  ActiveForm::end(); 
   
   
    ?>
</div>
  
