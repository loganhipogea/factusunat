<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\helpers\h;
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
    <?php Pjax::begin(); ?>
    <?php  echo $this->render('_search_mov', ['model' => $searchModel]); ?>
    <?php $formato=h::formato();  ?>
    
    <div style='overflow:auto;'>
    <?php
    $columns=[
            
         
         [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}{view}',
                'buttons' => [
                    
                    'update' => function($url, $model) {                        
                        $options = [
                            'title' => Yii::t('base.verbs', 'Update'),                            
                        ];
                         $url=Url::to(['/cc/cuentas/edit-mov','id'=>$model->id]);
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
                [
                    'attribute'=>'cuenta_id',
                    'format'=>'raw',
                    'value'=>function($model) {
                        return $model->cuenta->nombre;
                    }
                ],
                [
                    'attribute'=>'Respons',
                    'format'=>'raw',
                    'value'=>function($model) {
                        return $model->trabajador->ap;
                    }
                ],
            'fechaop',
            'glosa',
            [
                    'attribute'=>'monto',
                    'format'=>'raw',
                   'contentOptions'=>['style'=>'text-align:right !important;color:#711b88 !important; font-weight:900 !important;'],
                    'value'=>function($model) use($formato){
                        return $formato->asDecimal($model->monto,2);
                    }
                ],
           ['attribute'=>'Moneda',
               'value'=>function($model){
                  return $model->cuenta->codmon;           
                 }
               ],
            ['attribute'=>'Est',
                'format'=>'raw',
               'value'=>function($model){
                  return $model->buttonSatus();           
                 }
               ]
          
        ];
 echo ExportMenu::widget([
    'dataProvider' => $dataProvider,    
   
    'dropdownOptions' => [
        'label' => yii::t('base.names','Exportar'),
        'class' => 'btn btn-primary'
    ]
]).''. GridView::widget([
        'dataProvider' => $dataProvider,
         //'summary' => '',
         'tableOptions'=>['class'=>'table table-condensed table-hover table-bordered table-striped'],
        //'filterModel' => $searchModel,
        'columns' =>$columns, 
    ]); ?>
    <?php Pjax::end(); ?>
</div>
    </div>
</div>
    </div>
       