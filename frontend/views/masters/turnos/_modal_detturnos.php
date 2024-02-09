<?php

use yii\widgets\ActiveForm;
use kartik\time\TimePicker;
use common\helpers\timeHelper;

 //use kartik\date\DatePicker;



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
           $operacion=($model->isNewRecord)?'modal-agrega-trabajador':'modal-edita-det-turno';
             IF($model->isNewRecord){
               $url=\yii\helpers\Url::to(['/masters/turnos/'.$operacion,'id'=>$id]);  
                 
             }else{
                $url=\yii\helpers\Url::to(['/masters/turnos/'.$operacion,'id'=>$id]);  
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
         
           
     <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
   
    <?= $form->field($model, 'turno_id')->textInput(['value'=>timeHelper::daysOfWeek()[$model->dia],'disabled'=>true]) ?>
    </div>
         
     <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
   
      <?=$form->field($model, 'hi')->widget(TimePicker::classname(), 
      [
         'pluginOptions' =>['showMeridian'=>false],
      ]);?>
    </div>     
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
   
      <?=$form->field($model, 'hf')->widget(TimePicker::classname(), 
      [
         'pluginOptions' =>['showMeridian'=>false],
      ]);?>
    </div>         
   <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
     <?= $form->field($model, 'activo')->checkbox([]) ?>

 </div> 
   
 
 
 
  
 
          
     
    <?php ActiveForm::end(); ?>

</div>


    </div>



