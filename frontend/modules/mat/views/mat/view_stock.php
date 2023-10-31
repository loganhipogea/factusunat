<?php
use yii\helpers\Url;
use yii\helpers\Html;
//use yii\grid\GridView;
USE yii\widgets\Pjax;
use common\helpers\h;
use kartik\export\ExportMenu;
use kartik\grid\GridView as GridView;
use yii\data\ActiveDataProvider;
use frontend\modules\mat\models\MatVwStock;
/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\logi\models\StockSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('logi.labels', 'Stocks');
$this->params['breadcrumbs'][] = $this->title;
$formato=h::formato();
?>
<div class="stock-index">

    <h4><?= Html::encode($this->title) ?></h4>
    <div class="box box-success">
     <div class="box-body">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

   
    <?php Pjax::begin(['id'=>'stock-index']); ?>
    <div style='overflow:auto;'>
    <?php 
    $dataProvider=New ActiveDataProvider([
        'query'=> MatVwStock::find()->andWhere(['codart'=>$codart])
    ]);
    
    echo  GridView::widget([
        'dataProvider' => $dataProvider,
         'summary' => '',
         'tableOptions'=>['class'=>'table table-condensed table-hover table-bordered table-striped'],
       // 'filterModel' => $searchModel,
        'columns' => [
            
         
         /*[
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}{view}',
                'buttons' => [
                    'update' => function($url, $model) {                        
                        $options = [
                            'title' => Yii::t('base.verbs', 'Update'),                            
                        ];
                        return Html::a('<span class="btn btn-info btn-sm glyphicon glyphicon-pencil"></span>', $url, $options);
                         },
                          'view' => function($url, $model) {                        
                        $options = [
                            'title' => Yii::t('base.verbs', 'View'),                            
                        ];
                        return Html::a('<span class="btn btn-warning btn-sm glyphicon glyphicon-search"></span>', $url, $options);
                         },
                         'delete' => function($url, $model) {                        
                        $options = [
                            'data-confirm' => Yii::t('rbac-admin', 'Are you sure you want to activate this user?'),
                            'title' => Yii::t('base.verbs', 'Delete'),                            
                        ];
                        return Html::a('<span class="btn btn-danger btn-sm glyphicon glyphicon-remove"></span>', $url, $options);
                         }
                    ]
                ],*/
        
        
         
         
              
            
            ['attribute'=>'codart',
                //'headerOptions' => ['style' => 'width:20%'],
                  'value'=>function ($model){
                    return $model->codart;
                  }
                ],
            /*['attribute'=>'descripcion',
                'headerOptions' => ['style' => 'width:50%'],
                  'value'=>function ($model){
                    return $model->descripcion;
                  }
                ],*/
             [
                    'attribute' => 'material',
                 'headerOptions' => ['style' => 'width:50%'],
                    'value' => 'material.descripcion',
            ],
         ['attribute'=>'codal',
               // 'headerOptions' => ['style' => 'width:50%'],
                'filter'=> frontend\modules\mat\helpers\comboHelper::getCboAlmacenes(),
                  'value'=>function ($model){
                    return $model->codal;
                  }
                ],
            'um',
           
          ['attribute'=>'cant',
               // 'headerOptions' => ['style' => 'width:50%'],
                 'contentOptions'=>['style' => 'font-weight:800;color:#283E6A;text-align:right;'],
                //'filter'=> frontend\modules\mat\helpers\ComboHelper::getCboAlmacenes(),
                  'value'=>function ($model) use($formato){
                    return ($model->cant==0 or is_null($model->cant))?'':$formato->asDecimal($model->cant,2);
                    
                  }
                ],
          ['attribute'=>'cant_disp',
               // 'headerOptions' => ['style' => 'width:50%'],
                 'contentOptions'=>['style' => 'font-weight:800;color:#096A1A;text-align:right;'],
               // 'filter'=> frontend\modules\mat\helpers\ComboHelper::getCboAlmacenes(),
                  'value'=>function ($model) use($formato){
                    return ($model->cant_disp==0 or is_null($model->cant_disp))?'':$formato->asDecimal($model->cant_disp,2);
                    
                  }
                ],
          
          
          ['attribute'=>'cantres',
               // 'headerOptions' => ['style' => 'width:50%'],
                 'contentOptions'=>['style' => 'font-weight:800;color:#FC9C33;text-align:right;'],
               // 'filter'=> frontend\modules\mat\helpers\ComboHelper::getCboAlmacenes(),
                  'value'=>function ($model) use($formato){
                    return ($model->cantres==0 or is_null($model->cantres))?'':$formato->asDecimal($model->cantres,2);
                    
                  }
                ],
            ['attribute'=>'valor',
               // 'headerOptions' => ['style' => 'width:50%'],
                 'contentOptions'=>['style' => 'font-weight:800;color:#000;text-align:right;'],
               // 'filter'=> frontend\modules\mat\helpers\ComboHelper::getCboAlmacenes(),
                  'value'=>function ($model) use($formato){
                    return ($model->valor==0 or is_null($model->valor))?'':$formato->asDecimal($model->valor,2);
                    
                  }
                ],           
            'valor_unit',
           
            //'ubicacion',
            //'cantres',
            //'codal',
            //'valor',
            //'lastmov',
            //'pventa',
            //'ceconomica',
            //'creorden',
            //'cminima',
            //'clas_abc',

          
        ],
    ]); ?>
</div>
     <?php Pjax::end(); ?>
    </div>
</div>
    </div>
       