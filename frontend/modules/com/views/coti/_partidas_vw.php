<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\Json;
use common\helpers\h;
use kartik\grid\GridView as grid;
use yii\widgets\Pjax;
use common\widgets\linkajaxgridwidget\linkAjaxGridWidget;


 $formato=h::formato();
   if(!$model->isNewRecord){
 
   }
   $gridColumns=[       
          
        [
                'class' => 'kartik\grid\ExpandRowColumn',
                'width' => '50px',
                 'expandIcon'=>'<i style="color:#F86E35"><span class="fa fa-plus-square-o"></span></i>',
                 'collapseIcon'=>'<i style="color:#F60101"><span class="fa fa-minus-square-o"></span></i>',
                
                'value' => function ($model, $key, $index, $column) {
                            return grid::ROW_COLLAPSED;
                                },
                   'detail'=> function($model)  { 
                         
                          $vista= 'ajax_expand_padres_vw';
                       
                          return  $this->render($vista,[
                               'model'=>$model,
                               //'key'=>$key,
                           ]);
                            },
                     //'detailUrl' =>Url::toRoute(['/com/coti/ajax-expand-oferta']),
                    //'headerOptions' => ['class' => 'kartik-sheet-style'], 
                    'expandOneOnly' => true
                ],
       
        [
            'attribute' => 'item',
           
         ],  
                     
       [
            //'class' => 'kartik\grid\EditableColumn',
            'attribute' => 'descripartida',
           /* 'pageSummary' => 'Total',
            'vAlign' => 'middle',
            'width' => '210px',*/
            
         ],
    
        
   ];
        
  $modelCoti=$model;
 foreach($modelCoti->array_cargos() as $cargo=>$porcentaje){
     array_push($gridColumns,['attribute'=>$cargo,'value'=>function($model)use($porcentaje,$formato){return $formato->asDecimal($model->subtotal()*$porcentaje/100);}]);
    }
array_push($gridColumns, [
        'attribute'=>'total' ,
        'value'=>function($model)use($formato){
           return $formato->asDecimal($model->total,3);                     
        },
      'footer'=>$formato->asDecimal($model->monto),
      'contentOptions'=>['style'=>'text-align:right; font-weight:900;'],
     ]);
          
        
   \yii\widgets\Pjax::begin(['id'=>'grilla-partidas']);
   echo grid::widget([
    'dataProvider'=>New \yii\data\ActiveDataProvider([
        'query'=> frontend\modules\com\models\ComCotigrupos::find()
            ->select(['coti_id','id','item','descripartida','total'])->andWhere(['coti_id'=>$model->id])
            ,
    ]),
    'showFooter'=>true,
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

