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
    <?php echo ExportMenu::widget([
    'dataProvider' => $dataProvider,    
   
    'dropdownOptions' => [
        'label' => yii::t('base.names','Exportar'),
        'class' => 'btn btn-primary'
    ]
]).''. GridView::widget([
        'dataProvider' => $dataProvider,
         'summary' => '',
         'tableOptions'=>['class'=>'table table-condensed table-hover table-bordered table-striped'],
        'filterModel' => $searchModel,
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
        
         [
                'class' => 'kartik\grid\ExpandRowColumn',
                'width' => '50px',
                'value' => function ($model, $key, $index, $column) {
                            return GridView::ROW_COLLAPSED;
                                },
                 'detail'=> function($model)  {          
                                        
                          return  $this->render('_expand_kardex',[
                               'model'=>$model,
                               //'key'=>$key,
                           ]);
                            },
                    // 'detailUrl' =>Url::toRoute(['/mat/mat/ajax-show-kardex']),
                    //'headerOptions' => ['class' => 'kartik-sheet-style'], 
                    'expandOneOnly' => true
                ],
         
         
              ['attribute'=>'semaforo',
                  'format'=>'html',
                  'filter'=> \frontend\modules\mat\models\MatVwStock::listaSemaforo(),
               // 'headerOptions' => ['style' => 'width:50%'],
                  //'filter'=> \common\helpers\ComboHelper::getCboCentros(),
                  'value'=>function ($model){
                    if(is_null($model->semaforo))return '';
                    return '<i style="color:'.$model->colorSemaforo().'"><span class="fa fa-circle"></span></i>';
                  }
                ],
            
            ['attribute'=>'codart',
                'headerOptions' => ['style' => 'width:20%'],
                  'value'=>function ($model){
                    return $model->codart;
                  }
                ],
            ['attribute'=>'descripcion',
                'headerOptions' => ['style' => 'width:30%'],
                  'value'=>function ($model){
                    return $model->descripcion;
                  }
                ],
             
         ['attribute'=>'codal',
               // 'headerOptions' => ['style' => 'width:50%'],
                'filter'=> frontend\modules\mat\helpers\comboHelper::getCboAlmacenes(),
                  'value'=>function ($model){
                    return $model->codal;
                  }
                ],
            'um',
            ['attribute'=>'ubicacion',
               'headerOptions' => ['style' => 'width:20%'],
                 'contentOptions'=>['style' => 'font-weight:800;color:#D35A00;text-align:right;'],
                //'filter'=> frontend\modules\mat\helpers\ComboHelper::getCboAlmacenes(),
                  'value'=>function ($model) use($formato){
                    return $model->ubicacion;
                    
                  }
                ], 
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
       