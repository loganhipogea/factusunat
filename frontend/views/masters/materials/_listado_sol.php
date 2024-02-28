<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use kartik\export\ExportMenu;
use common\widgets\linkajaxgridwidget\linkAjaxGridWidget;
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
                ['attribute' => 'proyecto',
                // 'filter'=>$valores,
                //'headerOptions' => ['style' => 'width:10%'],
                'format'=>'raw',
                'value'=>function($model){                            
                            return $model->proyecto;
                            }                
                ],  
              'fecha_cre' ,        
           ['attribute' => 'user_name',
                // 'filter'=>$valores,
               // 'headerOptions' => ['style' => 'width:10%'],
                //'format'=>'raw',
                'value'=>function($model){                            
                            return $model->user_name;
                            }                
                ],
                 [
                    'class' => 'yii\grid\ActionColumn',
                     //'template' => Helper::filterActionColumn(['view', 'activate', 'delete']),
                     'headerOptions' => ['style' => 'width:10%'],
                    'template' => '{edit}{delete}{plus}',
                    'buttons' => [
                    
                                
                                'edit' => function ($url,$model)   {
			    $url= Url::to(['masters/materials/modal-edita-material-sol','id'=>$model->codart,'gridName'=>'grilla-materiales','idModal'=>'buscarvalor']);
                              
                            return \yii\helpers\Html::a('<span class="btn btn-success glyphicon glyphicon-pencil"></span>', $url, ['data-pjax'=>'0','class'=>'botonAbre']);
                            },
                        'delete' => function ($url,$model) {                             
                                $url = \yii\helpers\Url::to([$this->context->id.'/ajax-anula-material-solicitado','id'=>$model->id]);
                                return ($model->subido || !$model->activo)?'':\yii\helpers\Html::a('<span class="btn btn-danger glyphicon glyphicon-trash"></span>', '#', ['rel'=>$url,/*'id'=>$model->codparam,*/'family'=>'holas','id'=>\yii\helpers\Json::encode(['id'=>$model->id,'modelito'=> str_replace('@','\\',get_class($model))]),/*'title' => 'Borrar'*/]);
                             },
                        'plus' => function ($url,$model) {                             
                                $url = \yii\helpers\Url::to([$this->context->id.'/ajax-crea-material-solicitado','id'=>$model->id]);
                                return \yii\helpers\Html::a('<span class="btn btn-danger glyphicon glyphicon-plus"></span>', '#', ['rel'=>$url,'family'=>'holas','id'=>\yii\helpers\Json::encode(['id'=>$model->id,])]);
                             },
                            ]
                    ],
                 [
                    'class' => 'common\components\columnGridAudit',
                    
                    ],
        ];

  ?> 
       <?php Pjax::begin(['id'=>'grilla-materiales']); ?>
        
            <div class="btn-group">
                 <?php //echo Html::a(Yii::t('base.verbs', 'Create').' '.Yii::t('base.names', 'Material'), ['create'], ['class' => 'btn btn-success']) ?>
     
     <?=ExportMenu::widget([
    'dataProvider' => $dataProvider,
          
    'columns' => $gridColumns,
    'dropdownOptions' => [
        'label' => yii::t('base.names','Exportar'),
        'class' => 'btn btn-success'
    ]
]) . "<br><hr>\n".GridView::widget([
        'dataProvider' => $dataProvider,
      
    
         'tableOptions'=>['class'=>'table table-condensed table-hover table-bordered table-striped'],
        'filterModel' => $searchModel,
        'columns' => $gridColumns,
    ]); ?>
    
   <?php 
    echo linkAjaxGridWidget::widget([
           'id'=>'widgetgrutrtitetdBancos',
        'otherContainers'=>[],
            'idGrilla'=>'grilla-materiales',
            'family'=>'holas',
          'type'=>'POST',
           'evento'=>'click',
        'posicion'=>\yii\web\View::POS_END
       
            //'foreignskeys'=>[1,2,3],
        ]);
    ?>   
    <?php Pjax::end(); ?>
  </div>
</div>
