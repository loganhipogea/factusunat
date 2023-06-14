<?php
    use yii\helpers\Url;
    use yii\widgets\Pjax;
    use yii\helpers\Html;
    use yii\grid\GridView;
      $url= Url::to(['mod-agrega-os','id'=>$model->id,'gridName'=>'grilla-os','idModal'=>'buscarvalor']);
   echo  Html::button(yii::t('base.verbs','Agregar orden'), 
           ['href' => $url, 'title' => yii::t('base.names','Agregar Os'),
               'id'=>'btn_costos_edi',
               'class' => 'botonAbre btn btn-success'
               ]); 
  
 
?>     

<div class="box-body">
    <?php Pjax::begin(['id'=>'pjax_costeo']); ?>   
    <div style='overflow:auto;'>
        
    <?php 
    $dataProvider=New \yii\data\ActiveDataProvider([
        'query'=> frontend\modules\cc\models\CcCostos::find()->
           andWhere([
               'codocuref'=>$model->codocu(),
                'iddocuref'=>$model->id,
               
           ]), 
        
    ]);
    ?>   
        
    <?= GridView::widget([
        'id'=>'grilla-os-costos',
        'dataProvider' => $dataProvider,
         'summary' => '',
         'tableOptions'=>['class'=>'table table-condensed table-hover table-bordered table-striped'],
        //'filterModel' => New \frontend\modules\op\models\OpOsSearch(),
        'columns' => [ 
         ['attribute' => 'fecha',
                'contentOptions'=>['style'=>'width:80px;'],
                //'format'=>'raw',
                'value'=>function($model){
                        return $model->fecha;
                             } 
                
                ],         
            ['attribute' => 'codocu',
                //'format'=>'raw',
                'value'=>function($model){
                        return $model->documento->desdocu;                        
                             }                 
                ],
            ['attribute' => 'numdoc',
                //'format'=>'raw',
                'value'=>function($model){
                        return $model->numdoc;                        
                             }                 
                ],
              'tipo',
            ['attribute' => 'monto',
                //'format'=>'raw',
                'value'=>function($model){
                        return $model->monto;                        
                             }                 
                ],
           
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
    </div>
