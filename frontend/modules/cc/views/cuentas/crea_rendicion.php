<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\helpers\h;
use frontend\modules\cc\helpers\comboHelper as ComboHelper;
use common\widgets\selectwidget\selectWidget;
use common\widgets\cbodepwidget\cboDepWidget as ComboDep;
 use kartik\date\DatePicker;
 use common\widgets\inputajaxwidget\inputAjaxWidget;
/* @var $this yii\web\View */
/* @var $model frontend\modules\cc\models\CcCuentas */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cc-cuentas-form">
     <div class="box-body">
      <?php $form = ActiveForm::begin([
       'id'=>'myformulario',
    'fieldClass'=>'\common\components\MyActiveField',
          'enableAjaxValidation'=>true
    ]); ?>
      <div class="box-header">          
        <div class="col-md-12">
            <div class="form-group ">
            <div class="btn-group">
          <?= Html::submitButton('<span class="fa fa-save"></span>   '.Yii::t('app', 'Guardar'), ['class' => 'btn btn-success']) ?>
          
              </div>       
            </div>
        </div>
    </div>
     
  
  <div class="box-body">
      <div class="col-lg-6 col-md-4 col-sm-12 col-xs-12">    
        <?= $form->field($model, 'parent_id')->
            dropDownList(ComboHelper::getCboRendiciones(),
                  ['prompt'=>'--'.yii::t('base.verbs','Escoja un valor')."--",
                    // 'class'=>'probandoSelect2',
                      //'disabled'=>($model->isBlockedField('codpuesto'))?'disabled':null,
                        ]
                    ) ?>
   </div>    
   <div class="col-lg-6 col-md-4 col-sm-12 col-xs-12">    
        <?= $form->field($model, 'codocu')->
            dropDownList(ComboHelper::getCboDocuments(),
                  ['prompt'=>'--'.yii::t('base.verbs','Escoja un valor')."--",
                    // 'class'=>'probandoSelect2',
                      //'disabled'=>($model->isBlockedField('codpuesto'))?'disabled':null,
                        ]
                    ) ?>
 </div>    
 <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">    
        <?= $form->field($model, 'serie')->textInput() ?>
 </div> 
  <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">    
        <?= $form->field($model, 'numero')->textInput() ?>
 </div>
 <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
      <?= $form->field($model, 'fecha')->widget(DatePicker::class, [
                            'language' => h::app()->language,
                           'pluginOptions'=>[
                                     'format' => h::gsetting('timeUser', 'date')  , 
                                   'changeMonth'=>true,
                                  'changeYear'=>true,
                                 'yearRange'=>'2014:'.date('Y'),
                               ],
                          
                            //'dateFormat' => h::getFormatShowDate(),
                            'options'=>['class'=>'form-control']
                            ]) ?>
 </div>
   <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">    
        <?= $form->field($model, 'glosa')->textInput() ?>
 </div>        
    <div class="col-lg-6 col-md-4 col-sm-12 col-xs-12">    
        <?= $form->field($model, 'codmon')->
            dropDownList(ComboHelper::getCboMonedas(),
                  ['prompt'=>'--'.yii::t('base.verbs','Escoja un valor')."--",
                    // 'class'=>'probandoSelect2',
                      //'disabled'=>($model->isBlockedField('codpuesto'))?'disabled':null,
                        ]
                    ) ?>
   </div>   
    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">    
        <?= $form->field($model, 'rucpro')->textInput() ?>
   </div> 
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
                        <div id="234_descri_proveedor" class="alert alert-info">
                            <?= $model->despro()  ?>
                        </div>
                    </div> 
   <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">    
        <?= $form->field($model, 'monto')->textInput() ?>
   </div>  
            
     
    <?php ActiveForm::end(); ?>
     <?php echo inputAjaxWidget::widget([
            'isHtml'=>true,
            'tipo'=>'POST',
            'ruta'=>Url::to(['/masters/clipro/crea-from-api']),
            'id_input'=>'cccompras-rucpro',
            'idGrilla'=>'234_descri_proveedor'
      ])  ?>

</div>
    </div>
</div>
