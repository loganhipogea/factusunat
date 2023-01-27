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
            'attribute' => 'coti_id',
            'value'=>function($model){
                return $model->contacto->nombres;
            }
           
         ],  
                      
       [
            'attribute' => 'contacto_id',
            'value'=>function($model){
                return $model->contacto->cargo;
            }
           
         ],  
                 
       [
            'attribute' => 'codpro',
            'value'=>function($model){
                return $model->contacto->mail;
            }
           
         ],  
                 [
            'attribute' => 'codpro',
            'value'=>function($model){
                return $model->contacto->moviles;
            }
           
         ],  
        
   ];
         ?>
    
     
  <?php       
         
         
         
   \yii\widgets\Pjax::begin(['id'=>'grilla-contactos']);
   
   
   
   echo grid::widget([
    'dataProvider'=>New \yii\data\ActiveDataProvider([
        'query'=> frontend\modules\com\models\ComContactocoti::find()
            ->select(['id','coti_id','contacto_id','prioridad','send','codpro'])->andWhere(['coti_id'=>$model->id])
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

