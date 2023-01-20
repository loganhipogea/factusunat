<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\Json;
use common\helpers\h;
use frontend\modules\mat\models\MatVwPetoferta;
use yii\grid\GridView as grid; 
use frontend\modules\mat\models\MatVwActivoceco;
/* @var $model frontend\modules\com\models\ComCotizacion */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="com-cotizacion-form">
   
          
  <?php   
 
   
   $gridColumns=[       
           
        [
            'attribute' => 'codactivo',
            'format'=>'raw',
            'value'=>function($model){
                return $model->codactivo;
            }
           
         ],
        [
            'attribute' => 'descriceco',
            'format'=>'raw',
            'value'=>function($model){
                return $model->descriceco;
            }
           
         ],
      [
            'attribute' => 'valor',
            'format'=>'raw',
            'value'=>function($model){
                return $model->valor;
            }
           
         ],
       [
            'attribute' => 'codmon',
            'format'=>'raw',
            'value'=>function($model){
                return $model->codmon;
            }
           
         ],
              
        
   ];
   \yii\widgets\Pjax::begin(['id'=>'grilla-detalle-activos'.$model->id]);
   echo '.'.grid::widget([
    'dataProvider'=>New \yii\data\ActiveDataProvider([
        'query'=> MatVwActivoceco::find()
            ->select('t.*')->alias('t')->
            andWhere([
                'codactivo'=>$model->codactivo,                
                    ])
            ,
    ]),
   // 'filterModel' => $searchModel,
        'summary' => '',
        'columns' => $gridColumns,
    //'responsive'=>true,
    //'hover'=>true
       ]);
    \yii\widgets\Pjax::end();
   ?> 
 <div class="btn-group">
      
          
          
          

</div>
    </div>
