<?php
use yii\helpers\Url;
use yii\grid\GridView;
use yii\helpers\Html;
//use kartik\grid\GridView as grid;
use kartik\grid\GridView as grid;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use kartik\tabs\TabsX;
use yii\web\View;
use common\models\masters\Clipro;
use  frontend\modules\sunat\models\SunatSends;
//use common\models\masters\Direcciones;
use common\widgets\linkajaxgridwidget\linkAjaxGridWidget;

/* @var $this yii\web\View */
/* @var $model common\models\masters\Clipro */
/* @var $form yii\widgets\ActiveForm */
$zonaAjax='pjax-sends-grilla'
?>
 
  
    <?php Pjax::begin(['id'=>$zonaAjax]); ?>
   
   <?php 
   $gridColumns=[
       
            [
                    
                'class' => 'yii\grid\ActionColumn',
                //'template' => Helper::filterActionColumn(['view', 'activate', 'delete']),
            'template' => '',
               
                ],
        [
                'class' => 'kartik\grid\ExpandRowColumn',
                'width' => '50px',
                'value' => function ($model, $key, $index, $column) {
                            return grid::ROW_COLLAPSED;
                                },
                 /*'detail'=> function($model)  {  
                          return  $this->render('_expand_sucursal',[
                               'model'=>$model,
                               //'key'=>$key,
                           ]);
                            },*/
                     'detailUrl' =>Url::toRoute(['/sunat/default/ajax-expand-send']),
                    //'headerOptions' => ['class' => 'kartik-sheet-style'], 
                    'expandOneOnly' => true
                ],
         [
            //'class' => 'kartik\grid\EditableColumn',
            'attribute' => 'tipo',
            'format'=>'raw',
             'value'=>function($model){
                 return $model->comboValueText('tipo');                
                }
         ],  
         [
            //'class' => 'kartik\grid\EditableColumn',
            'attribute' => 'resultado',
            'format'=>'raw',
             'value'=>function($model){
                    if($model->resultado){
                        return '<i style="color:#40ab34;font-size:1.5em;"><span class="glyphicon glyphicon-ok"></span></i>';
                    } else{
                        return  '<i style="color:#f52d2d;font-size:1.5em;"><span class="glyphicon glyphicon-remove"></span></i>'; 
                    }               
             }
           /* 'pageSummary' => 'Total',
            'vAlign' => 'middle',
            'width' => '210px',*/
            
         ], 
                          
           [
            //'class' => 'kartik\grid\EditableColumn',
            'attribute' => 'ticket',
           /* 'pageSummary' => 'Total',
            'vAlign' => 'middle',
            'width' => '210px',*/
            
         ], 
        [
            //'class' => 'kartik\grid\EditableColumn',
            'attribute' => 'username',
           /* 'pageSummary' => 'Total',
            'vAlign' => 'middle',
            'width' => '210px',*/
            
         ],  
          
         [
            //'class' => 'kartik\grid\EditableColumn',
            'attribute' => 'cuando',
           /* 'pageSummary' => 'Total',
            'vAlign' => 'middle',
            'width' => '210px',*/
            
         ],  
         
       
   ];
   echo grid::widget([
    'dataProvider'=> new \yii\data\ActiveDataProvider([
            'query'=> SunatSends::find()->andWhere([
                'doc_id'=>$model->id,
                'tipodoc'=>$model->sunat_tipodoc,
                ])->orderBy(['cuando'=>SORT_DESC]),
            ]
            ),
   // 'filterModel' => $searchModel,
       'summary' => '',
    'columns' => $gridColumns,
    'responsive'=>true,
    'hover'=>true
       ]);
   ?> 
   
<?php 
   
    ?>



    <?php Pjax::end(); ?>    

   