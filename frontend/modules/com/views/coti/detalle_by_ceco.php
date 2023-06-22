<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\Json;
use yii\widgets\ActiveForm;
use common\helpers\h;
use common\widgets\selectwidget\selectWidget;
use kartik\date\DatePicker;
use kartik\grid\GridView as grid;
use yii\widgets\Pjax;
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
            <div class="button-group"> 
                    <?php $url=Url::to(['/com/coti/update-coti','id'=>$modelCoti->id]);?>
                    <?=Html::a('<span class="fa fa-angle-left" ></span>',$url,['target'=>'_blank','data-pjax'=>'0','class'=>"btn btn-danger"])?>
                    
            </div>
        </div>
    </div>
      <div class="box-body">
   <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($modelCoti, 'numero')->textInput(['maxlength' => true,'disabled'=>true]) ?>

   </div> 
   <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($modelCoti, 'descripcion')->textInput(['maxlength' => true,'disabled'=>true]) ?>

   </div> 
   <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($modelCoti, 'codpro')->textInput(['value'=>$modelCoti->cliente1->despro,'maxlength' => true,'disabled'=>true]) ?>
   </div>
   <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
     <?= $form->field($model, 'id')->textInput(['style'=>'color:#89097d;font-weight:900;','value'=>$model->ceco->descripcion,'maxlength' => true,'disabled'=>true]) ?>
   </div>
   <?php Pjax::begin(['id'=>'pjax-monto-ceco']);   ?>
   <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
     <?= $form->field($model, 'subto')->textInput(['style'=>'color:#89097d;font-weight:900;','maxlength' => true,'disabled'=>true]) ?>
   </div>
    <?php Pjax::end();   ?>
    <?php ActiveForm::end(); ?>
          
  <?php   
  $column=[
                    
                'class' => 'yii\grid\ActionColumn',
                //'template' => Helper::filterActionColumn(['view', 'activate', 'delete']),
            'template' => '{edit}{delete}',
               'buttons' => [  
                       'edit' => function ($url,$model) {
			    $url= Url::to(['/com/coti/modal-edit-detail-by-ceco','id'=>$model->id,'gridName'=>Json::encode(['grilla-detalle-by-cecos','pjax-monto-ceco']),'idModal'=>'buscarvalor']);
                              return \yii\helpers\Html::a('<span class="btn btn-success glyphicon glyphicon-pencil"></span>', $url, ['data-pjax'=>'0','class'=>'botonAbre']);
                            },
                        'delete' => function ($url,$model) {                             
                                $url = \yii\helpers\Url::to([$this->context->id.'/ajax-delete-ceco','id'=>$model->id]);
                              return \yii\helpers\Html::a('<span class="btn btn-danger glyphicon glyphicon-trash"></span>', '#', ['rel'=>$url,/*'id'=>$model->codparam,*/'family'=>'holas','id'=>\yii\helpers\Json::encode(['id'=>$model->id,'modelito'=> str_replace('@','\\',get_class($model))]),/*'title' => 'Borrar'*/]);
                             },
                            
                        
                    ]
                ];
   
   $gridColumns=[       
            $column,
        [
            'attribute' => 'item',
            'value'=>function($model){
              return $model->item;
            }
           
         ],  
        'cant',
        'codart',
        'codum',
                 [
                'class' => 'kartik\grid\ExpandRowColumn',
                'width' => '50px',
                 'expandIcon'=>'<i style="color:#F86E35"><span class="fa fa-plus-square-o"></span></i>',
                 'collapseIcon'=>'<i style="color:#F60101"><span class="fa fa-minus-square-o"></span></i>',
                
                'value' => function ($model, $key, $index, $column) {
                            return grid::ROW_COLLAPSED;
                                },
                 /*'detail'=> function($model)  {  
                          return  $this->render('_expand_sucursal',[
                               'model'=>$model,
                               //'key'=>$key,
                           ]);
                            },*/
                     'detailUrl' =>Url::toRoute(['/com/coti/ajax-expand-oferta']),
                    //'headerOptions' => ['class' => 'kartik-sheet-style'], 
                    'expandOneOnly' => true
                ],
        'punitcalculado',
       [
            'attribute' => 'punit',
            'value'=>function($model){
              return $model->punit;
            }
           
         ],  
       [
            //'class' => 'kartik\grid\EditableColumn',
            'attribute' => 'descripcion',
           /* 'pageSummary' => 'Total',
            'vAlign' => 'middle',
            'width' => '210px',*/
            
         ],
      [
            'attribute' => 'ptotal',
            'value'=>function($model){
              return $model->ptotal;
            }
           
         ],  
        
   ];
   \yii\widgets\Pjax::begin(['id'=>'grilla-detalle-by-cecos']);
   echo '.'.grid::widget([
    'dataProvider'=>New \yii\data\ActiveDataProvider([
        'query'=> frontend\modules\com\models\ComDetcoti::find()
            ->select('t.*')->alias('t')->
            andWhere([
                'coti_id'=>$model->coti_id,
                'coticeco_id'=>$model->id,
                    ])
            ,
    ]),
   // 'filterModel' => $searchModel,
        'summary' => '',
        'columns' => $gridColumns,
    //'responsive'=>true,
    //'hover'=>true
       ]);
    \yii\widgets\Pjax::end();
   ?> 
 <div class="btn-group">

<?php
      $url= Url::to(['/com/coti/modal-new-detail-by-ceco','id'=>$modelCoti->id,'cecoid'=>$model->id,'gridName'=>Json::encode(['grilla-detalle-by-cecos','pjax-monto-ceco']),'idModal'=>'buscarvalor']);
      echo  Html::button('<span class="fa fa-plus"></span>'.yii::t('base.verbs','Add Detail'), ['href' => $url, 'title' => 'Nuevo item de ','id'=>'btn_contacts','idGrilla'=>Json::encode(['grilla-cecos']),  'class' => 'botonAbre btn btn-success']); 
 ?>     
          
          
          
          

</div>
    </div>
