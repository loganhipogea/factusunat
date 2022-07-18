<?php
use common\widgets\linkajaxgridwidget\linkAjaxGridWidget;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use common\helpers\h;
use yii\data\ActiveDataProvider as MyProvider;
use yii\widgets\Pjax;

use common\widgets\inputajaxwidget\inputAjaxWidget;

$this->title = Yii::t('base.verbs', 'Companies');

?>
<h4><span class="fa fa-user"></span><span class="fa fa-building"></span><?= Html::encode($this->title) ?></h4>
   
<div class="box box-success">


     <?php
     
     $zonaAjax='cliprodsdspj';
     Pjax::begin(['id'=>$zonaAjax]); ?>
    <?php 
 echo GridView::widget([
        'dataProvider' => new MyProvider([
            'query'=> common\models\masters\VwSociedades::find()
        ]),
       'columns' => [
           
                [
                    'attribute' => 'codsoc',
                        'format' => 'raw',
                     'format' => 'raw',
                        'value' => function ($model) {
                            return $model->codpro;
                                },
                        /*'value' => function ($model) {
                            return \yii\helpers\Html::c('codsoc[]', $model->activo, ['id'=>$model->id, 'family' =>'holas','title'=>Url::to(['profile/ajax-assign','id'=>$model->id])]);
                                },*/
                ],
                  [
                    'attribute' => 'rucpro',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return $model->rucpro;
                                },
                ],
                                        [
                    'attribute' => 'despro',
                        'format' => 'raw',
                        'value' => function ($model) {
                            return$model->despro;
                                },
                ],
                    
            //'codsoc',
           
        ],
    ]); ?>
    <?php Pjax::end(); ?>

  
</div>



