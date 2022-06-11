<?php
use yii\helpers\Url;
use yii\grid\GridView;
use yii\helpers\Html;
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
 $zonaAjax='grilla-socios'
?>
 
  
    <?php Pjax::begin(['id'=>$zonaAjax]); ?>
   
   <?php 
   $gridColumns=[
       
            [
                    
                'class' => 'yii\grid\ActionColumn',
                //'template' => Helper::filterActionColumn(['view', 'activate', 'delete']),
            'template' => '{edit}{view}',
               'buttons' => [  
                       'edit' => function ($url,$model)use($zonaAjax)  {
			    $url= Url::to(['masters/clipro/update','id'=>$model->codpro]);
                              return \yii\helpers\Html::a('<span class="btn btn-success glyphicon glyphicon-pencil"></span>', $url, ['data-pjax'=>'0']);
                            },
                       'view' => function ($url,$model)use($zonaAjax)  {
			    $url= Url::to(['masters/clipro/view','id'=>$model->codpro,]);
                              return \yii\helpers\Html::a('<span class="btn btn-warning glyphicon glyphicon-search"></span>', $url, ['data-pjax'=>'0']);
                            },
                        
                    ]
                ],
           
        [
            //'class' => 'kartik\grid\EditableColumn',
            'attribute' => 'codpro',
           /* 'pageSummary' => 'Total',
            'vAlign' => 'middle',
            'width' => '210px',*/
            
         ],  
          
         [
            //'class' => 'kartik\grid\EditableColumn',
            'attribute' => 'despro',
           /* 'pageSummary' => 'Total',
            'vAlign' => 'middle',
            'width' => '210px',*/
            
         ],  
         
       [
            //'class' => 'kartik\grid\EditableColumn',
            'attribute' => 'rucpro',
           /* 'pageSummary' => 'Total',
            'vAlign' => 'middle',
            'width' => '210px',*/
            
         ],
   ];
   echo grid::widget([
    'dataProvider'=> new \yii\data\ActiveDataProvider([
            'query'=> common\models\masters\Clipro::find()->
             andWhere(['socio'=>'1'])->andWhere(['<>','codpro',$model->codpro]),
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

 ?>  
   
   