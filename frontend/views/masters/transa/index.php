<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\masters\TransaccionesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('base.names', 'Transacciones');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="transacciones-index">

    <h4><?= Html::encode($this->title) ?></h4>
    <div class="box box-success">
     <div class="box-body">
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('base.names', 'Create Transacciones'), ['create'], ['class' => 'btn btn-success']) ?>
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
                'template' => '{update}{delete}{view}',
                'buttons' => [
                    'update' => function($url, $model) {                        
                        $options = [
                            'title' => Yii::t('base.verbs', 'Update'),                            
                        ];
                        $url= \yii\helpers\Url::to(['masters/transa/update','codtrans'=>$model->codtrans]);
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, $options);
                         },
                          'view' => function($url, $model) {                        
                        $options = [
                            'title' => Yii::t('base.verbs', 'View'),                            
                        ];
                        return Html::a('<span class="glyphicon glyphicon-search"></span>', $url, $options);
                         },
                         'delete' => function($url, $model) {                        
                        $options = [
                            'data-confirm' => Yii::t('rbac-admin', 'Are you sure you want to activate this user?'),
                            'title' => Yii::t('base.verbs', 'Delete'),                            
                        ];
                        return Html::a('<span class=" glyphicon glyphicon-remove"></span>', $url, $options);
                         }
                    ]
                ],
         
         
         
         
         

            'codtrans',
            'descripcion',
            'signo',
            'detalles:ntext',

          
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
    </div>
</div>
    </div>
       