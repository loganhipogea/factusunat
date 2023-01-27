<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\Json;
use common\helpers\h;
use yii\grid\GridView as grid;
use yii\widgets\Pjax;
use common\widgets\linkajaxgridwidget\linkAjaxGridWidget;
   if(!$model->isNewRecord){
 
   }
   $gridColumns=[       
         
        [
            'attribute' => 'item',
            'value'=>function($model){
              return $model->ceco->descripcion;
            }
           
         ],  
                      
       [
            //'class' => 'kartik\grid\EditableColumn',
            'attribute' => 'descricecoti',
           /* 'pageSummary' => 'Total',
            'vAlign' => 'middle',
            'width' => '210px',*/
            
         ],
      'subto',
        
   ];
   \yii\widgets\Pjax::begin(['id'=>'grilla-cecos']);
   echo grid::widget([
    'dataProvider'=>New \yii\data\ActiveDataProvider([
        'query'=> frontend\modules\com\models\ComCoticeco::find()
            ->select(['id','coti_id','ceco_id','tipo','descricecoti','subto'])->andWhere(['coti_id'=>$model->id])
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

