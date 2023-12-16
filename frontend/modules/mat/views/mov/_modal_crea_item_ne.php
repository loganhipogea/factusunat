<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use common\widgets\cbodepwidget\cboDepWidget as ComboDep;
use common\helpers\ComboHelper;
use common\widgets\selectwidget\selectWidget;
use common\widgets\inputajaxwidget\inputAjaxWidget;


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
             IF($model->isNewRecord){
               $url=\yii\helpers\Url::to(['/mat/mov/mod-crea-det-ne','id'=>$id]);  
                 //$operacion=($model->isNewRecord)?'mod-agrega-mat':'mod-edit-mat';
             }else{
                $url=\yii\helpers\Url::to(['/mat/mov/mod-edit-det-ne','id'=>$id]);  
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
     <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <?= $form->field($model, 'cant')->textInput(['maxlength' => true]) ?>

    </div>
    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
     <?php  
            $datos=ComboHelper::getCboUms(true);
           echo  $form->field($model, 'codum')->
            dropDownList($datos,
                    [//'prompt'=>'--'.yii::t('base.verbs','Seleccione un valor')."--",
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
            'campo'=>'codart',
         'ordenCampo'=>2,
         'addCampos'=>[2,],
        ]);  ?>

 </div> 
  <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
            <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true]) ?>

    </div>
          
  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <?= $form->field($model, 'rotativo')->checkbox() ?>

    </div>
    
 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
     <?= $form->field($model, 'serie')->textInput(['maxlength' => true]) ?>

 </div>
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
     <?= $form->field($model, 'detalle')->textArea([]) ?>

 </div>
       
          
  
  
      
          
     
    <?php ActiveForm::end(); ?>
          
    <?php 
       
      // var_dump(h::sunat()->gRaw('s.01.tdoc')->data,h::sunat()->gRaw('s.01.tdoc')->g('FAC'));
       echo inputAjaxWidget::widget([
            'isHtml'=>true,//Devuelve datos Html
            'isDivReceptor'=>true,//Es un diov que recibe Html
            'tipo'=>'POST', 
            ///'data'=>['codart'=>$model->id],
            'evento'=>'change',
            'ruta'=>Url::to(['/masters/materials/ajax-html-ums']),
            'id_input'=>'matdetvale-codart',
            'idGrilla'=>'matdetvale-um'
      ])  ?>        
          

</div>
    </div>
 <?php 

 
  ?>


