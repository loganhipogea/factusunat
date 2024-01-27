<?php

use yii\helpers\Html;
use common\widgets\linkajaxgridwidget\linkAjaxGridWidget;
USE common\helpers\FileHelper as Fl;
use common\helpers\h;
 use yii\helpers\Url;
use kartik\grid\GridView;
 use yii\widgets\Pjax;


/* @var $this yii\web\View */
/* @var $model frontend\modules\op\models\OpProcesos */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="box-body">
    <br>
   
<?php 
  echo $this->render('_form_os_base',['model'=>$model]);

?>
        
    <?php Pjax::begin(['id'=>'pjax-detserv','timeout'=>false]); ?>
    <?php
      $ext= json_encode(array_merge(Fl::extEngineers(),Fl::extDocs(),Fl::extImages()));
                       
// echo $this->render('_search', ['model' => $searchModel]); ?>

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
    <div style='overflow:auto;'>
    <?= GridView::widget([
        'id'=>'grilla-os',
                'dataProvider' =>new \yii\data\ActiveDataProvider([
                                    'query'=> frontend\modules\op\models\OpOsdet::find()->select(['id',
                                        'item','descripcion','emplazamiento','finicio','termino','codtra',
                                    ])->andWhere(['os_id'=>$model->id])
                                ]),
         'summary' => '',
         'tableOptions'=>['class'=>'table table-condensed table-hover table-bordered table-striped'],
        //'filterModel' => New \frontend\modules\op\models\OpOsSearch(),
        'columns' => [
            
          [
                    
                'class' => 'yii\grid\ActionColumn',
               'contentOptions'=>['style'=>'width:25%;'],
                //'template' => Helper::filterActionColumn(['view', 'activate', 'delete']),
            'template' => '{edit}{delete}{attach}{change}{image}',
               'buttons' => [
                    'attach' => function($url, $model) use($ext) {  
                          $url=\yii\helpers\Url::toRoute(['/finder/selectimage','isImage'=>true,
                             'idModal'=>'imagemodal',
                             'extension'=>$ext,
                             'grillas'=>'pjax-detserv',
                             'modelid'=>$model->id,
                             'nombreclase'=> str_replace('\\','_',get_class($model))]);
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
                                
                       'image' => function($url, $model) {  
                         $url=\yii\helpers\Url::toRoute(['/finder/galleryimage',
                             'idModal'=>'imagemodal',                             
                             'modelid'=>$model->id,
                             'nombreclase'=> str_replace('\\','_',get_class($model))]);
                        $options = [
                            'title' => Yii::t('base.names', 'Ver Galería'),
                            //'aria-label' => Yii::t('rbac-admin', 'Activate'),
                            //'data-confirm' => Yii::t('rbac-admin', 'Are you sure you want to activate this user?'),
                            'data-method' => 'get',
                            //'data-pjax' => '0',
                        ];
                        return Html::button('<span class="glyphicon glyphicon-eye-open"></span>', ['href' => $url, 'title' => 'Visualizar imágenes', 'class' => 'botonAbre btn btn-success']);
                        //return Html::a('<span class="btn btn-success glyphicon glyphicon-pencil"></span>', Url::toRoute(['view-profile','iduser'=>$model->id]), []/*$options*/);
                     
                        
                        },
                                
                                'edit' => function ($url,$model) {
			    $url= Url::to(['/op/proc/mod-edit-osdet','id'=>$model->id,'gridName'=>'pjax-detserv','idModal'=>'buscarvalor']);
                              return \yii\helpers\Html::a('<span class="btn btn-warning glyphicon glyphicon-pencil"></span>', $url, ['data-pjax'=>'0','class'=>'botonAbre']);
                            },
                        'delete' => function ($url,$model) {
                              
                                $url = \yii\helpers\Url::to([$this->context->id.'/deletemodel-for-ajax','id'=>$model->id]);                              
                                    return \yii\helpers\Html::a('<span class="btn btn-danger glyphicon glyphicon-trash"></span>', 'javascript:void(0)', [
                                                'rel'=>$url,
                                        /*'id'=>$model->codparam,*/
                                        'family'=>'pigmalion',
                                        'id'=>\yii\helpers\Json::encode(['id'=>$model->id,'modelito'=> str_replace('@','\\',get_class($model))]),/*'title' => 'Borrar'*/
                                        ]);
                             
                              
			    },
                        
                       
                    ]
                ],
        [
                'class' => 'kartik\grid\ExpandRowColumn',
                'width' => '50px',
              'expandIcon'=>'<i style="color:#fcc400"><span class="fa fa-plus-square-o"></span></i>',
                 'collapseIcon'=>'<i style="color:#fcc400"><span class="fa fa-minus-square-o"></span></i>',
                
                'value' => function ($model, $key, $index, $column) {
                            return GridView::ROW_COLLAPSED;
                                },
                                        
                    /* 'detail'=>function ($model, $key, $index, $column){
                                    
                         
                        return  $this->render('_expand_operacion',[
                            'id'=>$model->id,
                            'model'=>$model,
                            ]);            
                     },*/
                                       
                     'detailUrl' =>Url::toRoute(['/op/proc/ajax-expand-opera']),
                    //'headerOptions' => ['class' => 'kartik-sheet-style'], 
                    'expandOneOnly' => true
                ], 
         ['attribute' => 'item',
                'format'=>'raw',
                'value'=>function($model){
                        return $model->item;                        
                             } 
                
                ],
         
             ['attribute' => 'descripcion',
                'format'=>'raw',
                'value'=>function($model){
                        return $model->descripcion;                        
                             } 
                
                ],
                
               ['attribute' => 'emplazamiento',
                'format'=>'raw',
                'header'=>'Empl.',
                'value'=>function($model){
                    return $model->emplazamiento;
                            } 
                
                ],
            
          
        ],
    ]); ?>
    <?php
      $url= Url::to(['mod-agrega-det-os','id'=>$model->id,'gridName'=>'pjax-detserv','idModal'=>'buscarvalor']);
   echo  Html::button('</span><span class="fa fa-plus"></span>   '.yii::t('base.verbs','Agregar actividad').'<span class="fa fa-wrench">', 
           ['href' => $url, 'title' => yii::t('base.names','Agregar Op'),
               'id'=>'btn_cuentas_edi',
               'class' => 'botonAbre btn btn-primary'
               ]); 
    ?>
   
    
</div>
    
  </div>        
     <?php 
   echo linkAjaxGridWidget::widget([
           'id'=>'widgetgruidBancosss',
            'idGrilla'=>'pjax-detserv',
            'family'=>'pigmalion',
          'type'=>'POST',
           'evento'=>'click',
           //'refrescar'=>false,
        'posicion'=>\yii\web\View::POS_END
       
            //'foreignskeys'=>[1,2,3],
        ]); 
   ?>
    <?php Pjax::end(); ?>

</div>
    
