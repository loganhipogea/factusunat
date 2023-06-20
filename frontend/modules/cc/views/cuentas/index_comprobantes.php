<?php
use yii\helpers\Url;
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use common\helpers\h;
use kartik\export\ExportMenu;
USE common\helpers\FileHelper;
/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\com\ComFacturaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('base.names', 'Comprobantes');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="com-factura-index">

    <h4><?= Html::encode($this->title) ?></h4>
    <div class="box box-success">
     <div class="box-body">
    <?php Pjax::begin(['id'=>'pjax-index-comprobantes']); ?>
    <?php  echo $this->render('_search_comprobantes', ['model' => $searchModel]); ?>
    <?php 
    $bloqueado=false;
    $formato=h::formato(); 
    ?>
    
   <div style="overflow:auto;">
    <?= GridView::widget([
        'dataProvider' =>/*(new \yii\data\ActiveDataProvider([
                        'query'=> \frontend\modules\cc\models\CcCompras::find()
                        ->andWhere(['parent_id'=>$model->id])
                        ]))*/$dataprovider,
         //'summary' => '',
        //'filter'=> $searchModel,
       // 'filterModel' => $searchModel,
         'tableOptions'=>['class'=>'table table-condensed table-hover table-bordered table-striped'],
        'columns' => [
             [
                'class' => 'kartik\grid\ExpandRowColumn',
                'width' => '50px',
                 'expandIcon'=>'<i style="color:#F86E35"><span class="fa fa-plus-square-o"></span></i>',
                 'collapseIcon'=>'<i style="color:#F60101"><span class="fa fa-minus-square-o"></span></i>',
                
                'value' => function ($model, $key, $index, $column) {
                            return GridView::ROW_COLLAPSED;
                                },
                     'detailUrl' =>Url::toRoute(['/cc/cuentas/ajax-show-comprobante']),
                    //'headerOptions' => ['class' => 'kartik-sheet-style'], 
                    'expandOneOnly' => true
             ], 
                 [
                    
                'class' => 'yii\grid\ActionColumn',
                //'template' => Helper::filterActionColumn(['view', 'activate', 'delete']),
            'template' => '{edit}{delete}{attach}',
               'contentOptions'=>['style'=>'width:55px;'],
               'buttons' => [
                    'attach' => function($url, $model) {  
                         $url=\yii\helpers\Url::toRoute(['/finder/selectimage','isImage'=>false,'idModal'=>'imagemodal','modelid'=>$model->id,'nombreclase'=> str_replace('\\','_',get_class($model)),'extension'=> \yii\helpers\Json::encode(array_merge(['pdf'], FileHelper::extImages())),
                           ]);
                        $options = [
                            'title' => Yii::t('base.names', 'Colocar en el maletín'),
                            //'aria-label' => Yii::t('rbac-admin', 'Activate'),
                            //'data-confirm' => Yii::t('rbac-admin', 'Are you sure you want to activate this user?'),
                             'data-method' => 'get',
                            //'data-pjax' => '0',
                        ];
                        return Html::a('<span class="glyphicon glyphicon-paperclip"></span>', $url,['title' => 'Editar Adjunto', 'class' => 'botonAbre']);
                        //return Html::a('<span class="btn btn-success glyphicon glyphicon-pencil"></span>', Url::toRoute(['view-profile','iduser'=>$model->id]), []/*$options*/);
                     
                        
                        },
                                
                                'edit' => function ($url,$model) {
			    $url= Url::to(['/cc/cuentas/edit-comprobante','id'=>$model->id,'modo'=>3,'gridName'=>'grilla-gastos','idModal'=>'buscarvalor']);
                              return \yii\helpers\Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, ['data-pjax'=>'0']);
                            },
                        'delete' => function ($url,$model) use($bloqueado) {
                              IF($model->activo && !$bloqueado){
                                $url = \yii\helpers\Url::to([$this->context->id.'/ajax-anula-comprobante','id'=>$model->id]);
                              
                                    return \yii\helpers\Html::a('<span class="glyphicon glyphicon-trash"></span>', '#', ['rel'=>$url,/*'id'=>$model->codparam,*/'family'=>'holas','id'=>\yii\helpers\Json::encode(['id'=>$model->id,'modelito'=> str_replace('@','\\',get_class($model))]),/*'title' => 'Borrar'*/]);
                              }else{
                                  return '';
                              }
                             
			    }
                        
                    ]
                ],
            
              /*['attribute' => 'codocu',
                'format'=>'raw',
               // 'filter'=> common\helpers\ComboHelper::getCboDocuments(),
                'value'=>function($model){ 
                         if(!$model->activo){                            
                           return '<span style="text-decoration:line-through;">'.$model->documento->desdocu.'</span>';
                          }else{
                             
                             return $model->documento->desdocu;
                                                
                             } 
                             //RETURN $model->ceco_id;
                                                                               
                            } 
                
                ], */
               'fecha',
               'glosa',
             ['attribute' => 'Av.',
                'format'=>'raw',
                'value'=>function($model){ 
                             //RETURN $model->ceco_id;
                             return $model->PorcentajeAvanceCalificacion(true).'%';                                                   
                            } 
                
                ], 
             ['attribute' => 'serie',
                'format'=>'raw',
                'value'=>function($model){ 
                             //RETURN $model->ceco_id;
                             return $model->serie;                                                   
                            } 
                
                ], 
             ['attribute' => 'numero',
                'format'=>'raw',
                'value'=>function($model){                        
                             return $model->numero;                                                   
                             } 
                
                ], 
                 ['attribute' => 'rucpro',
                'format'=>'raw',
                'value'=>function($model){                        
                             return $model->rucpro;                                                   
                             } 
                
                ],        
                 
               ['attribute' => 'despro',
                'format'=>'raw',
                'value'=>function($model){                        
                             return substr($model->despro(),0,25);                                                   
                             } 
                
                ], 
                    
            ['attribute' => 'monto',
                'format'=>'raw',
                 'contentOptions'=>['style'=>'text-align:right;'],
                'value'=>function($model) use($formato){
                             if(!$model->activo){                            
                           return '<span style="text-decoration:line-through;">'.$formato->asDecimal($model->monto,3).'</span>';
                          }else{
                             
                             return $formato->asDecimal($model->monto,3);
                                                
                             } 
                  }
                ], 
             
             
           ['class' => '\common\components\columnGridAudit',],
        ],
    ]); ?>
        
      </div>
      <?php Pjax::end([]); ?>
    </div>
</div>
    </div>
       