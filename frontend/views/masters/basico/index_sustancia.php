<?php
use common\widgets\linkajaxgridwidget\linkAjaxGridWidget;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

$this->title = Yii::t('base.names', 'Sustancias');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sociedades-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(['id'=>'grid-sustancias']); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('base.names', 'Crear sustancia'), ['crea-sustancia'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
       // 'id'=>'gridBancos',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
           
            'descripcion',
            'densidad',
            
            ['class' => 'yii\grid\ActionColumn',
                'template'=>'{update}{delete}',
                'buttons'=>[
                    'update'=>function($url,$model){
                        $url=\yii\helpers\Url::toRoute(['edita-sustancia','id'=>$model->id]);
                        return \yii\helpers\Html::a(
                                '<span class="btn btn-success glyphicon glyphicon-pencil"></span>',
                                $url,
                                ['data-pjax'=>'0']
                                );
                     },
                     
                            'delete' => function ($url,$model) {
			    $url = \yii\helpers\Url::to('deletemodel-for-ajax');
                             return \yii\helpers\Html::a('<span class="btn btn-danger glyphicon glyphicon-trash"></span>', '#', ['rel'=>$url,/*'id'=>$model->codparam,*/'family'=>'holas','id'=>\yii\helpers\Json::encode(['id'=>$model->id,'modelito'=> str_replace('@','\\',get_class($model))]),/*'title' => 'Borrar'*/]);
                            }
                   ]
                ],
        ],
    ]); ?>
    <?php 
   echo linkAjaxGridWidget::widget([
           'id'=>'widgetgridBancos',
            'idGrilla'=>'grid-sustancias',
            'family'=>'holas',
          'type'=>'POST',
           'evento'=>'click',
         'posicion'=> \yii\web\View::POS_END
            //'foreignskeys'=>[1,2,3],
        ]); 
   ?>
    
    <?php Pjax::end(); ?>
</div>


