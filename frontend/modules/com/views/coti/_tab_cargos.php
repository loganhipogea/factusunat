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
  $column=[
                    
                'class' => 'yii\grid\ActionColumn',
                //'template' => Helper::filterActionColumn(['view', 'activate', 'delete']),
            'template' => '{edit}{delete}',
               'buttons' => [  
                       'edit' => function ($url,$model) {
			    $url= Url::to(['/com/coti/modal-edit-cargo-coti','id'=>$model->id,'gridName'=>Json::encode(['grilla-cargos']),'idModal'=>'buscarvalor']);
                              return \yii\helpers\Html::a('<span class="btn btn-success glyphicon glyphicon-pencil"></span>', $url, ['data-pjax'=>'0','class'=>'botonAbre']);
                            },                       
                        'delete' => function ($url,$model) {                             
                                $url = \yii\helpers\Url::to([$this->context->id.'/ajax-delete-cargo','id'=>$model->id]);
                              return \yii\helpers\Html::a('<span class="btn btn-danger glyphicon glyphicon-trash"></span>', '#', ['rel'=>$url,/*'id'=>$model->codparam,*/'family'=>'holas','id'=>\yii\helpers\Json::encode(['id'=>$model->id,'modelito'=> str_replace('@','\\',get_class($model))]),/*'title' => 'Borrar'*/]);
                             },
                        
                    ]
                ];
   }
   $gridColumns=[       
            $column,
       
       
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

<div class="form-group">
      <div class="btn-group">   
          <?php
          echo Html::button("<span class=\"fa fa-paper-plane\"></span>Cargos", 
                          [
                              'id'=>'btn_cargos',
                              'class' => 'btn btn-warning']
                          );
         ?>
      </div>
</div>
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
   
  
    echo linkAjaxGridWidget::widget([
           'id'=>'widgetgruidBancoss34365',
        //'otherContainers'=>['grilla-partidas'],
            'idGrilla'=>'grilla-cargos',
            'family'=>'holas',
          'type'=>'POST',
           'evento'=>'click',
        'posicion'=>\yii\web\View::POS_END
       
            //'foreignskeys'=>[1,2,3],
        ]);
       
   
     
     
      echo inputAjaxWidget::widget([
            //'isHtml'=>true,
             'id'=>'btn_fct_aprobar',
            //'otherContainers'=>[$send_zone],
             'evento'=>'click',
            'tipo'=>'POST',
            'ruta'=>Url::to(['/com/coti/ajax-agrega-cargos','id'=>$model->id]),
            'id_input'=>'btn_cargos',
            'idGrilla'=>'grilla-cargos',
      ]);  

    
    
   
   
    \yii\widgets\Pjax::end();
   ?> 
 <div class="btn-group">
<?php
      $url= Url::to(['/com/coti/modal-new-cargo-coti','id'=>$model->id,'gridName'=>Json::encode(['grilla-cargos']),'idModal'=>'buscarvalor']);
      echo  Html::button('<span class="fa fa-plus"></span>'.yii::t('base.verbs','Agregar cargo'), ['href' => $url, 'title' => 'Nuevo item de '.$model->numero,'id'=>'btn_contactss','idGrilla'=>Json::encode(['grilla-cargos']),  'class' => 'botonAbre btn btn-success']); 
 ?>
 </div>
    
     