<?php
use yii\helpers\Url;
use yii\helpers\Html;
//use yii\grid\GridView;
USE yii\widgets\Pjax;
use common\helpers\h;
use kartik\export\ExportMenu;
use kartik\grid\GridView as GridView;
/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\logi\models\StockSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


?>
<div class="stock-index">

    
    <div class="box box-success">
     <div class="box-body">
    
     <?php 
     $options=['class'=>'botonAbre','data-pjax'=>'0'];
      $url= Url::to(['site/modal-crear-columna','id'=>$model->id,'gridName'=>'columna-index','idModal'=>'buscarvalor']);
      $boton= Html::a('<span class="glyphicon glyphicon-pencil btn btn-danger"></span>', $url, $options);
     ?>
       
   
    <?php Pjax::begin(['id'=>'columna-index']); ?>
    <div style='overflow:auto;'>
    <?php 
    $dataprovider=New yii\data\ActiveDataProvider([
            'query'=>frontend\models\AitColumnas::find()->andWhere([
                'contenido_id'=>$model->id
            ])
            ]) ;
    echo $boton.ExportMenu::widget([
    'dataProvider' =>$dataprovider,    
   
    'dropdownOptions' => [
        'label' => yii::t('base.names','Exportar'),
        'class' => 'btn btn-primary'
    ]
]).''. GridView::widget([
        'dataProvider' => $dataprovider,
         'summary' => '',
         'tableOptions'=>['class'=>'table table-condensed table-hover table-bordered table-striped'],
        //'filterModel' => $searchModel,
        'columns' => [
            
      [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{edit}{attach}',
                'buttons' => [
                    
                       'edit' => function ($url,$model) {
                             
                             $options=['class'=>'botonAbre','data-pjax'=>'0'];
			    $url= Url::to(['site/modal-editar-columna','id'=>$model->id,'gridName'=>'columna-index','idModal'=>'buscarvalor']);
                              return \yii\helpers\Html::a('<span class="glyphicon glyphicon-pencil btn btn-danger"></span>', $url, $options);
                            },          
                         'attach' => function($url, $model) {  
                         $url=\yii\helpers\Url::toRoute(['/finder/selectimage','idModal'=>'imagemodal',
                             'extension'=> \yii\helpers\Json::encode(array_merge(common\helpers\FileHelper::extImages())) ,
                             'modelid'=>$model->id,'nombreclase'=> str_replace('\\','_',get_class($model))]);
                        $options = [
                            'title' => Yii::t('base.names', 'Colocar en el maletín'),
                            //'aria-label' => Yii::t('rbac-admin', 'Activate'),
                            //'data-confirm' => Yii::t('rbac-admin', 'Are you sure you want to activate this user?'),
                            'data-method' => 'get',
                            //'data-pjax' => '0',
                        ];
                        return Html::button('<span class="glyphicon glyphicon-paperclip"></span>', ['href' => $url, 'title' => 'Editar Adjunto', 'class' => 'botonAbre btn btn-success']);
                        //return Html::a('<span class="btn btn-success glyphicon glyphicon-pencil"></span>', Url::toRoute(['view-profile','iduser'=>$model->id]), []/*$options*/);
                     
                        
                        },        
                          
                    ],
                     
                ],
        
         /*[
                'class' => 'kartik\grid\ExpandRowColumn',
                'width' => '50px',
                 'expandIcon'=>'<i style="color:#F86E35"><span class="fa fa-plus-square-o"></span></i>',
                 'collapseIcon'=>'<i style="color:#F60101"><span class="fa fa-minus-square-o"></span></i>',
                
             
             
             'value' => function ($model, $key, $index, $column) {
                            return GridView::ROW_COLLAPSED;
                                },
                 'detail'=> function($model)  {          
                                        
                          return  $this->render('_expand_kardex',[
                               'model'=>$model,
                               'key'=>$key,
                           ]);
                            },
                    'detailUrl' =>Url::toRoute(['/mat/mat/ajax-show-kardex']),
                    'headerOptions' => ['class' => 'kartik-sheet-style'], 
                    'expandOneOnly' => true
                ],*/
         
         
             
            
            ['attribute'=>'titulo',
                //'headerOptions' => ['style' => 'width:20%'],
                  'value'=>function ($model){
                    return $model->titulo;
                  }
                ],
           
         ['attribute'=>'leyenda',
                //'headerOptions' => ['style' => 'width:20%'],
                  'value'=>function ($model){
                    return $model->leyenda;
                  }
                ],
         ['attribute'=>'Imagen',
               'format'=>'html',
                //'headerOptions' => ['style' => 'width:20%'],
                  'value'=>function ($model){
                    if($model->hasAttachments()){
                        return Html::img($model->files[0]->url,['width'=>100,'height'=>100]);
                    }
                    
                  }
                ],
        ],
    ]); ?>
</div>
     <?php Pjax::end(); ?>
    </div>
</div>
    </div>
       