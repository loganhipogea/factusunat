<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\helpers\h;
use frontend\modules\mat\helpers\ComboHelper;
   use common\widgets\selectwidget\selectWidget;
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
            <div class="btn-group">
            <?php
          $operacion=($model->isNewRecord)?'modal-crea-material-almacen':'modal-edita-material-almacen';             
          $cadena=($model->isNewRecord)?'codal':'id';
          $url=\yii\helpers\Url::to(['/masters/centros/'.$operacion,$cadena=>$id]); 
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
    </div>
     
  
      <div class="box-body">
   <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
     <?php 
  // $necesi=new Parametros;
    echo selectWidget::widget([
           // 'id'=>'mipapa',
            'model'=>$model,
            'form'=>$form,
            'campo'=>'codart',
         'ordenCampo'=>2,
         'addCampos'=>[2,],
        //'options'=>['disabled'=>!$model->activo]
        ]);  ?>

 </div>    
  <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">    
        <?= $form->field($model, 'codal')->textInput(['value'=>$model->almacen->nomal,'disabled'=>true]) ?>
   </div> 
     
  
   <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">    
        <?= $form->field($model, 'ceconomica')->textInput([]) ?>
   </div> 
  <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">    
        <?= $form->field($model, 'creorden')->textInput([]) ?>
   </div> 
   <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">    
        <?= $form->field($model, 'crepo')->textInput([]) ?>
   </div>       
  <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">    
        <?= $form->field($model, 'leadtime')->textInput([]) ?>
   </div> 
     
    <?php ActiveForm::end(); ?>
     

</div>
    </div>
</div>
