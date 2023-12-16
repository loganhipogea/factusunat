<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
use kartik\slider\Slider;
/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\op\models\OpProcesosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('base.names', 'Procesos');
$this->params['breadcrumbs'][] = $this->title;
?>
<h4><?= Html::encode($this->title) ?></h4>
<div class="op-procesos-index">

    
    <div class="box box-success">
     <div class="box-body">
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search_os', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('base.names', 'Crear proceso'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    
    <div style='overflow:auto;'>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
         'summary' => '',
         'tableOptions'=>['class'=>'table table-condensed table-hover table-bordered table-striped'],
        'filterModel' => $searchModel,
        'columns' => [
            
         
         [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}',
                'buttons' => [
                    'update' => function($url, $model) { 
                    $url=Url::to(['edita-os','id'=>$model->id]);
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
                         'delete' => function($url, $model) {                        
                        $options = [
                            'data-confirm' => Yii::t('rbac-admin', 'Are you sure you want to activate this user?'),
                            'title' => Yii::t('base.verbs', 'Delete'),                            
                        ];
                        return Html::a('<span class="btn btn-danger btn-sm glyphicon glyphicon-remove"></span>', $url, $options/*$options*/);
                         }
                    ]
                ],
         
         [
                'attribute'=>'origen',
                'contentOptions'=>['width'=>'50px;'],
                'value'=>function ($model){
                        if($model->hasIngreso()){
                           return $model->ingreso->ne->centroOrigen->nomcen;
                        }
                        return '';
                }
            ],
         
         
         

           // 'id',
             'ot',
             'orden',  
              'fechaini',
            'descripcion',
            /*[
                'attribute'=>'Cliente',
                'value'=>function ($model){
                        return $model->cliente->despro;
                }
            ]*/
           
           // 'fechaini',
           
            'avance',
             [
                'attribute'=>'avance',
                'format'=>'raw',
                'contentOptions'=>['width'=>'50px;'],
                'value'=>function ($model){
                        if($model->avance>0){
                           echo Slider::widget([
                                'sliderColor' => Slider::TYPE_DANGER,
                                'handleColor' => Slider::TYPE_WARNING,
                                'model'=>$model,
                                'attribute'=>'avance',
                                     'pluginOptions' => [
                                                'name'=>$model->id,
                                                'orientation' => 'horizontal',
                                                'handle' => 'round',
                                                'min' => 0,
                                                'max' => 100,
                                                'step' => 1
                                                    ],
                                            ]);
                                            }
                                 return '';
                        }
                                ],       
                    
            //'codpro',
            //'descripcion',
            //'tipo',
            //'codestado',
            //'textocomercial:ntext',
            //'textointerno:ntext',
            //'textotecnico:ntext',

          
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
    </div>
</div>
    </div>
       