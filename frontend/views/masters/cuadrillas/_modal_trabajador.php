<?php

use yii\widgets\ActiveForm;



 //use kartik\date\DatePicker;

use common\widgets\selectwidget\selectWidget;


/* @var $this yii\web\View */
/* @var $model frontend\modules\sigi\models\Edificios */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="edificios-form">
    <br>
    <?php $form = ActiveForm::begin([
        'id'=>'myformulario',
    'fieldClass'=>'\common\components\MyActiveField'
    ]); ?>
      <div class="box-header">
        <div class="col-md-12">
            <div class="form-group no-margin">
           <?PHP 
           $operacion=($model->isNewRecord)?'modal-agrega-trabajador':'modal-edita-trabajador';
             IF($model->isNewRecord){
               $url=\yii\helpers\Url::to(['/masters/cuadrillas/'.$operacion,'id'=>$id]);  
                 
             }else{
                $url=\yii\helpers\Url::to(['/masters/cuadrillas/'.$operacion,'id'=>$id]);  
             }
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
          <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
             <?php 
  // $necesi=new Parametros;
    echo selectWidget::widget([
           // 'id'=>'mipapa',
            'model'=>$model,
            'form'=>$form,
            'campo'=>'codtra_id',
         'ordenCampo'=>1,
         'addCampos'=>[2,3,4],
        ]);  ?>
            </div>
           
     
         
         
         
    
   
 
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
     <?= $form->field($model, 'textodetalle')->textArea([]) ?>

 </div>
 
          
     
    <?php ActiveForm::end(); ?>

</div>


    </div>



