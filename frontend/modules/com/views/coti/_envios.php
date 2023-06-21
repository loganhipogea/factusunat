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
   if(!$model->isNewRecord){
    $column=[
                    
                'class' => 'yii\grid\ActionColumn',
                //'template' => Helper::filterActionColumn(['view', 'activate', 'delete']),
            'template' => '{push}{view}',
               'buttons' => [  
                                            
                        'push' => function ($url,$model) {                             
                                $url = \yii\helpers\Url::to([$this->context->id.'/ajax-envia-coti','id'=>$model->id]);
                              return \yii\helpers\Html::a('<span class="btn btn-danger fa fa-location-arrow"></span>', '#', ['rel'=>$url,/*'id'=>$model->codparam,*/'family'=>'holas','id'=>\yii\helpers\Json::encode(['id'=>$model->id,'modelito'=> str_replace('@','\\',get_class($model))]),/*'title' => 'Borrar'*/]);
                             },
                         'view' => function ($url,$model) {                             
                                $url = \yii\helpers\Url::to([$this->context->id.'/ajax-show-preview','id'=>$model->id]);
                              return \yii\helpers\Html::a('<span class="btn btn-info fa fa-search"></span>', '#', ['rel'=>$url,/*'id'=>$model->codparam,*/'family'=>'holas2','id'=>\yii\helpers\Json::encode(['id'=>$model->id,'modelito'=> str_replace('@','\\',get_class($model))]),/*'title' => 'Borrar'*/]);
                             },
                         
                    ]
                ];

   }
   $gridColumns=[       
                  
       
        [
            'attribute' => 'numero',
           
         ],  
                      
       [
           
            'attribute' => 'cuando',
           
            
         ],
       [
           
            'attribute' => 'Attach',
           'format'=>'raw',
           'value'=>function($model){
                if($model->hasAttachments()){
                    return Html::a('Descargar',$model->files[0]->url,['data-pjax'=>'0','target'=>'_blank']);
                }
              return '';
           }
           
            
         ],
      $column,
        
   ];
   
 ?>
<div class="box">
<div  class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
<?php
   echo grid::widget([
    'dataProvider'=>New \yii\data\ActiveDataProvider([
        'query'=> frontend\modules\com\models\ComCotienvios::find()
           ->andWhere([
               'version_id'=>$model->coti->version,
               'coti_id'=>$model->coti_id
               ])
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
