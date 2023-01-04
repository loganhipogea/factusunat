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
/* @var $this yii\web\View */
/* @var $model frontend\modules\com\models\ComCotizacion */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="com-cotizacion-form">
    <br>
    <?php $form = ActiveForm::begin([
    'fieldClass'=>'\common\components\MyActiveField'
    ]); ?>
      
      <div class="box-body">
   <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'codigo')->textInput(['maxlength' => true,'disabled'=>true]) ?>

   </div> 
   <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true,'disabled'=>true]) ?>

   </div> 
   
    
    <?php ActiveForm::end(); ?>
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">        
  <?php   
  $column=[
                    
                'class' => 'yii\grid\ActionColumn',
                //'template' => Helper::filterActionColumn(['view', 'activate', 'delete']),
            'template' => '{edit}{delete}',
               'buttons' => [  
                       'edit' => function ($url,$model) {
			    $url= Url::to(['/mat/mat/modal-edita-activo-colector','id'=>$model->id,'gridName'=>Json::encode(['grilla-detalle-by-cecos','pjax-monto-ceco']),'idModal'=>'buscarvalor']);
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
         
        'ceco_id',
        'activo_id',
        'codmon',
                
        'valor',
       [
            'attribute' => 'ceco',
            'value'=>function($model){
              return $model->cc->descripcion;
            }
           
         ],  
      [
            'attribute' => 'activo',
            'value'=>function($model){
              return $model->activo->descripcion;
            }
           
         ],  
       
        
   ];
   \yii\widgets\Pjax::begin(['id'=>'grilla-detalle-by-cecos']);
   echo '.'.grid::widget([
    'dataProvider'=>New \yii\data\ActiveDataProvider([
        'query'=> frontend\modules\mat\models\MatActivoscecos::find()
            ->select('t.*')->alias('t')->
            andWhere([
                'activo_id'=>$model->id,
                //'coticeco_id'=>$model->id,
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
  </div>
 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">  
<?php
      $url= Url::to(['/mat/mat/modal-crea-activo-colector','id'=>$model->id,'gridName'=>Json::encode(['grilla-detalle-by-cecos','pjax-monto-ceco']),'idModal'=>'buscarvalor']);
      echo  Html::button('<span class="fa fa-plus"></span>'.yii::t('base.verbs','Add Detail'), ['href' => $url, 'title' => 'Nuevo item de ','id'=>'btn_contacts','idGrilla'=>Json::encode(['grilla-cecos']),  'class' => 'botonAbre btn btn-success']); 
 ?>     
 </div>         
          
          
          

</div>
    </div>


