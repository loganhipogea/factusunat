<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use kartik\export\ExportMenu;
use common\widgets\linkajaxgridwidget\linkAjaxGridWidget;
  USE common\helpers\FileHelper as Fl;
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
        $ext= json_encode(Fl::extImages());
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
                    
                        if($model->activo){
                            return $model->descripcion;
                        } else{
                           return '<span class="tachado">'.$model->descripcion.'</span>';
                            } 
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
                    'template' => '{edit}{delete}{attach}',
                    'buttons' => [ 
                                'edit' => function ($url,$model)   {
			    $url= Url::to(['masters/materials/modal-edita-material-sol','id'=>$model->codart,'gridName'=>'grilla-materiales-rec','idModal'=>'buscarvalor']);
                            return \yii\helpers\Html::a('<span class="btn btn-success glyphicon glyphicon-pencil"></span>', $url, ['data-pjax'=>'0','class'=>'botonAbre']);
                            },
                               'delete' => function ($url,$model) {                             
                                $url = \yii\helpers\Url::to([$this->context->id.'/ajax-anula-material-solicitado','id'=>$model->id]);
                                return ($model->subido)?'':\yii\helpers\Html::a('<span class="btn btn-danger glyphicon glyphicon-trash"></span>', '#', ['rel'=>$url,/*'id'=>$model->codparam,*/'family'=>'holas','id'=>\yii\helpers\Json::encode(['id'=>$model->id,'modelito'=> str_replace('@','\\',get_class($model))]),/*'title' => 'Borrar'*/]);
                             },
                             'attach' => function($url, $model) use($ext) {  
                          $url=\yii\helpers\Url::toRoute(['/finder/selectimage','isImage'=>true,
                             'idModal'=>'imagemodal',
                             'extension'=>$ext,
                             'grillas'=>'grilla-materiales-rec',
                             'modelid'=>$model->id,
                             'nombreclase'=> str_replace('\\','_',get_class($model))]);
                       
                             return Html::button('<span class="glyphicon glyphicon-paperclip"></span>', ['href' => $url, 'title' => 'Editar Adjunto', 'class' => 'botonAbre btn btn-info']);
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
                                            select(['id','codart','descripcion','descrimanual','fecha_cre','subido','proyecto','activo','user_name'])->
                                            limit(50)->orderBy(['fecha_cre'=>SORT_DESC])
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
    
    <?php 
    echo linkAjaxGridWidget::widget([
           'id'=>'widgetgrutrtidBancos',
        'otherContainers'=>[],
            'idGrilla'=>'grilla-materiales-rec',
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
