<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use kartik\export\ExportMenu;
use common\helpers\h;
/* @var $this yii\web\View */
/* @var $searchModel common\models\masters\MaestrocompoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('base.names', 'Materials');
$this->params['breadcrumbs'][] = $this->title;
?>





   <h4><?=h::awe('dropbox')?><?= Html::encode($this->title) ?></h4>
  
    <div class="box">
       <?php  
       
  $gridColumns= [
          
           
            'codart',
              ['attribute' => 'subido',
                // 'filter'=>$valores,
                'headerOptions' => ['style' => 'width:5%'],
                'format'=>'raw',
                'value'=>function($model){ 
                             
                            return ($model->subido)?"<i style='color:#a7da19;font-size:1.5em;'><span class='fa fa-arrow-up'></span></i> ":"<i style='color:orange;font-size:1.5em;'><span class='fa fa-circle'></span></i>  ";
                            }                
                ],  
             ['attribute' => 'descripcion',
                'headerOptions' => ['style' => 'width:40%'],
                'format'=>'raw',
                'value'=>function($model){                            
                            return $model->descripcion;
                            }                
                ],
            
             ['attribute' => 'descrimanual',
                // 'filter'=>$valores,
                'headerOptions' => ['style' => 'width:10%'],
                'format'=>'raw',
                'value'=>function($model){                            
                            return $model->descrimanual;
                            }                
                ],  
              'fecha_cre' ,        
           
                 [
                    'class' => 'yii\grid\ActionColumn',
                     //'template' => Helper::filterActionColumn(['view', 'activate', 'delete']),
                     'headerOptions' => ['style' => 'width:10%'],
                    'template' => '{edit}{delete}',
                    'buttons' => [ 
                                'edit' => function ($url,$model)   {
			    $url= Url::to(['masters/materials/modal-edita-material-sol','id'=>$model->codart,'gridName'=>'grilla-materiales-rec','idModal'=>'buscarvalor']);
                            return \yii\helpers\Html::a('<span class="btn btn-success glyphicon glyphicon-pencil"></span>', $url, ['data-pjax'=>'0','class'=>'botonAbre']);
                            },
                            ]
                    ],
        ];

  ?> 
       <?php Pjax::begin(['id'=>'grilla-materiales-rec']); ?>
        
            <div class="btn-group">
                 <?php //echo Html::a(Yii::t('base.verbs', 'Create').' '.Yii::t('base.names', 'Material'), ['create'], ['class' => 'btn btn-success']) ?>
     
     <?php 
     $dataProvider= New \yii\data\ActiveDataProvider([
                                    'query'=> common\models\masters\MaestrocompoSol::find()->
                                            select(['codart','descripcion','descrimanual','fecha_cre','subido'])->
                                            limit(10)->orderBy(['fecha_cre'=>SORT_DESC])
                                           ,
                                     'pagination'=>false
                                        ]);
     
     echo ExportMenu::widget([
    'dataProvider' => $dataProvider,
               
          
    'columns' => $gridColumns,
    'dropdownOptions' => [
        'label' => yii::t('base.names','Exportar'),
        'class' => 'btn btn-success'
    ]
]) . "<br><hr>\n".GridView::widget([
        'dataProvider' => $dataProvider,
      
    
         'tableOptions'=>['class'=>'table table-condensed table-hover table-bordered table-striped'],
        //'filterModel' => $searchModel,
        'columns' => $gridColumns,
    ]); ?>
    
   
    <?php Pjax::end(); ?>
  </div>
</div>
