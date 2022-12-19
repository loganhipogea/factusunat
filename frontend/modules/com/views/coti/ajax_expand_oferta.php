<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\Json;
use yii\widgets\ActiveForm;
use common\helpers\h;
use common\widgets\selectwidget\selectWidget;
use kartik\date\DatePicker;
use frontend\modules\mat\models\MatVwPetoferta;

use yii\grid\GridView as grid; 
/* @var $model frontend\modules\com\models\ComCotizacion */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="com-cotizacion-form">
   
          
  <?php   
 
   
   $gridColumns=[       
           
        [
            'attribute' => 'numero',
            'format'=>'raw',
            'value'=>function($model){
                
              $url=Url::to(['/mat/petoferta/edit-pet-oferta','id'=>$model->id]);
              $options=[
                  'class'=>'btn bnt-success',
                  'data-pjax'=>'0',
                  'target'=>'_blank',
              ];
              return Html::a($model->numero,$url,$options);
            }
           
         ],
        [
            'attribute' => 'despro',
            'format'=>'raw',
            'value'=>function($model){
                
              $url=Url::to(['/mat/petoferta/modal-show-petoferta','id'=>$model->id]);
              $options=[
                  'class'=>'botonAbre',                  
                  'target'=>'_blank',
              ];
              return Html::a($model->despro,$url,$options);
            }
           
         ],
        'fecha',
        'cant',
        'codart',
        'codum',                
       'codmon',
       [
            'attribute' => 'punit',
            'value'=>function($model){
              return $model->punit;
            }
           
         ],  
       
       
        
   ];
   \yii\widgets\Pjax::begin(['id'=>'grilla-detalle-by-cecos']);
   echo '.'.grid::widget([
    'dataProvider'=>New \yii\data\ActiveDataProvider([
        'query'=> MatVwPetoferta::find()
            ->select(['id','cant','numero','fecha','codart','despro','codmon','codum','punit'])->alias('t')->
            andWhere([
                'codart'=>$model->codart,                
                    ])->andWhere([
          '<=',
          'fecha',
          date('Y-m-d')
            ]
              )
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
