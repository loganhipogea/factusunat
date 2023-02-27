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
            'template' => '{edit}{delete}{attach}',
               'buttons' => [  
                       'edit' => function ($url,$model) {
			    $url= Url::to(['/com/coti/modal-edit-adjunto-coti','id'=>$model->id,'gridName'=>Json::encode(['grilla-adjuntos']),'idModal'=>'buscarvalor']);
                              return \yii\helpers\Html::a('<span class="btn btn-success glyphicon glyphicon-pencil"></span>', $url, ['data-pjax'=>'0','class'=>'botonAbre']);
                            },                       
                        'delete' => function ($url,$model) {                             
                                $url = \yii\helpers\Url::to([$this->context->id.'/ajax-delete-adjunto','id'=>$model->id]);
                              return \yii\helpers\Html::a('<span class="btn btn-danger glyphicon glyphicon-trash"></span>', '#', ['rel'=>$url,/*'id'=>$model->codparam,*/'family'=>'holas','id'=>\yii\helpers\Json::encode(['id'=>$model->id,'modelito'=> str_replace('@','\\',get_class($model))]),/*'title' => 'Borrar'*/]);
                             },
                    'attach' => function($url, $model) {  
                         $url=\yii\helpers\Url::toRoute(['/finder/selectimage',
                             'isImage'=>false,
                             'idModal'=>'imagemodal',
                             'modelid'=>$model->id,
                             'extension'=> \yii\helpers\Json::encode(['png','jpg','jpeg','pdf']),
                             'nombreclase'=> str_replace('\\','_',get_class($model))]);
                        $options = [
                            'title' => Yii::t('base.names', 'Subir Archivo'),
                            //'aria-label' => Yii::t('rbac-admin', 'Activate'),
                            //'data-confirm' => Yii::t('rbac-admin', 'Are you sure you want to activate this user?'),
                            'data-method' => 'get',
                            //'data-pjax' => '0',
                        ];
                        return Html::button('<span class="glyphicon glyphicon-paperclip"></span>', ['href' => $url, 'title' => 'Editar Adjunto', 'class' => 'botonAbre btn btn-success']);
                        //return Html::a('<span class="btn btn-success glyphicon glyphicon-pencil"></span>', Url::toRoute(['view-profile','iduser'=>$model->id]), []/*$options*/);
                     
                        
                                 },      
                    ]
                ];
   }
   $gridColumns=[       
            $column,
       
       
        [
            'attribute' => 'descripcion',
            'value'=>function($model){
                return $model->descripcion;
            }
           
         ],  
                      
       [
            //'class' => 'kartik\grid\EditableColumn',
            'attribute' => 'detalle',
           /* 'pageSummary' => 'Total',
            'vAlign' => 'middle',
            'width' => '210px',*/
           'value'=>function($model){
                return substr($model->detalle,0,20);
            }
            
         ],
     
        [
            //'class' => 'kartik\grid\EditableColumn',
            'attribute' => 'adjunto',
            'format'=>'raw',
           /* 'pageSummary' => 'Total',
            'vAlign' => 'middle',
            'width' => '210px',*/
           'value'=>function($model){
                if($model->hasAttachments()){
                    $file=$model->files[0];
                    return Html::a(substr($file->name.'.'.$file->type,0,70),$file->url,['data-pjax'=>'0']);

                }
                  return 'Vacío...';
            }
            
         ], 
   ];
         
 ?>

<?php
         
   \yii\widgets\Pjax::begin(['id'=>'grilla-adjuntos']);
   echo grid::widget([
    'dataProvider'=>New \yii\data\ActiveDataProvider([
        'query'=> frontend\modules\com\models\ComCotiadjuntos::find()
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
            'idGrilla'=>'grilla-adjuntos',
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
            'id_input'=>'btn_adjuntos',
            'idGrilla'=>'grilla-adjuntos',
      ]);  

    
    
   
   
    \yii\widgets\Pjax::end();
   ?> 
 <div class="btn-group">
<?php
      $url= Url::to(['/com/coti/modal-new-adjunto-coti','id'=>$model->id,'gridName'=>Json::encode(['grilla-adjuntos']),'idModal'=>'buscarvalor']);
      echo  Html::button('<span class="fa fa-plus"></span>'.yii::t('base.verbs','Agregar adjunto'), ['href' => $url, 'title' => 'Nuevo adjunto de '.$model->numero,'id'=>'btn_contactss','idGrilla'=>Json::encode(['grilla-cargos']),  'class' => 'botonAbre btn btn-success']); 
 ?>
 </div>
    
     