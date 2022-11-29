<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\data\ActiveDataProvider;
use common\helpers\h;

?>
<div class="mat-petoferta-detalle">
 
  <?php
  $formato=h::formato();
  $formato->thousandSeparator=',';
  ?>
    <?php Pjax::begin(); ?>
   

    
    <div style='overflow:auto;'>
    <?= GridView::widget([
        'dataProvider' => new ActiveDataProvider([
            'query'=> frontend\modules\mat\models\MatDetpetoferta::find()->andWhere(['petoferta_id'=>$model->id])
        ]),
        // 'summary' => '',
         'tableOptions'=>['class'=>'table table-condensed table-hover table-bordered table-striped'],
        //'filterModel' => $searchModel,
        'columns' => [
            
         
         [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}{delete}',
                'buttons' => [
                    'update' => function($url, $model) {                        
                        $options = [
                            'title' => Yii::t('base.verbs', 'Update'),                            
                        ];
                        return Html::a('<span class="btn btn-info btn-sm glyphicon glyphicon-pencil"></span>', $url, $options/*$options*/);
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
         
         
         
         
         

           
            'item',
            'codart',
            'codum',
            [  
                'attribute' => 'cant', 
                     'headerOptions' => [
                        'class' => 'text-right',
                        
                            ],
                 'contentOptions'=>['style'=>'text-align:right; width: 10%; font-weight:900;'],
                 'value'=>function($model)use($formato){
                     return $formato->asDecimal($model->cant, 2);   
                 }
                     
                ], 
            [  
                'attribute' => 'punit', 
                     'headerOptions' => [
                        'class' => 'text-right',
                        
                            ],
                 'contentOptions'=>['style'=>'text-align:right; width: 10%; font-weight:900;'],
                 'value'=>function($model)use($formato){
                     return $formato->asDecimal($model->punit, 2);   
                 },
               
                ],  
             'descripcion',
             [  
                'attribute' => 'pventa', 
                     'headerOptions' => [
                        'class' => 'text-right',
                        
                            ],
                 'contentOptions'=>['style'=>'text-align:right; width: 10%; font-weight:900;'],
                 'value'=>function($model)use($formato){
                     return $formato->asDecimal($model->pventa, 2);   
                 },
                'footer'=>'sds',
                    
             ],
                       
            //'codtra',
            //'user_id',
            //'estado',
            //'descripcion',
            //'detalle:ntext',

          
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
    </div>

       