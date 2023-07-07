<?php
use yii\helpers\Url;
use yii\helpers\Html;
//use yii\grid\GridView;
USE yii\widgets\Pjax;
use common\helpers\h;
use kartik\export\ExportMenu;
use kartik\grid\GridView as GridView;
/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\logi\models\StockSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('logi.labels', 'Contenido');
$this->params['breadcrumbs'][] = $this->title;
$formato=h::formato();
?>
<div class="stock-index">

    <h4><?= Html::encode($this->title) ?></h4>
    <div class="box box-success">
     <div class="box-body">
    
     <?php 
     $options=['class'=>'botonAbre','data-pjax'=>'0'];
      $url= Url::to(['site/modal-crear-contenido','gridName'=>'contenido-index','idModal'=>'buscarvalor']);
      $boton= Html::a('<span class="glyphicon glyphicon-pencil btn btn-danger"></span>', $url, $options);
     ?>
       
   
    <?php Pjax::begin(['id'=>'contenido-index']); ?>
    <div style='overflow:auto;'>
    <?php 
    
    echo $boton.ExportMenu::widget([
    'dataProvider' => $dataProvider,    
   
    'dropdownOptions' => [
        'label' => yii::t('base.names','Exportar'),
        'class' => 'btn btn-primary'
    ]
]).''. GridView::widget([
        'dataProvider' => $dataProvider,
         'summary' => '',
         'tableOptions'=>['class'=>'table table-condensed table-hover table-bordered table-striped'],
        //'filterModel' => $searchModel,
        'columns' => [
            
      [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{edit}{attach}',
                'buttons' => [
                    
                       'edit' => function ($url,$model) {
                             
                             $options=['class'=>'botonAbre','data-pjax'=>'0'];
			    $url= Url::to(['site/modal-editar-contenido','id'=>$model->id,'gridName'=>'contenido-index','idModal'=>'buscarvalor']);
                              return \yii\helpers\Html::a('<span class="glyphicon glyphicon-pencil btn btn-danger"></span>', $url, $options);
                            },          
                         'attach' => function($url, $model) {  
                         $url=\yii\helpers\Url::toRoute(['/finder/selectimage','idModal'=>'imagemodal',
                             'extension'=> \yii\helpers\Json::encode(array_merge(common\helpers\FileHelper::extImages())) ,
                             'modelid'=>$model->id,'nombreclase'=> str_replace('\\','_',get_class($model))]);
                        $options = [
                            'title' => Yii::t('base.names', 'Colocar en el maletín'),
                            //'aria-label' => Yii::t('rbac-admin', 'Activate'),
                            //'data-confirm' => Yii::t('rbac-admin', 'Are you sure you want to activate this user?'),
                            'data-method' => 'get',
                            //'data-pjax' => '0',
                        ];
                        return Html::button('<span class="glyphicon glyphicon-paperclip"></span>', ['href' => $url, 'title' => 'Editar Adjunto', 'class' => 'botonAbre btn btn-success']);
                        //return Html::a('<span class="btn btn-success glyphicon glyphicon-pencil"></span>', Url::toRoute(['view-profile','iduser'=>$model->id]), []/*$options*/);
                     
                        
                        },        
                          
                    ],
                     
                ],        
         [
                'class' => 'kartik\grid\ExpandRowColumn',
                'width' => '50px',
                 'expandIcon'=>'<i style="color:#F86E35"><span class="fa fa-plus-square-o"></span></i>',
                 'collapseIcon'=>'<i style="color:#F60101"><span class="fa fa-minus-square-o"></span></i>',
               'value' => function ($model, $key, $index, $column) {
                            return GridView::ROW_COLLAPSED;
                                },
                 /*'detail'=> function($model)  {          
                                        
                          return  $this->render('ait_columnas',[
                               'model'=>$model,
                               'key'=>$key,
                           ]);
                            },*/
                    'detailUrl' =>Url::toRoute(['/site/ajax-expand-columnas']),
                    'headerOptions' => ['class' => 'kartik-sheet-style'], 
                    'expandOneOnly' => true
                ],         
         
              ['attribute'=>'clave',
                  'format'=>'html',
                'value'=>function ($model){                    
                    return $model->clave;
                  }
                ],
            
            ['attribute'=>'titulo',
                //'headerOptions' => ['style' => 'width:20%'],
                  'value'=>function ($model){
                    return $model->titulo;
                  }
                ],
            ['attribute'=>'cuerpo',
                'format'=>'raw',
                //'headerOptions' => ['style' => 'width:50%'],
                  'value'=>function ($model){
                    return substr($model->cuerpo,0,20).'...';
                  }
                ],
             
         ['attribute'=>'zona',
               // 'headerOptions' => ['style' => 'width:50%'],
                //'filter'=> frontend\modules\mat\helpers\comboHelper::getCboAlmacenes(),
                  'value'=>function ($model){
                    return $model->zona;
                  }
                ],
           
          ['attribute'=>'activo',
                'format'=>'raw',
                'value'=>function ($model){
                    return Html::checkbox($model->clave, $model->activo,['disabled'=>true]);
                  }
                ], 
         
        ],
    ]); ?>
</div>
     <?php Pjax::end(); ?>
    </div>
</div>
    </div>
       