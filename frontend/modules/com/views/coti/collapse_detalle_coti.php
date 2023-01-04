<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\Json;
use yii\widgets\ActiveForm;
use common\helpers\h;
use common\widgets\selectwidget\selectWidget;
use kartik\date\DatePicker;
use kartik\grid\GridView as grid;
use yii\widgets\Pjax;
use frontend\modules\com\models\ComDetcoti;
/* @var $this yii\web\View */
/* @var $model frontend\modules\com\models\ComCotizacion */
/* @var $form yii\widgets\ActiveForm */
?>

  
    <br>
    <div class="panel panel-default">
        
    
        <div class="panel-heading">
            <h4 class="panel-title"><?=$model->descripcion?></h4>
       </div>
        <div>
        <?php 
            $identidad=$model->id;
            $column=[
                    
                'class' => 'yii\grid\ActionColumn',
                //'template' => Helper::filterActionColumn(['view', 'activate', 'delete']),
            'template' => '{edit}{delete}',
               'buttons' => [  
                       'edit' => function ($url,$model) use($identidad) {
                            $grillas=['grilla-detalle-by-partidas-'.$identidad,'pjax-monto-partida'];
			    $url= Url::to(['/com/coti/modal-edit-detcoti-by-partida','id'=>$model->id,'gridName'=>Json::encode($grillas),'idModal'=>'buscarvalor']);
                              return \yii\helpers\Html::a('<span class="btn btn-success glyphicon glyphicon-pencil"></span>', $url, ['data-pjax'=>'0','class'=>'botonAbre']);
                            },
                        'delete' => function ($url,$model) {                             
                                $url = \yii\helpers\Url::to([$this->context->id.'/ajax-delete-ceco','id'=>$model->id]);
                              return \yii\helpers\Html::a('<span class="btn btn-danger glyphicon glyphicon-trash"></span>', '#', ['rel'=>$url,/*'id'=>$model->codparam,*/'family'=>'holas','id'=>\yii\helpers\Json::encode(['id'=>$model->id,'modelito'=> str_replace('@','\\',get_class($model))]),/*'title' => 'Borrar'*/]);
                             },
                            
                        
                    ]
                ];
   
   $gridColumns=[       
            $column,
        [
            'attribute' => 'item',
            'value'=>function($model){
              return $model->item;
            }
           
         ],
         [
          'attribute' => 'descripcion',         
          'contentOptions'=>['style'=>'width: 30%;'],  
         ],
        'tipo',
       
        [
            'attribute' => 'codart',
            'value'=>function($model){
                        $tipo=$model->tipo;
              switch ($tipo) {
                        case 'M':
                        return $model->codart;
                            break;
                        case 'T':
                            return $model->codcargo;
                            break;
                        break;
                        case 'S':
                            return '';
                            break;
                       case 'H':
                           return $model->codactivo;
                            break;
                        default:
                            return '';
                            }
            },
           'contentOptions'=>['style'=>'text-align:right; color:orange; width: 5%; font-weight:900;'],
         ], 
        'codum',
                 [
                'class' => 'kartik\grid\ExpandRowColumn',
                'width' => '50px',
                'value' => function ($model, $key, $index, $column) {
                            return grid::ROW_COLLAPSED;
                                },
                   'detail'=> function($model)  { 
                         $tipo=$model->tipo;
                          $vista= 'ajax_expand_oferta';
                            /*switch ($tipo) {
                        case 'M':
                        $vista= 'ajax_expand_oferta';
                            break;
                        case 'T':
                            $vista= 'ajax_expand_trabajo';
                            break;
                        break;
                        case 'S':
                            $vista= 'ajax_expand_servicio';
                            break;
                       case 'H':
                            $vista= 'ajax_expand_activo';
                            break;
                        default:
                            $vista= 'ajax_expand_oferta';
                            }*/
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
            'attribute' => 'punitcalculado',
            'value'=>function($model)use($formato){
              return $formato->asDecimal($model->punitcalculado,2);
            },
           'contentOptions'=>['style'=>'text-align:right; color:orange; width: 5%; font-weight:900;'],
         ], 
       [
            'attribute' => 'punit',
            'value'=>function($model)use($formato){
              return $formato->asDecimal($model->punit,2);
            },
           'contentOptions'=>['style'=>'text-align:right; width: 5%; '], 
           
         ],  
        [
            'attribute' => 'cant',
            'value'=>function($model)use($formato){
              return $formato->asDecimal($model->cant,2);
            },
           'contentOptions'=>['style'=>'text-align:right; width: 5%; '], 
         ],  
       
      [
            'attribute' => 'ptotal',
            'value'=>function($model)use($formato){
              return $formato->asDecimal($model->ptotal,2);
            },
            'contentOptions'=>['style'=>'text-align:right; width: 5%; font-weight:900;'],
        ],  
        
   ];
    echo frontend\modules\com\models\ComDetcoti::find()
            ->select('t.*')->alias('t')->
            andWhere([
                'coti_id'=>$model->coti_id,
                'cotigrupo_id'=>$model->cotigrupo_id,
                'detcoti_id'=>$model->id,
                
                    ])->createCommand()->rawSql;
   \yii\widgets\Pjax::begin(['id'=>'grilla-detalle-by-partidas-'.$model->id]);
   echo '.'.grid::widget([
    'dataProvider'=>New \yii\data\ActiveDataProvider([
        'query'=> frontend\modules\com\models\ComDetcoti::find()
            ->select('t.*')->alias('t')->
            andWhere([
                'coti_id'=>$model->coti_id,
                'cotigrupo_id'=>$model->cotigrupo_id,
                'detcoti_id'=>$model->id,
                
                    ])
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
    $grillas=['grilla-detalle-by-partidas-'.$model->id,'pjax-monto-partida'];
      $url= Url::to(['/com/coti/modal-new-detcoti-by-partida','id'=>$model->id,'partida_id'=>$model->cotigrupo_id,'tipo'=>'M','gridName'=>Json::encode($grillas),'idModal'=>'buscarvalor']);
      echo  Html::button('<span class="fa fa-cubes"></span>', ['href' => $url, 'title' => 'Nuevo item de ','id'=>'btn_contacts','idGrilla'=>Json::encode(['grilla-cecos']),  'class' => 'botonAbre btn btn-success']); 
      
      $url= Url::to(['/com/coti/modal-new-detcoti-by-partida','id'=>$model->id,'partida_id'=>$model->cotigrupo_id,'tipo'=>'T','gridName'=>Json::encode($grillas),'idModal'=>'buscarvalor']);
      echo  Html::button('<span class="fa fa-users"></span>', ['href' => $url, 'title' => 'Nuevo item de ','id'=>'btn_trabaSjos','idGrilla'=>Json::encode(['grilla-cecos']),  'class' => 'botonAbre btn btn-success']); 
 
      $url= Url::to(['/com/coti/modal-new-detcoti-by-partida','id'=>$model->id,'partida_id'=>$model->cotigrupo_id,'tipo'=>'H','gridName'=>Json::encode($grillas),'idModal'=>'buscarvalor']);
      echo  Html::button('<span class="fa fa-wrench"></span>', ['href' => $url, 'title' => 'Nuevo item de ','id'=>'btn_tSSrabajos','idGrilla'=>Json::encode(['grilla-cecos']),  'class' => 'botonAbre btn btn-success']); 
      
      $url= Url::to(['/com/coti/modal-new-detcoti-by-partida','id'=>$model->id,'partida_id'=>$model->cotigrupo_id,'tipo'=>'S','gridName'=>Json::encode($grillas),'idModal'=>'buscarvalor']);
      echo  Html::button('<span class="fa fa-shopping-cart"></span>', ['href' => $url, 'title' => 'Nuevo item de ','id'=>'btn_tSSrabajos','idGrilla'=>Json::encode(['grilla-cecos']),  'class' => 'botonAbre btn btn-success']); 
      ?>     
    </div>
    </div>        
   </div> 
  


