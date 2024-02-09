<?php

use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use common\helpers\ComboHelper;
use common\helpers\h;
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
           $operacion=($model->isNewRecord)?'modal-asigna-trabajador':'modal-edita-trabajador';
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
   
      <?=$form->field($model, 'descripcion')->textInput(['maxlenght'=>true]);?>
    </div>       
           
    
     <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
      <?= $form->field($model, 'fecha')->widget(DatePicker::class, [
                            'language' => h::app()->language,
                           'pluginOptions'=>[
                                     'format' => h::gsetting('timeUser', 'date')  , 
                                   'changeMonth'=>true,
                                  'changeYear'=>true,
                                 'yearRange'=>'2014:'.date('Y'),
                               ],
                          
                            //'dateFormat' => h::getFormatShowDate(),
                            'options'=>['class'=>'form-control',
                            //   'disabled'=>(!$aprobado)?false:true  
                                ]
                            ]) ?>

 </div>    
      
   <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">     
          <?= 
                   //$model->activo=false;
            $form->field($model, 'trabajcuadrilla_id')->
            dropDownList(ComboHelper::getCboVwCuadrillas(),
                    ['prompt'=>'--'.yii::t('base.verbs','Seleccione un valor')."--",
                    // 'class'=>'probandoSelect2',
                      //'disabled'=>($model->isBlockedField('codpuesto'))?'disabled':null,
                        ]
                    )  ?>
   </div>           
   
  
 
          
     
    <?php ActiveForm::end(); ?>

</div>


    </div>



