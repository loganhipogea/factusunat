<?php
use common\widgets\linkajaxgridwidget\linkAjaxGridWidget;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use kartik\export\ExportMenu;
/* @var $this yii\web\View */
/* @var $searchModel common\models\masters\CliproSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('base.names', 'Customers/Vendors');

?>
<h4><span class="fa fa-building"></span><?= Html::encode($this->title) ?></h4>
   
<div class="box box-success">


     <?php Pjax::begin(['id'=>'clipropj']); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <div class="btn-group">  
        <?= Html::a('<span class="fa fa-industry"></span>'.'  '.Yii::t('app', 'Crear Empresa'), ['create'], ['class' => 'btn btn-success']) ?>
   
   
    <?php
 echo ExportMenu::widget([
    'dataProvider' => $dataProvider,    
    'columns' => ['codpro',
            'despro',
            'rucpro'],
    'dropdownOptions' => [
        'label' => yii::t('base.names','Exportar'),
        'class' => 'btn btn-success'
    ]
]).' 
    </div>
 <hr>
         '.GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        // 'summary' => '',
        //'tableOptions'=>['class'=>".thead-dark table table-condensed table-hover table-bordered table-striped"],
        'columns' => [
           ['class' => 'yii\grid\ActionColumn',
                'template'=>'{update}{view}{delete}',
                'buttons'=>[
                    'update'=>function($url,$model){
                        $url=\yii\helpers\Url::toRoute(['update','id'=>$model->codpro]);
                        return \yii\helpers\Html::a(
                                '<span class=" glyphicon glyphicon-pencil"></span>',
                                $url,
                                ['data-pjax'=>'0']
                                );
                     },
                     'view'=>function($url,$model){
                        $url=\yii\helpers\Url::toRoute(['view','id'=>$model->codpro]);
                        return \yii\helpers\Html::a(
                                '<span class="glyphicon glyphicon-search"></span>',
                                $url,
                                ['data-pjax'=>'0']
                                );
                     },
                             
                            'delete' => function ($url,$model) {                             
                                $url = \yii\helpers\Url::to([$this->context->id.'/deletemodel-for-ajax','id'=>$model->codpro]);
                              return \yii\helpers\Html::a('<span class="glyphicon glyphicon-trash"></span>', '#', ['rel'=>$url,'family'=>'holas','id'=>\yii\helpers\Json::encode(['id'=>$model->codpro,'modelito'=> str_replace('@','\\',get_class($model))])]);
                             }
                   ]
                ],
           
            'codpro',
            'despro',
            'alias',
            'rucpro',
           ['attribute'=>'deslarga',
               'value'=>function ($model) {
                     return $model->deslarga;
			     }
               
               ]
            //'deslarga:ntext',

              
        ],
    ]); ?>
    
    
   <?php 
    echo linkAjaxGridWidget::widget([
           'id'=>'widgestgrurtryidBancos',
       // 'otherContainers'=>['pjax-monto','pjax-moneda'],
            'idGrilla'=>'clipropj',
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

