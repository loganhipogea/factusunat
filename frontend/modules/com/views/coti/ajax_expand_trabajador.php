<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\Json;
use common\helpers\h;
use yii\grid\GridView as grid;
use common\models\masters\Tipocambio;
/* @var $model frontend\modules\com\models\ComCotizacion */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="com-cotizacion-form">
   
          
  <?php   
 
   
   $gridColumns=[       
           
        [
            'attribute' => 'descricargo',
            'format'=>'raw',
            'value'=>function($model){
                return $model->codcargo;
            }
           
         ],
        [
            'attribute' => 'hh',
            'format'=>'raw',
            'value'=>function($model){
                return $model->hh.'('.Tipocambio::COD_MONEDA_BASE.')';
            }
           
         ],
      
       
        
   ];
   \yii\widgets\Pjax::begin(['id'=>'grilla-detalle-activos'.$model->id]);
   echo '.'.grid::widget([
    'dataProvider'=>New \yii\data\ActiveDataProvider([
        'query'=> common\models\masters\Cargos::find()
            ->select('t.*')->alias('t')->
            andWhere([
                'codcargo'=>$model->codcargo,                
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
