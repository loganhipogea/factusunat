<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\Json;
use common\helpers\h;
use kartik\grid\GridView as grid;
use yii\widgets\Pjax;
use common\widgets\linkajaxgridwidget\linkAjaxGridWidget;
use common\widgets\inputajaxwidget\inputAjaxWidget;




   if(!$model->isNewRecord){
  
   }
   $gridColumns=[       
          
        [
            'attribute' => 'item',
            'value'=>function($model){
                return $model->cargo->descripcion;
            }
           
         ],  
                      
       [
            //'class' => 'kartik\grid\EditableColumn',
            'attribute' => 'porcentaje',
           /* 'pageSummary' => 'Total',
            'vAlign' => 'middle',
            'width' => '210px',*/
            
         ],
      'monto',
        
   ];
         
 ?>


<?php
         
   \yii\widgets\Pjax::begin(['id'=>'grilla-cargos']);
   echo grid::widget([
    'dataProvider'=>New \yii\data\ActiveDataProvider([
        'query'=> frontend\modules\com\models\ComCargoscoti::find()
            ->select('t.*')->alias('t')->andWhere(['coti_id'=>$model->id])
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
    
     