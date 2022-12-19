<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\Json;
use common\helpers\h;
use yii\grid\GridView as grid;
use yii\widgets\Pjax;
use common\widgets\linkajaxgridwidget\linkAjaxGridWidget;
   if(!$model->isNewRecord){
  $column=[
                    
                'class' => 'yii\grid\ActionColumn',
                //'template' => Helper::filterActionColumn(['view', 'activate', 'delete']),
            'template' => '{edit}{delete}{expand}',
               'buttons' => [  
                       'edit' => function ($url,$model) {
			    $url= Url::to(['/com/coti/modal-edit-grupo-ceco','id'=>$model->id,'gridName'=>Json::encode(['grilla-partidas']),'idModal'=>'buscarvalor']);
                              return \yii\helpers\Html::a('<span class="btn btn-success glyphicon glyphicon-pencil"></span>', $url, ['data-pjax'=>'0','class'=>'botonAbre']);
                            },
                        'delete' => function ($url,$model) {                             
                                $url = \yii\helpers\Url::to([$this->context->id.'/ajax-delete-ceco','id'=>$model->id]);
                              return \yii\helpers\Html::a('<span class="btn btn-danger glyphicon glyphicon-trash"></span>', '#', ['rel'=>$url,/*'id'=>$model->codparam,*/'family'=>'holas','id'=>\yii\helpers\Json::encode(['id'=>$model->id,'modelito'=> str_replace('@','\\',get_class($model))]),/*'title' => 'Borrar'*/]);
                             },
                         'expand' => function ($url,$model) {                             
                                $url = \yii\helpers\Url::to([$this->context->id.'/detail-mat-by-ceco','id'=>$model->coti_id,'cecoid'=>$model->id]);
                              return \yii\helpers\Html::a('<span class="btn btn-success glyphicon glyphicon-th-list"></span>', $url, ['data-pjax'=>'0']);
                          
                             }     
                        
                    ]
                ];
   }
   $gridColumns=[       
            $column,
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

<?php
      $url= Url::to(['/com/coti/modal-new-grupo-ceco','id'=>$model->id,'gridName'=>Json::encode(['grilla-cecos']),'idModal'=>'buscarvalor']);
      echo  Html::button('<span class="fa fa-plus"></span>'.yii::t('base.verbs','Agregar colector'), ['href' => $url, 'title' => 'Nuevo item de '.$model->numero,'id'=>'btn_contacts','idGrilla'=>Json::encode(['grilla-cecos']),  'class' => 'botonAbre btn btn-success']); 
 ?>
 </div>

