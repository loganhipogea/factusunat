<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\Json;
use common\helpers\h;
use kartik\grid\GridView as grid;
use yii\widgets\Pjax;
use common\widgets\linkajaxgridwidget\linkAjaxGridWidget;
?>

<?php

    

   
   $gridColumns=[       
                  
       
       
          'cuando' , 
       [
           
            'attribute' => 'Resultado',
             'format'=>'raw',
             'value'=>function($model){
              return $model->buttonSatus(25);
            
              
             }
             
         ],
       [
           
            'attribute' => 'cuando',
             'value'=>function($model){
             $carboncito= new \Carbon\Carbon();
             $carboncito->setLocale('es');
             $carbonEnvio=$model->toCarbon('cuando')->setLocale('es');
              return $carboncito::now()->diffForHumans($model::SwichtFormatDate ($model->cuando, 'datetime', false));
            
              
             }
             
         ],
      
    
        
   ];
   
 ?>
<div class="box">
<div  class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
<?php

   echo grid::widget([
    'dataProvider'=>New \yii\data\ActiveDataProvider([
        'query'=> frontend\modules\com\models\ComCotienvios::find()
           ->andWhere([
               'version_id'=>$model->id,
               'coti_id'=>$model->coti_id
               ])->orderBy(['cuando'=>SORT_DESC])
            ,
    ]),
   // 'filterModel' => $searchModel,
        'summary' => '',
        'columns' => $gridColumns,
    //'responsive'=>true,
    //'hover'=>true
       ]);
   
  
   
    
   ?> 
 
    
</div>
<div  class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    
</div>
</div>
