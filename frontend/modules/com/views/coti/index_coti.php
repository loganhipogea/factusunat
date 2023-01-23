<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\helpers\h;
/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\com\models\ComCotizacionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Ofertas');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="com-cotizacion-index">

    <h4><?=h::awe('files-o')?><?= Html::encode($this->title) ?></h4>
    <div class="box box-success">
     <div class="box-body">
    <?php 
    Pjax::begin();
    $formato=h::formato();
    ?>
    <?php  echo $this->render('_search_coti', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Crear oferta'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <div style='overflow:auto;'>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
         'summary' => '',
         'tableOptions'=>['class'=>'table table-condensed table-hover table-bordered table-striped'],
       
        'columns' => [
            
         
         [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}{delete}{view}',
                'buttons' => [
                    'update' => function($url, $model) {                        
                        $options = [
                            'title' => Yii::t('base.verbs', 'Update'),                            
                        ];
                        $url=Url::to(['update-coti','id'=>$model->id]);
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
         
         'numero',
         'descripcion',
             ['attribute'=>'codcli',
                 'value'=>function($model)use($formato){
                   return $model->cliente1->despro;     
                 }
                 ],
         'codmon',
         ['attribute'=>'codcli',
                 'value'=>function($model)use($formato){
                   return $formato->asDecimal($model->monto,2);  
                   
                   
                 }
                 ], 
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
    </div>
</div>
    </div>
       