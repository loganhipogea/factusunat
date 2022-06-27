<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\widgets\linkajaxgridwidget\linkAjaxGridWidget;

use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $model common\models\masters\CentrosSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="centros-search">




     <?php
     $zonaAjax='expand_sucursal';
     echo get_class($model);
     Pjax::begin(['id'=>$zonaAjax]); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <div class="btn-group">  
        <?php
        $url= Url::to(['/masters/clipro/crea-almacen','id'=>$model->codcen,'gridName'=>$zonaAjax,'idModal'=>'buscarvalor']);
 
        ?>
        <?= Html::a('<span class="fa fa-industry"></span>'.'  '.Yii::t('base.verbs', 'Create store'), $url, ['class' => 'btn btn-success botonAbre']) ?>
   
   
    <?php
    $dataProvider=new \yii\data\ActiveDataProvider([
                'query'=> \common\models\masters\Almacenes::find()->select(['codal','nomal']),
            ]);
  ?>
    </div>

    <?php ECHO GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        // 'summary' => '',
        //'tableOptions'=>['class'=>".thead-dark table table-condensed table-hover table-bordered table-striped"],
        'columns' => [
           ['class' => 'yii\grid\ActionColumn',
                'template'=>'{update}{view}{delete}',
                /*'buttons'=>[
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
                              return \yii\helpers\Html::a('<span class="glyphicon glyphicon-trash"></span>', '#', ['title'=>$url,'family'=>'holas','id'=>\yii\helpers\Json::encode(['id'=>$model->codpro,'modelito'=> str_replace('@','\\',get_class($model))])]);
                             }
                   ]*/
                ],
           
            'codal',
            'nomal',
            
           
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
