<?php
use yii\helpers\Url;
use yii\grid\GridView;
use yii\helpers\Html;
//use kartik\grid\GridView as grid;
use kartik\grid\GridView as grid;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use kartik\tabs\TabsX;
use yii\web\View;
  use common\models\masters\Clipro;
//use common\models\masters\Direcciones;
use common\widgets\linkajaxgridwidget\linkAjaxGridWidget;

/* @var $this yii\web\View */
/* @var $model common\models\masters\Clipro */
/* @var $form yii\widgets\ActiveForm */
$zonaAjax='grilla-centros'
?>
 
  
    <?php Pjax::begin(['id'=>$zonaAjax]); ?>
   
   <?php 
   $gridColumns=[
       
            [
                    
                'class' => 'yii\grid\ActionColumn',
                //'template' => Helper::filterActionColumn(['view', 'activate', 'delete']),
            'template' => '{edit}{delete}',
               'buttons' => [  
                       'edit' => function ($url,$model)use($zonaAjax) {
			    $url= Url::to(['masters/clipro/edita-centro','id'=>$model->codcen,'gridName'=>$zonaAjax,'idModal'=>'buscarvalor']);
                              return \yii\helpers\Html::a('<span class="btn btn-success glyphicon glyphicon-pencil"></span>', $url, ['data-pjax'=>'0','class'=>'botonAbre']);
                            },
                        'delete' => function ($url,$model)use($zonaAjax) {                             
                                $url = \yii\helpers\Url::to([$this->context->id.'/deletemodel-for-ajax','id'=>$model->codcen,'gridName'=>$zonaAjax]);
                              return \yii\helpers\Html::a('<span class="btn btn-danger glyphicon glyphicon-trash"></span>', '#', ['title'=>$url,/*'id'=>$model->codparam,*/'family'=>'holas','id'=>\yii\helpers\Json::encode(['id'=>$model->codcen,'modelito'=> str_replace('@','\\',get_class($model))]),/*'title' => 'Borrar'*/]);
                             }
                        
                    ]
                ],
        [
                'class' => 'kartik\grid\ExpandRowColumn',
                'width' => '50px',
                'value' => function ($model, $key, $index, $column) {
                            return grid::ROW_COLLAPSED;
                                },
                 'detail'=> function($model)  {          
                                        
                          return  $this->render('_expand_sucursal',[
                               'model'=>$model,
                               //'key'=>$key,
                           ]);
                            },
                     //'detailUrl' =>Url::toRoute(['/masters/clipro/_expand_almacen']),
                    //'headerOptions' => ['class' => 'kartik-sheet-style'], 
                    'expandOneOnly' => true
                ],
           
        [
            //'class' => 'kartik\grid\EditableColumn',
            'attribute' => 'nomcen',
           /* 'pageSummary' => 'Total',
            'vAlign' => 'middle',
            'width' => '210px',*/
            
         ],  
          
         [
            //'class' => 'kartik\grid\EditableColumn',
            'attribute' => 'descricen',
           /* 'pageSummary' => 'Total',
            'vAlign' => 'middle',
            'width' => '210px',*/
            
         ],  
         
       [
            //'class' => 'kartik\grid\EditableColumn',
            'attribute' => 'codcen',
           /* 'pageSummary' => 'Total',
            'vAlign' => 'middle',
            'width' => '210px',*/
            
         ],
   ];
   echo grid::widget([
    'dataProvider'=> new \yii\data\ActiveDataProvider([
            'query'=> common\models\masters\Centros::find(),
            ]
            ),
   // 'filterModel' => $searchModel,
       'summary' => '',
    'columns' => $gridColumns,
    'responsive'=>true,
    'hover'=>true
       ]);
   ?> 
   
<?php 
    echo linkAjaxGridWidget::widget([
           'id'=>'widgetgr7878uidBancos',
       // 'otherContainers'=>['pjax-monto','pjax-moneda'],
            'idGrilla'=>$zonaAjax,
            'family'=>'holas',
          'type'=>'POST',
           'evento'=>'click',
        'posicion'=>\yii\web\View::POS_END
       
            //'foreignskeys'=>[1,2,3],
        ]);
    ?>



    <?php Pjax::end(); ?>    
   
<?php
$url= Url::to(['/masters/clipro/agrega-centro','id'=>$model->codpro,'gridName'=>$zonaAjax,'idModal'=>'buscarvalor']);
 
  echo  Html::button('<span class="fa fa-user"></span>'.yii::t('base.verbs','Crear Sucursal'), ['href' => $url, 'title' => 'Nuevo Centro de '.$model->despro,'id'=>'btn_contacts','gridName'=>$zonaAjax,    'class' => 'botonAbre btn btn-success']); 

  
 /* use lo\widgets\modal\ModalAjax;

echo ModalAjax::widget([
    'id' => 'createCompany',
    'header' => 'Create Company',
    'toggleButton' => [
        'label' => 'New Company',
        'class' => 'btn btn-primary pull-right',
        'id'=>'mibotonmodal'
       // 'style'=>'visibility:hidden',
        
    ],
    'url' => $url, // Ajax view with form to load
    'ajaxSubmit' => true, // Submit the contained form as ajax, true by default
    //para que no se esconda la ventana cuando presionas una tecla fuera del marco
    'clientOptions' => ['tabindex'=>'','backdrop' => 'static', 'keyboard' => FALSE]
    // ... any other yii2 bootstrap modal option you need
]);*/
 ?>  
   
   