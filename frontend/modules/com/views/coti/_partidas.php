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
            'template' => '{edit}{delete}',
               'buttons' => [  
                       'edit' => function ($url,$model) {
			    $url= Url::to(['/com/coti/modal-edit-grupo-coti','id'=>$model->id,'gridName'=>Json::encode(['grilla-partidas']),'idModal'=>'buscarvalor']);
                              return \yii\helpers\Html::a('<span class="btn btn-success glyphicon glyphicon-pencil"></span>', $url, ['data-pjax'=>'0','class'=>'botonAbre']);
                            },
                        'delete' => function ($url,$model) {                             
                                $url = \yii\helpers\Url::to([$this->context->id.'/ajax-delete-invoice-item','id'=>$model->id]);
                              return \yii\helpers\Html::a('<span class="btn btn-danger glyphicon glyphicon-trash"></span>', '#', ['rel'=>$url,/*'id'=>$model->codparam,*/'family'=>'holas','id'=>\yii\helpers\Json::encode(['id'=>$model->id,'modelito'=> str_replace('@','\\',get_class($model))]),/*'title' => 'Borrar'*/]);
                             }
                        
                    ]
                ];
   }
   $gridColumns=[       
            $column,
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
      'total',
        
   ];
   \yii\widgets\Pjax::begin(['id'=>'grilla-partidas']);
   echo grid::widget([
    'dataProvider'=>New \yii\data\ActiveDataProvider([
        'query'=> frontend\modules\com\models\ComCotigrupos::find()
            ->select(['id','item','descripartida','total'])->andWhere(['coti_id'=>$model->id])
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
      $url= Url::to(['/com/coti/modal-new-grupo-coti','id'=>$model->id,'gridName'=>Json::encode(['grilla-partidas']),'idModal'=>'buscarvalor']);
      echo  Html::button('<span class="fa fa-plus"></span>'.yii::t('base.verbs','Agregar partida'), ['href' => $url, 'title' => 'Nuevo item de '.$model->numero,'id'=>'btn_contacts','idGrilla'=>Json::encode(['grilla-contactos','zona-totales']),  'class' => 'botonAbre btn btn-success']); 
 ?>
 </div>

