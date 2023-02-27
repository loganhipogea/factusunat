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
  $column=[
                    
                'class' => 'yii\grid\ActionColumn',
                //'template' => Helper::filterActionColumn(['view', 'activate', 'delete']),
            'template' => '{edit}{delete}{expand}',
               'buttons' => [  
                       'edit' => function ($url,$model) {
			    $url= Url::to(['/com/coti/modal-edit-grupo-coti','id'=>$model->id,'gridName'=>Json::encode(['grilla-partidas']),'idModal'=>'buscarvalor']);
                              return \yii\helpers\Html::a('<span class="btn btn-success glyphicon glyphicon-pencil"></span>', $url, ['data-pjax'=>'0','class'=>'botonAbre']);
                            },                       
                        'delete' => function ($url,$model) {                             
                                $url = \yii\helpers\Url::to([$this->context->id.'/ajax-delete-partida','id'=>$model->id]);
                              return \yii\helpers\Html::a('<span class="btn btn-danger glyphicon glyphicon-trash"></span>', '#', ['rel'=>$url,/*'id'=>$model->codparam,*/'family'=>'holas','id'=>\yii\helpers\Json::encode(['id'=>$model->id,'modelito'=> str_replace('@','\\',get_class($model))]),/*'title' => 'Borrar'*/]);
                             },
                       'expand' => function ($url,$model) {                             
                                $url = \yii\helpers\Url::to([$this->context->id.'/detail-mat-by-partida','id'=>$model->coti_id,'partida_id'=>$model->id]);
                              return \yii\helpers\Html::a('<span class="btn btn-success glyphicon glyphicon-th-list"></span>', $url, ['data-pjax'=>'0']);
                          
                             }     
                    ]
                ];
   }
   $gridColumns=[       
            $column,
        [
                'class' => 'kartik\grid\ExpandRowColumn',
                'width' => '50px',
                'value' => function ($model, $key, $index, $column) {
                            return grid::ROW_COLLAPSED;
                                },
                   'detail'=> function($model)  { 
                         
                          $vista= 'ajax_expand_padres';
                       
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
      ?>    
 <div class="box-header">  
<?php      
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
   
  
    echo linkAjaxGridWidget::widget([
           'id'=>'widgetgruidBancos',
        //'otherContainers'=>['grilla-partidas'],
            'idGrilla'=>'grilla-partidas',
            'family'=>'holas',
          'type'=>'POST',
           'evento'=>'click',
        'posicion'=>\yii\web\View::POS_END
       
            //'foreignskeys'=>[1,2,3],
        ]);
       
   
   
   
    \yii\widgets\Pjax::end();
   ?> 
 <div class="btn-group">
<?php
      $url= Url::to(['/com/coti/modal-new-grupo-coti','id'=>$model->id,'gridName'=>Json::encode(['grilla-partidas']),'idModal'=>'buscarvalor']);
      echo  Html::button('<span class="fa fa-plus"></span>'.yii::t('base.verbs','Agregar partida'), ['href' => $url, 'title' => 'Nuevo item de '.$model->numero,'id'=>'btn_contacts','idGrilla'=>Json::encode(['grilla-partidas']),  'class' => 'botonAbre btn btn-success']); 
 ?>
 </div>

 </div> 