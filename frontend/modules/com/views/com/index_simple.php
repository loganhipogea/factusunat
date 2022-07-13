<?php
use yii\helpers\Url;
use yii\helpers\Html;
//use yii\grid\GridView;
use yii\widgets\Pjax;
use common\widgets\linkajaxgridwidget\linkAjaxGridWidget;
use kartik\grid\GridView;
use kartik\export\ExportMenu;
/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\com\ComFacturaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('base.names', 'Com Facturas');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="com-factura-index">

    <h4><?= Html::encode($this->title) ?></h4>
    <div class="box box-success">
     <div class="box-body">
    <?php Pjax::begin(['id'=>'pjax-grilla']); ?>
    <?php 
    $formato=yii::$app->formatter;
    echo $this->render('_search', ['model' => $searchModel]);
    ?>

    
    <div style='overflow:auto;'>
     <?php
 echo ExportMenu::widget([
    'dataProvider' => $dataProvider,    
    'columns' => [
       'codsoc',
            'numero',
            'femision',
            'fvencimiento',
            'codmon',
            'rucpro',
           'nombre_cliente',
            'total',
        ],
    'dropdownOptions' => [
        'label' => yii::t('base.names','Exportar'),
        'class' => 'btn btn-primary'
    ]
]).''.GridView::widget([
        'dataProvider' => $dataProvider,
        // 'summary' => '',
         'tableOptions'=>['class'=>'table table-condensed table-hover table-bordered table-striped'],
       // 'filterModel' => $searchModel,
        'columns' => [
            
         
         [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}{delete}{aprobe}{send}{void}',
                'buttons' => [
                     'update' => function($url, $model) {                        
                        $options = [
                            'title' => Yii::t('base.verbs', 'Update'),                            
                        ];
                         $url=Url::to(['/com/com/update-invoice','id'=>$model->id]);
                         return Html::a('<span class="btn btn-sm btn-success glyphicon glyphicon-pencil"></span>', $url, $options);
                     },
                     
                     'delete' => function($url, $model) {                        
                        $options = [
                            'title' => Yii::t('base.verbs', 'Cancel'),                            
                        ];
                         //$action=($model->isInvoice())?'invoice':'voucher';
                         $url=Url::to(['/com/com/ajax-remove-invoice','id'=>$model->id]);
                         $options=['family'=>'holas','rel'=>$url,'id'=>$model->id];
                         return Html::a('<span  class="btn btn-sm  btn-danger  glyphicon glyphicon-trash"></span>', 'javascript:void(0)', $options);
                     }, 
                      'aprobe' => function($url, $model) {                        
                        $options = [
                            'title' => Yii::t('base.verbs', 'Pass'),                            
                        ];
                         $url=Url::to(['/com/com/update-invoice','id'=>$model->id]);
                         return Html::a('<span class="btn btn-sm  btn-success  glyphicon glyphicon-ok"></span>', $url, $options);
                     },
                      'send' => function($url, $model) {                        
                        $options = [
                            'title' => Yii::t('base.verbs', 'Send'),                            
                        ];
                         $action=($model->isInvoice())?'invoice':'voucher';
                         $url=Url::to(['/sunat/default/ajax-send-'.$action.'-std','id'=>$model->id]);
                         $options=['family'=>'holas','rel'=>$url,'id'=>$model->id];
                         return Html::a('<span  class="btn btn-sm  btn-success  glyphicon glyphicon-send"></span>', 'javascript:void(0)', $options);
                     }, 
                      'void' => function($url, $model) {                        
                        $options = [
                            'title' => Yii::t('base.verbs', 'Undo send'),                            
                        ];
                         $action=($model->isInvoice())?'invoice':'voucher';
                         $url=Url::to(['/sunat/default/ajax-down-'.$action.'-sunat','id'=>$model->id]);
                         $options=['family'=>'holas','rel'=>$url,'id'=>$model->id];
                         return Html::a('<span  class="btn btn-sm  btn-danger  glyphicon glyphicon-send"></span>', 'javascript:void(0)', $options);
                     }, 
                   
                    ],
                  'visibleButtons'=>[
                      'delete'=>function($model, $key, $index){
                         return $model->canCancel();
                      } , 
                      'aprobe'=>function($model, $key, $index){
                         return $model->canAprobe();
                      } , 
                      'send'=>function($model, $key, $index){
                         return $model->canSendSunat();
                      } , 
                      'void'=>function($model, $key, $index){
                         return $model->canVoidSunat();
                      } , 
                  ],
                              
                 'contentOptions'=>['style'=>'width:100px; '],
            ],
             [
                'class' => 'kartik\grid\ExpandRowColumn',
                'width' => '50px',
                'value' => function ($model, $key, $index, $column) {
                            return GridView::ROW_COLLAPSED;
                                },                 
                     'detailUrl' =>Url::toRoute(['/com/com/ajax-expand-attachments']),
                     'expandOneOnly' => true
                ],    
            'codsoc',
           [
                    'attribute'=>'numero',
                    'format'=>'raw',
                   'contentOptions'=>['style'=>'color:#711b88 !important; '],
                    'value'=>function($model){
                        return $model->numero;
                    }
                ],
            'femision',
           // 'fvencimiento',
            //'sunat_tipodoc',
            'codmon',
            //'tipopago',
            'rucpro',
            //'sunat_hemision',
            //'codcen',
            //'serie',
            //'codestado',
            'nombre_cliente',
            //'hemision',
            //'sunat_totgrav',
            //'sunat_totexo',
           [
                    'attribute'=>'sunat_totigv',
                    'format'=>'raw',
                   'contentOptions'=>['style'=>'text-align:right !important;color:#711b88 !important; font-weight:900 !important;'],
                    'value'=>function($model) use($formato){
                        return $formato->asDecimal($model->sunat_totigv,2);
                    }
                ],
            //'sunat_totimpuestos',
            //'descuento',
            //'subtotal',
            //'sunat_totisc',
            //'totalventa',
            [
                    'attribute'=>'total',
                    'format'=>'raw',
                   'contentOptions'=>['style'=>'text-align:right !important;color:#711b88 !important; font-weight:900 !important;'],
                    'value'=>function($model) use($formato){
                        return $formato->asDecimal($model->total,2);
                    }
                ],
            [
                    'attribute'=>'codestado',
                    'format'=>'raw',
                    'value'=>function($model){
                        return $model->statusText();
                    }
                ],
              [
                    'attribute'=>'flag_sunat',
                    'format'=>'raw',
                    'value'=>function($model){
                        return $model->iconStatusSunat();
                    }
                ],
          
        ],
    ]); ?>
    <?php 
    echo linkAjaxGridWidget::widget([
           'id'=>'widgetgruidBancos',
       // 'otherContainers'=>['pjax-monto','pjax-moneda'],
            'idGrilla'=>'pjax-grilla',
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
</div>
    </div>
       