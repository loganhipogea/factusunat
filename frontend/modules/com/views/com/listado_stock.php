<?php

use yii\helpers\Html;
use yii\grid\GridView;
USE yii\widgets\Pjax;
use frontend\modules\logi\models\LogiVwStock;

?>


    <?php Pjax::begin(['id'=>'stock-index']); ?>
    <div style='overflow:auto;'>
    <?= GridView::widget([
        'dataProvider' =>new \yii\data\ActiveDataProvider([
                'query'=> LogiVwStock::find()->andWhere(['like','descripcion',$parametro])->limit(5),
                ]),
         'summary' => '',
         'tableOptions'=>['class'=>'table table-condensed table-hover table-bordered table-striped'],
       'columns' => [
            
         
        // [
                //'class' => 'yii\grid\ActionColumn',
               // 'template' => '{update}{view}',
               /* 'buttons' => [
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
                    ]*/
               // ],
         
         
         
         
         

            
            'codart',
            ['attribute'=>'descripcion',
                 'contentOptions' => ['style' => 'width:80px;'],
               // 'headerOptions' => ['style' => 'width:30%'],
                  'value'=>function ($model){
                    return $model->descripcion;
                  }
                ],
            ['attribute'=>'cant',
                'header'=>'Stock',
                  'contentOptions' => ['style' => 'width:10px;'],
               // 'headerOptions' => ['style' => 'width:30%'],
                  'value'=>function ($model){
                    return $model->cant;
                  }
                ], 
           
            
            'um',                      
            'pventa'
           
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
       