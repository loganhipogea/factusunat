<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\helpers\h;
use common\widgets\selectwidget\selectWidget;
use kartik\date\DatePicker;
use common\widgets\inputajaxwidget\inputAjaxWidget;
/* @var $this yii\web\View */
/* @var $model frontend\modules\com\models\ComCotizacion */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="com-cotizacion-form">
    <br>
    <?php $form = ActiveForm::begin([
    'fieldClass'=>'\common\components\MyActiveField'
    ]); ?>
      <div class="box-header">
        <div class="col-md-12">
            <div class="form-group no-margin">
           
            </div>
        </div>
    </div>
      <div class="box-body">
          
 <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
      <?= $form->field($model, 'serie')->
            dropDownList($model::dataComboValores('serie') ,
                    ['prompt'=>'--'.yii::t('base.verbs','Choose a Value')."--",
                    // 'class'=>'probandoSelect2',
                        
              'disabled'=>true
                        ]
                    ) ?>
 </div>   
 
  <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'numero')->textInput(['maxlength' => true,'disabled'=>true]) ?>

 </div>
<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
    <?= $form->field($model, 'codmon')->
            dropDownList(\common\helpers\ComboHelper::getCboMonedas() ,
                    ['prompt'=>'--'.yii::t('base.verbs','Choose a Value')."--",
                       'disabled'=>true 
                        ]
                    ) ?>

 </div>
  
  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <?= $form->field($model, 'codcli')->textInput(['value'=>$model->cliente1->despro,'maxlength' => true,'disabled'=>true]) ?>

  </div>
  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <?= $form->field($model, 'codcli1')->textInput(['value'=>$model->cliente2->despro,'maxlength' => true,'disabled'=>true]) ?>


 </div>
  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
     <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true,'disabled'=>true]) ?>

 </div>        
  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
      <?= $form->field($model, 'codtra')->textInput(['value'=>$model->trabajador->fullName(),'maxlength' => true,'disabled'=>true]) ?>

 </div>         
   <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
      <?= $form->field($model, 'femision')->widget(DatePicker::class, [
                            'language' => h::app()->language,
                           'pluginOptions'=>[
                                     'format' => h::gsetting('timeUser', 'date')  , 
                                   'changeMonth'=>true,
                                  'changeYear'=>true,
                                 'yearRange'=>'2014:'.date('Y'),
                               ],
                          
                            //'dateFormat' => h::getFormatShowDate(),
                            'options'=>['class'=>'form-control',
                               'disabled'=>true  
                                ]
                            ]) ?>

 </div>
  <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'validez')->textInput(['disabled'=>true]) ?>

 </div>
  <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
   <?= $form->field($model, 'version')->textInput(['disabled'=>true]) ?>

   </div> 
 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <?PHP
     echo $form->field($model, 'detalle_interno')
             ->widget(\dosamigos\ckeditor\CKEditor::className(), [
        'options' => ['rows' => 2,'disabled'=>true],
         'clientOptions'=>['language'=>'es',
             ],
        ]);
      ?>
 </div>

  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <?PHP
     echo $form->field($model, 'detalle_externo')
             ->widget(\dosamigos\ckeditor\CKEditor::className(), [
        'options' => ['rows' => 2,'disabled'=>true],
         'clientOptions'=>['language'=>'es',
             ],
        ]);
      ?>
 </div>
    <?PHP  
    
    
    ?>
  
     
    <?php ActiveForm::end(); ?>

</div>
    </div>
