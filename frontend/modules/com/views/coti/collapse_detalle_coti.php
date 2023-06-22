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
use common\widgets\linkajaxgridwidget\linkAjaxGridWidget;

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
            'template' => '{edit}{delete}{refresh}',
               'buttons' => [  
                       'edit' => function ($url,$model) use($identidad) {
                            $grillas=['grilla-detalle-by-partidas-'.$identidad,'pjax-monto-partida'];
			    $url= Url::to(['/com/coti/modal-edit-detcoti-by-partida','id'=>$model->id,'gridName'=>Json::encode($grillas),'idModal'=>'buscarvalor']);
                              return \yii\helpers\Html::a('<span class="btn btn-success glyphicon glyphicon-pencil"></span>', $url, ['data-pjax'=>'0','class'=>'botonAbre']);
                            },
                        'delete' => function ($url,$model) {                             
                                $url = \yii\helpers\Url::to([$this->context->id.'/ajax-delete-detalle-detalle','id'=>$model->id]);
                              return \yii\helpers\Html::a('<span class="btn btn-danger glyphicon glyphicon-trash"></span>', '#', ['rel'=>$url,/*'id'=>$model->codparam,*/'family'=>'holas','id'=>\yii\helpers\Json::encode(['id'=>$model->id,'modelito'=> str_replace('@','\\',get_class($model))]),/*'title' => 'Borrar'*/]);
                             },
                        'refresh' => function ($url,$model) {                             
                                $url = \yii\helpers\Url::to([$this->context->id.'/ajax-poner-precio-sugerido','id'=>$model->id]);
                              return \yii\helpers\Html::a('<span class="btn btn-danger glyphicon glyphicon-refresh"></span>', '#', ['rel'=>$url,/*'id'=>$model->codparam,*/'family'=>'holas','id'=>\yii\helpers\Json::encode(['id'=>$model->id,'modelito'=> str_replace('@','\\',get_class($model))]),/*'title' => 'Borrar'*/]);
                             },    
                        
                    ],
                 'contentOptions'=>['style'=>'width: 20%;'],  
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
                            return $model->servicio->codserv;
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
                 'expandIcon'=>'<i style="color:#F86E35"><span class="fa fa-plus-square-o"></span></i>',
                 'collapseIcon'=>'<i style="color:#F60101"><span class="fa fa-minus-square-o"></span></i>',
                
                'value' => function ($model, $key, $index, $column) {
                            return grid::ROW_COLLAPSED;
                                },
                   'detail'=> function($model)  { 
                         $tipo=$model->tipo;
                         // $vista= 'ajax_expand_oferta';
                          switch ($tipo) {
                        case 'M':
                        $vista= 'ajax_expand_oferta';
                            break;
                        case 'T':
                            $vista= 'ajax_expand_trabajador';
                            break;
                        break;
                        case 'S':
                            $vista= 'ajax_expand_oferta';
                            break;
                       case 'H':
                            $vista= 'ajax_expand_activo';
                            break;
                        default:
                            $vista= 'ajax_expand_oferta';
                            }
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
      /* [
            'attribute' => 'punit',
            'value'=>function($model)use($formato){
              return $formato->asDecimal($model->punit,2);
            },
           'contentOptions'=>['style'=>'text-align:right; width: 5%; '], 
           
         ], */
       [
            'class' => 'kartik\grid\EditableColumn',
            'attribute' => 'punit',
          //  'pageSummary' => 'Total',
            'vAlign' => 'middle',
            'width' => '210px',
            'readonly' => false,
           'value'=>function($model)use($formato){
              return $formato->asDecimal($model->punit,2);
            },
           //'data'=>['modelo'=>'mimodelo']
            'contentOptions'=>['style'=>'text-align:right; width: 2%; '],  
         ],             
                    
                    
        [
            'class' => 'kartik\grid\EditableColumn',
            'attribute' => 'cant',
            'value'=>function($model)use($formato){
              return $formato->asDecimal($model->cant,2);
            },
           'contentOptions'=>['style'=>'text-align:right; width: 2%; '], 
         ],  
       
      [
            
            'attribute' => 'montoneto',
            'value'=>function($model)use($formato){
              return $formato->asDecimal($model->montoneto,2);
            },
           'contentOptions'=>['style'=>'text-align:right; width: 2%; '], 
         ],  

      
   ];
        
 
            
 $modelCoti=$model->coti;
 $carguitos=$modelCoti->array_cargos();

 foreach($carguitos as $cargo=>$porcentaje){
     array_push($gridColumns,['attribute'=>$cargo,'value'=>function($model)use($porcentaje,$formato){return $formato->asDecimal($model->montoneto*$porcentaje/100);}]);
    }
array_push($gridColumns,[
    'attribute'=>'ptotal',
    'value'=>function($model)use($formato){return $formato->asDecimal($model->ptotal,3);},
    'contentOptions'=>['style'=>'text-align:right; width: 5%; font-weight:900;'],
       'footer' =>$formato->asDecimal($model->subTotalTotal(),3),
    ]);
    
 

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
    'showFooter' => true,
   // 'filterModel' => $searchModel,
        'summary' => '',
        'columns' => $gridColumns,
    //'responsive'=>true,
    //'hover'=>true
       ]);
   
    echo linkAjaxGridWidget::widget([
           'id'=>'widgetgruidBancos',
        //'otherContainers'=>['grilla-partidas'],
            'idGrilla'=>'grilla-detalle-by-partidas-'.$model->id,
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
  


