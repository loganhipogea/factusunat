<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use common\helpers\h;
use frontend\modules\mat\helpers\comboHelper;

 //use kartik\date\DatePicker;
use kartik\datetime\DateTimePicker;
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
           $operacion=($model->isNewRecord)?'mod-agrega-det-os':'mod-edit-osdet';
             IF($model->isNewRecord){
               $url=\yii\helpers\Url::to(['/op/proc/'.$operacion,'id'=>$id]);  
                 
             }else{
                $url=\yii\helpers\Url::to(['/op/proc/'.$operacion,'id'=>$id]);  
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
     
     <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                <?= 
                   //$model->activo=false;
            $form->field($model, 'tipo')->
            dropDownList($model->dataComboValores('tipo'),
                    ['prompt'=>'--'.yii::t('base.verbs','Seleccione un valor')."--",
                    // 'class'=>'probandoSelect2',
                      //'disabled'=>($model->isBlockedField('codpuesto'))?'disabled':null,
                        ]
                    )  ?>

        </div>   
          
 <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
      <?= $form->field($model, 'finicio')->widget(DateTimePicker::class, [
                            'language' => h::app()->language,
                           'pluginOptions'=>[
                                     'format' => h::gsetting('timeUser', 'datetime')  , 
                                   'changeMonth'=>true,
                                  'changeYear'=>true,
                                 'yearRange'=>'2014:'.date('Y'),
                               ],
                          
                            //'dateFormat' => h::getFormatShowDate(),
                            'options'=>['class'=>'form-control',
                               //'disabled'=>(!$aprobado)?false:true  
                                ]
                            ]) ?>
 </div>
   <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
      <?= $form->field($model, 'termino')->widget(DateTimePicker::class, [
                            'language' => h::app()->language,
                           'pluginOptions'=>[
                                    'format' => h::gsetting('timeUser', 'datetime')  , 
                                   'changeMonth'=>true,
                                  'changeYear'=>true,
                                 'yearRange'=>'2014:'.date('Y'),
                               ],
                          
                            //'dateFormat' => h::getFormatShowDate(),
                            'options'=>['class'=>'form-control',
                               //'disabled'=>(!$aprobado)?false:true  
                                ]
                            ]) ?>
 </div>         

 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
     <?php 
  // $necesi=new Parametros;
    echo selectWidget::widget([
           // 'id'=>'mipapa',
            'model'=>$model,
            'form'=>$form,
            'campo'=>'codtra',
         'ordenCampo'=>1,
         'addCampos'=>[2,3],
        'options'=>[
            //'disabled'=>!$model->activo
            ]
        ]);  ?>

 </div> 
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
     <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true,
         //'disabled'=>!$model->activo,
         ]) ?>

 </div>
       
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
     <?PHP
     echo $form->field($model, 'detalle')
             ->widget(\dosamigos\ckeditor\CKEditor::className(), [
        'options' => ['rows' => 2],
         'clientOptions'=>['language'=>'es',
             ],
        ]);
      ?>

 </div>       
  
  
      
          
     
    <?php ActiveForm::end(); ?>

</div>
    </div>



