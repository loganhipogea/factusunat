<?php

use yii\widgets\ActiveForm;
use kartik\datetime\DateTimePicker;
use common\helpers\timeHelper;
use common\helpers\h;
use common\helpers\ComboHelper;
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
           $operacion=($model->isNewRecord)?'modal-agrega-cambio':'modal-edita-cambio';
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
      
         
     <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
     <?= $form->field($model, 'descripcion')->textInput(['maxlenght'=>true]) ?>
    </div>    
           
     <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
     
            <?= $form->field($model, 'codmotivo')->
            dropDownList($model->dataComboValores('codmotivo')   ,
                        [
                            'prompt'=>'--'.yii::t('base.verbs','Choose a Value')."--",
                            // 'class'=>'probandoSelect2',
                            'disabled'=>($model->aprobado),
                        ]
                    ) ?>

    </div>
     <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">    
 <?= $form->field($model, 'codocuref')->
            dropDownList(ComboHelper::getCboDocuments(),
                  ['prompt'=>'--'.yii::t('base.verbs','Choose a Value')."--",
                    // 'class'=>'probandoSelect2',
                      //'disabled'=>$bloqueado,
                        ]
                    ) ?>
 </div> 
          
  
                  
 <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
     <?= $form->field($model, 'numdocuref')->textInput(['maxlength' => true,  ]) ?>
 
 </div>   
             
     <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
   
      <?=$form->field($model, 'fecha')->widget(DateTimePicker::classname(), 
      [
         'language' => h::app()->language,
                           'pluginOptions'=>[
                                     'format' => h::gsetting('timeUser', 'datetime')  , 
                                   'changeMonth'=>true,
                                  'changeYear'=>true,
                                 'yearRange'=>'2014:'.date('Y'),
                               ],
                          
                            //'dateFormat' => h::getFormatShowDate(),
                            'options'=>['class'=>'form-control',
                               'disabled'=>($model->aprobado),
                                ]
      ]);?>
    </div>     
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
   
      <?=$form->field($model, 'fecha_ingreso_prog')->widget(DateTimePicker::classname(), 
      [
          'language' => h::app()->language,
                           'pluginOptions'=>[
                                     'format' => h::gsetting('timeUser', 'datetime')  , 
                                   'changeMonth'=>true,
                                  'changeYear'=>true,
                                 'yearRange'=>'2014:'.date('Y'),
                               ],
                          
                            //'dateFormat' => h::getFormatShowDate(),
                            'options'=>['class'=>'form-control',
                            'disabled'=>($model->aprobado),
                                ]
      ]);?>
    </div>         
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
     <?= $form->field($model, 'aprobado')->checkbox(['disabled'=>true]) ?>
    </div> 
   
 
   
 
  
 
          
     
    <?php ActiveForm::end(); ?>

</div>


    </div>

 <?php  
     $this->registerJs("$('#turnoscambio-ingreso').on( 'change', function() { 
        if(this.value >0){
            $('#turnoscambio-fecha_ingreso_prog').prop( 'disabled', true );
            $('#turnoscambio-codmotivo').prop( 'disabled', true );
         }else{
             $('#turnoscambio-fecha_ingreso_prog').prop( 'disabled', false );
            $('#turnoscambio-codmotivo').prop( 'disabled',false);

         }
     });

", \yii\web\View::POS_READY);
    ?>  

