<?php
  use yii\helpers\Url;
 use yii\widgets\Pjax;
 use yii\helpers\Html;
use yii\grid\GridView;
?>
<div class="btn-group"> 
<?php
      $url= Url::to(['mod-agrega-os','id'=>$model->id,'gridName'=>'grilla-os','idModal'=>'buscarvalor']);
      echo Html::a('<span class="fa fa-plus-circle" ></span>'.Yii::t('app', 'Orden interna'),
              $url,['class'=>"botonAbre btn btn-danger"]
              );
                   
      
   $url= Url::to(['mod-agrega-os','id'=>$model->id,'gridName'=>'grilla-os','idModal'=>'buscarvalor','ext'=>'1']);
  echo Html::a('<span class="fa fa-plus-circle" ></span>'.Yii::t('app', 'Orden externa'),
              $url,['class'=>"botonAbre btn btn-warning"]
              );
 
?>     
</div>
<div class="box-body">
    <?php Pjax::begin(); ?>   
    <div style='overflow:auto;'>
    <?= GridView::widget([
        'id'=>'grilla-os',
        'dataProvider' => $dataProviderOs,
         'summary' => '',
         'tableOptions'=>['class'=>'table table-condensed table-hover table-bordered table-striped'],
        'filterModel' => New \frontend\modules\op\models\OpOsSearch(),
        'columns' => [ 
         ['attribute' => 'numero',
                'contentOptions'=>['style'=>'width:80px;'],
                'format'=>'raw',
                'value'=>function($model){
                        return Html::a($model->numero, Url::to(['edita-os','id'=>$model->id]),['target'=>'_blank']);                        
                             } 
                
                ],         
            ['attribute' => 'descripcion',
                //'format'=>'raw',
                'value'=>function($model){
                        return $model->descripcion;                        
                             }                 
                ],
            'fechaprog',
            //'fechaini',           
            ['attribute' => 'Ejecuta',
                'format'=>'raw',
                'value'=>function($model){
                        return substr($model->cliente->despro,0,20);                        
                             }                 
                ], 
           
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
    </div>
