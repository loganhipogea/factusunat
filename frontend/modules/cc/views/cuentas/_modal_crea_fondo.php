<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\helpers\h;
    use common\helpers\ComboHelper;
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
   // 'fieldClass'=>'\common\components\MyActiveField'
    ]); ?>
      <div class="box-header">
          
        <div class="col-md-12">
            <div class="form-group no-margin">
            <?php
          $operacion=($model->isNewRecord)?'mod-crea-fondo':'mod-edita-fondo';
             IF($model->isNewRecord){
               $url=\yii\helpers\Url::to(['/cc/cuentas/'.$operacion,'id'=>$id]);  
                 
             }else{
                $url=\yii\helpers\Url::to(['/cc/cuentas/'.$operacion,'id'=>$id]);  
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
      
   <div class="col-lg-6 col-md-4 col-sm-12 col-xs-12">    
        <?= $form->field($model, 'prefijo')->
            dropDownList($model->FondosFijos(),
                  ['prompt'=>'--'.yii::t('base.verbs','Escoja un valor')."--",
                    // 'class'=>'probandoSelect2',
                      //'disabled'=>($model->isBlockedField('codpuesto'))?'disabled':null,
                        ]
                    )->label('Fondo') ?>
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
     
    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">    
        <?= $form->field($model, 'monto')->textInput() ?>
   </div> 
    
   <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">    
        <?php 
  // $necesi=new Parametros;
    echo selectWidget::widget([
           // 'id'=>'mipapa',
            'model'=>$model,
            'form'=>$form,
            'campo'=>'codtra',
         'ordenCampo'=>1,
         'addCampos'=>[2,3],
        ]);  ?>
   </div>  
            
     
    <?php ActiveForm::end(); ?>
     

</div>
    </div>
</div>
