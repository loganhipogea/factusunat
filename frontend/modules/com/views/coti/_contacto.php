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
			    $url= Url::to(['/com/coti/modal-edit-contacto-coti','id'=>$model->id,'gridName'=>Json::encode(['grilla-contactos']),'idModal'=>'buscarvalor']);
                              return \yii\helpers\Html::a('<span class="btn btn-success glyphicon glyphicon-pencil"></span>', $url, ['data-pjax'=>'0','class'=>'botonAbre']);
                            },                       
                        'delete' => function ($url,$model) {                             
                                $url = \yii\helpers\Url::to([$this->context->id.'/ajax-delete-contacto','id'=>$model->id]);
                              return \yii\helpers\Html::a('<span class="btn btn-danger glyphicon glyphicon-trash"></span>', '#', ['rel'=>$url,/*'id'=>$model->codparam,*/'family'=>'holas','id'=>\yii\helpers\Json::encode(['id'=>$model->id,'modelito'=> str_replace('@','\\',get_class($model))]),/*'title' => 'Borrar'*/]);
                             },
                           
                    ]
                ];
   }
   $gridColumns=[       
            $column,
               
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
    <div class="form-group">
      <div class="btn-group">   
          <?php
          echo Html::button("<span class=\"fa fa-paper-plane\"></span>Contactos", 
                          [
                              'id'=>'btn_contactos',
                              'class' => 'btn btn-warning']
                          );
         ?>
      </div>
</div>
     
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
   
  
    echo linkAjaxGridWidget::widget([
           'id'=>'widgetgruidBancderos',
        //'otherContainers'=>['grilla-partidas'],
            'idGrilla'=>'grilla-contactos',
            'family'=>'holas',
          'type'=>'POST',
           'evento'=>'click',
        'posicion'=>\yii\web\View::POS_END
       
            //'foreignskeys'=>[1,2,3],
        ]);
       
   
   
   
    \yii\widgets\Pjax::end();
    echo inputAjaxWidget::widget([
            //'isHtml'=>true,
             'id'=>'btn_fct_aprobtar',
            //'otherContainers'=>[$send_zone],
             'evento'=>'click',
            'tipo'=>'POST',
            'ruta'=>Url::to(['/com/coti/ajax-load-contactos','id'=>$model->id]),
            'id_input'=>'btn_contactos',
            'idGrilla'=>'grilla-contactos',
      ]);  

   ?> 
 <div class="btn-group">
<?php
      $url= Url::to(['/com/coti/modal-new-contacto-coti','id'=>$model->id,'gridName'=>Json::encode(['grilla-partidas']),'idModal'=>'buscarvalor']);
      echo  Html::button('<span class="fa fa-plus"></span>'.yii::t('base.verbs','Agregar contacto'), ['href' => $url, 'title' => 'Nuevo item de '.$model->numero,'id'=>'btn_contacts','idGrilla'=>Json::encode(['grilla-contactos']),  'class' => 'botonAbre btn btn-success']); 
 ?>
 </div>

