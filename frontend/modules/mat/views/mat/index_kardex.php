<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
use kartik\export\ExportMenu;

/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\mat\models\MatReqSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Kardex');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mat-req-index">

    <h4><?= Html::encode($this->title) ?></h4>
    <div class="box box-success">
     <div class="box-body">
    <?php Pjax::begin(); ?>
    <?php  echo $this->render('_kardex_search', ['model' => $searchModel]); ?>

    <?php  echo '.';  ?>
    <div style='overflow:auto;'>
    <?php  echo ExportMenu::widget([
    'dataProvider' => $dataProvider,    
   
    'dropdownOptions' => [
        'label' => yii::t('base.names','Exportar'),
        'class' => 'btn btn-primary'
    ]
]).''. GridView::widget([
        'dataProvider' => $dataProvider,
         //'summary' => '',
         'tableOptions'=>['class'=>'table table-condensed table-hover table-bordered table-striped'],
       // 'filterModel' => $searchModel,
        'columns' => [
            
         
         [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{xupdate}',
                'buttons' => [
                    'update' => function($url,$model) {   
                       
                        $options = [
                            'title' => Yii::t('base.verbs', 'Update'),                            
                        ];
                        $url= \yii\helpers\Url::to(['/mat/mat/update','id'=>$model->id]);
                        return Html::a('<span class="btn btn-info btn-sm glyphicon glyphicon-pencil"></span>', $url, $options/*$options*/);
                         },
                        
                    ]
                ],
         
         
          ['attribute'=>'signo',
               // 'headerOptions' => ['style' => 'width:50%'],
                 //'contentOptions'=>['style' => 'font-weight:800;color:#FC9C33;text-align:right;'],
               // 'filter'=> frontend\modules\mat\helpers\ComboHelper::getCboAlmacenes(),
                  'format'=>'html',
                 'value'=>function ($model){
                        $dire=($model->signo>0)?'down':'up';
                        $color=($model->signo>0)?'#EC5B2C':'#8FC223';
                    return '<i style="color:'.$color.';"><span class="fa fa-arrow-'.$dire.'"></span></i>';
                    
                  }
                ],
         
        
            
           // 'numero',
            // 'item',
           ['attribute'=>'codart',
               
              'format'=>'html',
                 'contentOptions'=>['style' => 'font-weight:800;color:#283E6A;text-align:right;'],
                //'filter'=> frontend\modules\mat\helpers\ComboHelper::getCboAlmacenes(),
                  'value'=>function ($model) {
                    return $model->codart;                    
                  }
                ],
            ['attribute'=>'cant',
                'headerOptions' => ['style' => 'width:20%'],
              'format'=>'html',
                 'contentOptions'=>['style' => 'font-weight:800;color:#283E6A;text-align:right;'],
                //'filter'=> frontend\modules\mat\helpers\ComboHelper::getCboAlmacenes(),
                  'value'=>function ($model) {
                    return $model->cant;                    
                  }
                ],
              ['attribute'=>'descripcion',
                'headerOptions' => ['style' => 'width:20%'],
              'format'=>'html',
                 'contentOptions'=>['style' => 'color:#283E6A;'],
                //'filter'=> frontend\modules\mat\helpers\ComboHelper::getCboAlmacenes(),
                  'value'=>function ($model) {
                    return $model->descripcion;                    
                  }
                ],
           
            'um',
            //'descripcion',
            'codal',
            'fecha',
             ['attribute'=>'descritransa',
                'headerOptions' => ['style' => 'width:20%'],
                 'format'=>'html',
                 //'contentOptions'=>['style' => 'font-weight:800;color:#283E6A;text-align:right;'],
                //'filter'=> frontend\modules\mat\helpers\ComboHelper::getCboAlmacenes(),
                  'value'=>function ($model) {
                    return Html::a($model->descritransa,Url::to(['/mat/mat/update-vale','id'=>$model->vale_id]),[]);                    
                  }
                ],
             'desdocu',
            'numerodoc',
             'despro'
            //'descripcion',
            //'texto:ntext',
            //'codest',

          
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
    </div>
</div>
    </div>
       