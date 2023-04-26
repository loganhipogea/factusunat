<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;
use common\widgets\linkajaxgridwidget\linkAjaxGridWidget;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model common\models\masters\Transacciones */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="transacciones-form">
    <br>
    <?php $form = ActiveForm::begin([
    'id'=>'kio',
    'enableAjaxValidation'=>true,
    'fieldClass'=>'\common\components\MyActiveField'
    ]); ?>
      <div class="box-header">
        <div class="col-md-12">
            <div class="form-group no-margin">
                
        <?= Html::submitButton('<span class="fa fa-save"></span>   '.Yii::t('base.names', 'Save'), ['class' => 'btn btn-success']) ?>
            

            </div>
        </div>
    </div>
      <div class="box-body">
    
 <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'codtrans')->textInput(['maxlength' => true]) ?>

 </div>
  <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true]) ?>

 </div>
   <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">    
 <?= $form->field($model, 'signo')->
            dropDownList([1=>'1',-1=>'-1',0=>'0'],
                  ['prompt'=>'--'.yii::t('base.verbs','Choose a Value')."--",
                    // 'class'=>'probandoSelect2',
                      //'disabled'=>($model->isBlockedField('codpuesto'))?'disabled':null,
                        ]
                    ) ?>
 </div>  
   <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
     <?= $form->field($model, 'exigirvalidacion')->checkbox() ?>

 </div>
 <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
     <?= $form->field($model, 'afecta_reserva')->checkbox() ?>

 </div>
 <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
     <?= $form->field($model, 'afecta_precio')->checkbox() ?>

 </div>
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
     <?= $form->field($model, 'detalles')->textarea(['rows' => 6]) ?>

 </div>
     
    <?php ActiveForm::end(); ?>
   <?php \yii\widgets\Pjax::begin(['id'=>'grilla-documentos']);   ?>
   <?= GridView::widget([
        'dataProvider' =>new yii\data\ActiveDataProvider([
            'query'=> common\models\masters\Transadocs::find()->andWhere(
                    [
                        'codtrans'=>$model->codtrans,
                    ]),
        ]),
         //'summary' => '',
         'tableOptions'=>['class'=>'table table-condensed table-hover table-bordered table-striped'],
        'columns' => [
                 [
                'class' => 'yii\grid\ActionColumn',
                //'template' => Helper::filterActionColumn(['view', 'activate', 'delete']),
            'template' => '{edit}{delete}',
               'buttons' => [
                    
                                
                   'edit' => function ($url,$model)   {
			    $url= Url::to([$this->context->id.'/modal-edita-documento','id'=>$model->id,'gridName'=>'grilla-documentos','idModal'=>'buscarvalor']);
                              
                            return \yii\helpers\Html::a('<span class="btn btn-success glyphicon glyphicon-pencil"></span>', $url, ['data-pjax'=>'0','class'=>'botonAbre']);
                            },
                   'delete' => function ($url,$model) {                             
                                $url = \yii\helpers\Url::to([$this->context->id.'/deletemodel-for-ajax','id'=>$model->id]);
                              return \yii\helpers\Html::a('<span class="btn btn-danger glyphicon glyphicon-trash"></span>', '#', ['rel'=>$url,/*'id'=>$model->codparam,*/'family'=>'holas','id'=>\yii\helpers\Json::encode(['id'=>$model->id,'modelito'=> str_replace('@','\\',get_class($model))]),/*'title' => 'Borrar'*/]);
                             }
                        
                    ]
                ],
            'codocu',
             'docu.modelo',
              'docu.desdocu',
               
        ],
    ]); ?>
  <?php 
   echo linkAjaxGridWidget::widget([
           'id'=>'widgetgruidBancos',
            'idGrilla'=>'grilla-documentos',
            'family'=>'holas',
          'type'=>'POST',
           'evento'=>'click',
       'posicion'=>\yii\web\View::POS_END
            //'foreignskeys'=>[1,2,3],
        ]); 
   ?>
 <?php \yii\widgets\Pjax::end();   ?>
 <?php
 $url= Url::to(['masters/transa/modal-agrega-documento','codtrans'=>$model->codtrans,'gridName'=>'grilla-documentos','idModal'=>'buscarvalor']);

   echo  Html::button(yii::t('base.verbs','Agregar documento'), ['href' => $url, 'title' => yii::t('base.names','Agregar documento'),'id'=>'btn_cuentas_edi', 'class' => 'botonAbre btn btn-success']); 
       ?> 
</div>
    </div>
