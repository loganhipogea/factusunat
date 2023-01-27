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
use common\widgets\linkajaxgridwidget\linkAjaxGridWidget;
/* @var $this yii\web\View */
/* @var $model frontend\modules\com\models\ComCotizacion */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="com-cotizacion-form">
    <br>
    <?php 
    $formato=h::formato();
    $zona_refresh='grilla-detalle-by-partidas'.$model->id;
          
 
  
   
   $gridColumns=[       
            
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
   \yii\widgets\Pjax::begin(['id'=>$zona_refresh]);
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



</div>
    </div>
