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
use frontend\modules\com\models\ComDetcoti;
/* @var $this yii\web\View */
/* @var $model frontend\modules\com\models\ComCotizacion */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="com-cotizacion-form">
    <br>
    <?php 
    $formato=h::formato();
   
          
 
  $column=[
                    
                'class' => 'yii\grid\ActionColumn',
                //'template' => Helper::filterActionColumn(['view', 'activate', 'delete']),
            'template' => '{edit}{delete}',
               'buttons' => [  
                       'edit' => function ($url,$model) {
			    $url= Url::to(['/com/coti/modal-edit-detpadre-by-partida','id'=>$model->id,'gridName'=>Json::encode([]),'idModal'=>'buscarvalor']);
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
         [
          'attribute' => 'descripcion',         
          'contentOptions'=>['style'=>'width: 30%;'],  
         ],
        'tipo',
       
        'codart',
        'codum',
               
        
       [
            'attribute' => 'punit',
            'value'=>function($model)use($formato){
              return $formato->asDecimal($model->punit,2);
            },
           'contentOptions'=>['style'=>'text-align:right; width: 5%; '], 
           
         ],  
        [
            'attribute' => 'cant',
            'value'=>function($model)use($formato){
              return $formato->asDecimal($model->cant,2);
            },
           'contentOptions'=>['style'=>'text-align:right; width: 5%; '], 
         ],  
       
      [
            'attribute' => 'ptotal',
            'value'=>function($model)use($formato){
              return $formato->asDecimal($model->ptotal,2);
            },
            'contentOptions'=>['style'=>'text-align:right; width: 5%; font-weight:900;'],
        ],  
        
   ];
   \yii\widgets\Pjax::begin(['id'=>'grilla-detalle-by-partidas']);
   echo '.'.grid::widget([
    'dataProvider'=>New \yii\data\ActiveDataProvider([
        'query'=> frontend\modules\com\models\ComCotiDet::find()
            ->select('t.*')->alias('t')->
            andWhere([
                'coti_id'=>$model->coti_id,
                'cotigrupo_id'=>$model->id,                
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
      $url= Url::to(['/com/coti/modal-new-detpadre-by-partida','id'=>$model->id,'partida_id'=>$model->id,'gridName'=>Json::encode(['grilla-detalle-by-partidas','pjax-monto-partida']),'idModal'=>'buscarvalor']);
      echo  Html::button('<span class="fa fa-cubes"></span>', ['href' => $url, 'title' => 'Nuevo item de ','id'=>'btn_detpadre','idGrilla'=>Json::encode(['grilla-cecos']),  'class' => 'botonAbre btn btn-success']); 
     
      
  ?>     
          
          
          
          

</div>
    </div>
