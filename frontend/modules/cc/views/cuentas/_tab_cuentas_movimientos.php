<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use common\helpers\FileHelper;
$bloqueado=false;
?>
<div class="box-header">
          
        <div class="col-md-12">
            <div class="form-group btn-group">
         <?php $url=Url::to(['/cc/cuentas/crea-mov','id'=>$model->id]);    ?>
          <?= Html::a('<span class="fa fa-save"></span>   '.Yii::t('app', 'Create Movement'),$url, ['class' => 'btn btn-danger']) ?>
            

                  

            </div>
        </div>
 </div>
  <div style="overflow:auto;">
    <?= GridView::widget([
        'dataProvider' =>(new \yii\data\ActiveDataProvider([
                        'query'=> \frontend\modules\cc\models\CcMovimientos::find()
                        ->andWhere(['cuenta_id'=>$model->id])-> 
                        orderBy(['fechaop'=>SORT_DESC])
                        ])),
         //'summary' => '',
        //'filter'=> $searchModel,
        //'filterModel' => $searchModel,
         'tableOptions'=>['class'=>'table table-condensed table-hover table-bordered table-striped'],
        'columns' => [
             /*[
                'class' => 'kartik\grid\ExpandRowColumn',
                'width' => '50px',
                'value' => function ($model, $key, $index, $column) {
                            return GridView::ROW_COLLAPSED;
                                },
                     'detailUrl' =>Url::toRoute(['/cc/cuentas/ajax-show-comprobante']),
                    //'headerOptions' => ['class' => 'kartik-sheet-style'], 
                    'expandOneOnly' => true
             ], */
                 [
                    
                'class' => 'yii\grid\ActionColumn',
                //'template' => Helper::filterActionColumn(['view', 'activate', 'delete']),
            'template' => '{edit}{delete}{attach}',
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
                        return Html::button('<span class="glyphicon glyphicon-paperclip"></span>', ['href' => $url, 'title' => 'Editar Adjunto', 'class' => 'botonAbre btn btn-success']);
                        //return Html::a('<span class="btn btn-success glyphicon glyphicon-pencil"></span>', Url::toRoute(['view-profile','iduser'=>$model->id]), []/*$options*/);
                     
                        
                        },
                                
                                'edit' => function ($url,$model) {
			    $url= Url::to(['/cc/cuentas/edit-mov','id'=>$model->id,'modo'=>3,'gridName'=>'grilla-gastos','idModal'=>'buscarvalor']);
                              return \yii\helpers\Html::a('<span class="btn btn-success glyphicon glyphicon-pencil"></span>', $url, ['data-pjax'=>'0']);
                            },
                        'delete' => function ($url,$model) use($bloqueado) {
                              IF($model->activo && !$bloqueado){
                                $url = \yii\helpers\Url::to([$this->context->id.'/ajax-anula-comprobante','id'=>$model->id]);
                              
                                    return \yii\helpers\Html::a('<span class="btn btn-danger glyphicon glyphicon-trash"></span>', '#', ['title'=>$url,/*'id'=>$model->codparam,*/'family'=>'holas','id'=>\yii\helpers\Json::encode(['id'=>$model->id,'modelito'=> str_replace('@','\\',get_class($model))]),/*'title' => 'Borrar'*/]);
                              }else{
                                  return '';
                              }
                             
			    }
                        
                    ]
                ],
            
              ['attribute' => 'codtra',
                'format'=>'raw',                
                'value'=>function($model){ 
                               return $model->codtra;             
                            } 
                
                ], 
               ['attribute' => 'fechaop',
                'format'=>'raw',                
                'value'=>function($model){ 
                               return $model->fechaop;             
                            } 
                
                ],
               ['attribute' => 'glosa',
                'format'=>'raw',                
                'value'=>function($model){ 
                               return $model->glosa;             
                            } 
                
                ],
               ['attribute' => 'monto',
                'format'=>'raw',                
                'value'=>function($model){ 
                               return $model->monto;             
                            } 
                
                ],
           ['class' => '\common\components\columnGridAudit',],
        ],
    ]); ?>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
            <p class="text-right">
                 <?php //echo yii::t('base.labels','Monto rendido : '). '  S/. '.$formato->asDecimal($model->acumulado(),2) ?>
            </p>
                       
        </div> 
      </div>
