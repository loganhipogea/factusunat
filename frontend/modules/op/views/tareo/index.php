<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\op\models\OpTareoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Op Tareos');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="op-tareo-index">

    <h4><?= Html::encode($this->title) ?></h4>
    <div class="box box-success">
     <div class="box-body">
    <?php Pjax::begin(); ?>
    <?php  echo $this->render('_search_tareo', ['model' => $searchModel]); ?>

    <p>
       
    </p>
    <div style='overflow:auto;'>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'summary' => '',
         'tableOptions'=>['class'=>'table table-condensed table-hover table-bordered table-striped'],
        //'filterModel' => $searchModel,
        'columns' => [
            
         
         [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}',
                'buttons' => [
                    'update' => function($url, $model) {                        
                        $options = [
                            'title' => Yii::t('base.verbs', 'Update'),                            
                        ];
                        return Html::a('<span class="btn btn-primary btn-sm glyphicon glyphicon-pencil"></span>', $url, $options/*$options*/);
                         },
                          
                    ]
                ],
         
         
         
         
         

           
            'fecha',
            'hinicio',
            [ 'attribute'=>'semana',
               'value'=>function($model){
                      return$model->semana;  
               } 
                
                ],
            'hfin',
            'descripcion',
            //'direcc_id',
            //'proc_id',
            //'os_id',
            //'detos_id',
            //'detalle:ntext',

          
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
    </div>
</div>
    </div>
       