<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

use frontend\modules\op\helpers\ComboHelper;

 //use kartik\date\DatePicker;
use kartik\datetime\DateTimePicker;
use common\widgets\selectwidget\selectWidget;
use common\helpers\h;

/* @var $this yii\web\View */
/* @var $model frontend\modules\sigi\models\Edificios */
/* @var $form yii\widgets\ActiveForm */
?>
<?php
//var_dump($model->tipo,$model->isServicio(),$model->rules());die();
//print_r($model->rules());
//var_dump($model->isAttributeRequired('servicio_id')); die();
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
           $operacion=($model->isNewRecord)?'modal-agrega-det-req-serv':'modal-edit-det-req-serv';
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
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <?= 
            $form->field($model, 'detos_id')->
            dropDownList(comboHelper::actividadesOs($model->os_id) ,
                    ['prompt'=>'--'.yii::t('base.verbs','Seleccione un valor')."--",
                    // 'class'=>'probandoSelect2',
                      //'disabled'=>($model->isBlockedField('codpuesto'))?'disabled':null,
                        ]
                    )  ?>

        </div>   
         
         
    
 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
     <?php 
  // $necesi=new Parametros;
    echo selectWidget::widget([
           // 'id'=>'mipapa',
            'model'=>$model,
            'form'=>$form,
            'campo'=>'codpro',
         'ordenCampo'=>1,
         'addCampos'=>[2],
        'options'=>['disabled'=>!$model->activo]
        ]);  ?>

 </div> 
 
 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
     <?php 
  // $necesi=new Parametros;
    echo selectWidget::widget([
           // 'id'=>'mipapa',
            'model'=>$model,
            'form'=>$form,
            'campo'=>'servicio_id',
         'ordenCampo'=>2,
         'addCampos'=>[3],
        'options'=>['disabled'=>!$model->activo]
        ]);  ?>

 </div> 
 
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
     <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true,'disabled'=>!$model->activo,]) ?>

 </div>

  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
     <?= $form->field($model, 'texto')->textArea(['maxlength' => true,'disabled'=>!$model->activo,]) ?>
 </div>  
          
     
    <?php ActiveForm::end(); ?>

</div>


    </div>



