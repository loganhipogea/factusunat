<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Pjax;
use common\helpers\h;
use kartik\grid\GridView;
use frontend\modules\mat\models\MatStock;
/* @var $this yii\web\View */
/* @var $searchModel common\models\masters\CentrosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('base.names', 'Almacenes');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="centros-index">

    <h4><span class="fa fa-industry"></span><?= Html::encode($this->title) ?></h4>
    <div class="box box-success">
     <div class="box-body">
    <?php Pjax::begin(); ?>
    <?php
      $formato=h::formato();
// echo $this->render('_search', ['model' => $searchModel]); ?>

    
    <div style='overflow:auto;'>
    <?php 
    $stockTotal= MatStock::valorStock();
    $itemsTotal= MatStock::nItems();
    ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
         'summary' => '',
         'showFooter' => true,
         'footerRowOptions'=>['style'=>'text-align:right; font-weight:800;font-size:1.2em; color:#3A0A38'],
         'tableOptions'=>['class'=>'table table-condensed table-hover table-bordered table-striped'],
        'filterModel' => $searchModel,
        'columns' => [
            
         
         [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}{view}',
                'buttons' => [
                    'update' => function($url, $model) {
                        $url=Url::to(['/masters/centros/update-almacen','codal'=>$model->codal]);
                        $options = [
                            'title' => Yii::t('base.verbs', 'Update'),                            
                        ];
                        return Html::a('<span class="btn btn-info btn-sm glyphicon glyphicon-pencil"></span>', $url, $options/*$options*/);
                         },
                          'view' => function($url, $model) {                        
                        $options = [
                            'title' => Yii::t('base.verbs', 'View'),                            
                        ];
                        return Html::a('<span class="btn btn-warning btn-sm glyphicon glyphicon-search"></span>', $url, $options/*$options*/);
                         },
                         
                    ]
                ],
         
              [
                'class' => 'kartik\grid\ExpandRowColumn',
                'width' => '50px',
                'value' => function ($model, $key, $index, $column) {
                            return GridView::ROW_COLLAPSED;
                                }, 
                    'detail' => function ($model, $key, $index, $column) {
                            return $this->render('indicadores_almacen',['model'=>$model]);
                            },
                   
                   'expandOneOnly' => true
                ],  
         
         
         

            [
               'header'=>'codal', 
                'headerOptions' => ['style' => 'width:10%'],
                //'contentOptions'=>['style'=>'text-align:right; font-weight:800;',], 
                'value' => function ($model)  {
                     return $model->codal;
                }         
                ], 
            'nomal',
            [
               'header'=>'Valor', 
                 'footer' => $formato->asDecimal($stockTotal,2),
                
                'contentOptions'=>['style'=>'text-align:right; font-weight:800;',], 
                'value' => function ($model) use($formato) {
                     return $formato->asDecimal($model->valor,2);
                }         
                ], 
           [
               'header'=>'Items',
                'footer' => $itemsTotal,
                'contentOptions'=>['style'=>'text-align:right; font-weight:800;',], 
                'value' => function ($model)  {
                     return $model->nitems;
                }         
                ], 
           
        ],
    ]); ?>
    <?php Pjax::end(); ?>
        
</div>
    </div>
</div>
    </div>
       