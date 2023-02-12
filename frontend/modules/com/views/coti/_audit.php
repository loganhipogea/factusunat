<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\Json;
use common\helpers\h;
use kartik\grid\GridView as grid;
use yii\widgets\Pjax;
use common\widgets\linkajaxgridwidget\linkAjaxGridWidget;

   if(!$model->isNewRecord){
  
   }
   $mapModels=$model->mapModels();
   //print_r($mapModels);die();
   $gridColumns=[       
           
        [
            'attribute' => 'action',
            'value'=>function($model)use($mapModels){
                return $model->action;
            }
         ],  
       
        [
            'attribute' => 'model',
            'value'=>function($model)use($mapModels){
                $nameModels=explode('\\',$model->model);
                //return trim($nameModels[count( $nameModels)-1]);
                return $mapModels[trim($nameModels[count( $nameModels)-1])];
            }
         ],  
                      
       [
            //'class' => 'kartik\grid\EditableColumn',
            'attribute' => 'creationdate',
           /* 'pageSummary' => 'Total',
            'vAlign' => 'middle',
            'width' => '210px',*/
            
         ],
                    
       [
            //'class' => 'kartik\grid\EditableColumn',
            'attribute' => 'ip',
           /* 'pageSummary' => 'Total',
            'vAlign' => 'middle',
            'width' => '210px',*/
            
         ],
       [
            //'class' => 'kartik\grid\EditableColumn',
            'attribute' => 'nombrecampo',
           
        ],
          [
            //'class' => 'kartik\grid\EditableColumn',
            'header'=>'Anterior',
            'attribute' => 'oldvalue',
             'value'=>function($model){
                return $model->oldvalue;
             }
           
        ],[
            //'class' => 'kartik\grid\EditableColumn',
            'header'=>'Nuevo',
            'attribute' => 'newvalue',
             'value'=>function($model){
                return $model->newvalue;
             }
           
        ],
        [
            //'class' => 'kartik\grid\EditableColumn',
            'attribute' => 'username',
           /* 'pageSummary' => 'Total',
            'vAlign' => 'middle',
            'width' => '210px',*/
            
         ],
        
   ];
   \yii\widgets\Pjax::begin(['id'=>'grilla-audit']);
   echo grid::widget([
    'dataProvider'=>$model->providerLog(),
       
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

