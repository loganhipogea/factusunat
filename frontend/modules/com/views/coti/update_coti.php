<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\Json;
use common\helpers\h;
use kartik\tabs\TabsX;
use yii\grid\GridView as grid;

/* @var $this yii\web\View */
/* @var $model frontend\modules\sta\models\Talleres */
ECHO \common\widgets\spinnerWidget\spinnerWidget::widget();
/* @var $this yii\web\View */
/* @var $model frontend\modules\com\models\ComCotizacion */

$this->title = Yii::t('app', 'Update Com Cotizacion: {name}', [
    'name' => $model->id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Com Cotizacions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="com-cotizacion-update">
<h4><i class="fa fa-edit"></i><?= Html::encode($this->title) ?></h4>
   
    <div class="box box-success">
    
    <?php echo TabsX::widget([
    'position' => TabsX::POS_ABOVE,
     'bordered'=>true,
    'align' => TabsX::ALIGN_LEFT,
      'encodeLabels'=>false,
    'items' => [
        [
          'label'=>'<i class="fa fa-home"></i> '.yii::t('base.names','Principal'), //$this->context->countDetail() obtiene el contador del detalle
            'content'=> $this->render('_form_coti',['model' => $model]),
            'active' => true,
             'options' => ['id' => 'myveryownID3'],
        ],
        [
          'label'=>'<i class="fa fa-users"></i> '.yii::t('base.names','Grupos'), //$this->context->countDetail() obtiene el contador del detalle
            'content'=> $this->render('_adicionales_coti',[ 'model' => $model]),
            'active' => false,
             'options' => ['id' => 'myveryownID4'],
        ],
       
        
       
    ],
]);  ?>

<?php

   if(!$model->isNewRecord){
  $column=[
                    
                'class' => 'yii\grid\ActionColumn',
                //'template' => Helper::filterActionColumn(['view', 'activate', 'delete']),
            'template' => '{edit}{delete}',
               'buttons' => [  
                       'edit' => function ($url,$model) {
			    $url= Url::to(['/com/com/edit-detail-invoice','id'=>$model->id,'gridName'=>Json::encode(['grilla-contactos','zona-totales']),'idModal'=>'buscarvalor']);
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
            'attribute' => 'tipo',
           /* 'pageSummary' => 'Total',
            'vAlign' => 'middle',
            'width' => '210px',*/
            
         ],  
        'codart',
                            
       [
            //'class' => 'kartik\grid\EditableColumn',
            'attribute' => 'descripcion',
           /* 'pageSummary' => 'Total',
            'vAlign' => 'middle',
            'width' => '210px',*/
            
         ],
      
         [           
            'attribute' => 'punit', 
             
         ],
          
        
       [
                       'attribute' => 'pventa',          
         ],
                            [  
            'headerOptions' => [
                        'class' => 'text-right',
                        'style' => 'text-align: right;',
                            ],                    
            'attribute' => 'igv',          
         ],
   ];
   echo grid::widget([
    'dataProvider'=>$providerItems,
    'filterModel' => $searchModel,
        'summary' => '',
        'columns' => $gridColumns,
    //'responsive'=>true,
    //'hover'=>true
       ]);
   ?> 
 <div class="btn-group">
<?php
      $url= Url::to(['/com/coti/new-grupo-coti','id'=>$model->id,'gridName'=>Json::encode(['grilla-contactos','zona-totales']),'idModal'=>'buscarvalor']);
      echo  Html::button('<span class="fa fa-plus"></span>'.yii::t('base.verbs','Add Detail'), ['href' => $url, 'title' => 'Nuevo item de '.$model->numero,'id'=>'btn_contacts','idGrilla'=>Json::encode(['grilla-contactos','zona-totales']),  'class' => 'botonAbre btn btn-success']); 
 ?>
<?php
      //$url= Url::to(['/com/com/new-detail-invoice','id'=>$model->id,'gridName'=>Json::encode(['grilla-contactos','zona-totales']),'idModal'=>'buscarvalor']);
      //echo  Html::button('<span class="fa fa-plus"></span>'.yii::t('base.verbs','Add Detail'), ['href' => $url, 'title' => 'Nuevo item de '.$model->numero,'id'=>'btn_contacts','idGrilla'=>Json::encode(['grilla-contactos','zona-totales']),  'class' => 'botonAbre btn btn-success']); 
 ?>
 </div>
