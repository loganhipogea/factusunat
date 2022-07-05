<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
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
    <?php Pjax::begin(); ?>
    <?php  echo $this->render('_search_con_detalles', ['model' => $searchModel]); ?>

    
    <div style='overflow:auto;'>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
         //'summary' => '',
         'tableOptions'=>['class'=>'table table-condensed table-hover table-bordered table-striped'],
        //'filterModel' => $searchModel,
        'columns' => [
            
         
         [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}{view}',
                'buttons' => [
                    
                    'update' => function($url, $model) {                        
                        $options = [
                            'title' => Yii::t('base.verbs', 'Update'),                            
                        ];
                         $url=Url::to(['/com/com/update-invoice','id'=>$model->id]);
                         return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, $options);
                        
                        //return Html::a('<span class="btn btn-info btn-sm glyphicon glyphicon-pencil"></span>', $url, $options);
                         },
                          /*'view' => function($url, $model) {                        
                        $options = [
                            'title' => Yii::t('base.verbs', 'View'),                            
                        ];
                        return Html::a('<span class="btn btn-warning btn-sm glyphicon glyphicon-search"></span>', $url, $options);
                         },*/
                         /*'delete' => function($url, $model) {                        
                        $options = [
                            'data-confirm' => Yii::t('rbac-admin', 'Are you sure you want to activate this user?'),
                            'title' => Yii::t('base.verbs', 'Delete'),                            
                        ];
                        return Html::a('<span class="btn btn-danger btn-sm glyphicon glyphicon-remove"></span>', $url, $options);
                         }*/
                    ]
                ],
            'codsoc',
            'numero',
            'femision',
            'descripcion',
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
            //'sunat_totigv',
            //'sunat_totimpuestos',
            //'descuento',
            //'subtotal',
            //'sunat_totisc',
            //'totalventa',
            'total',

          
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
    </div>
</div>
    </div>
       