<?php
use common\widgets\linkajaxgridwidget\linkAjaxGridWidget;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use common\helpers\h;
use yii\data\ActiveDataProvider as MyProvider;
use yii\widgets\Pjax;

use common\widgets\inputajaxwidget\inputAjaxWidget;
//use kartik\export\ExportMenu;
/* @var $this yii\web\View */
/* @var $searchModel common\models\masters\CliproSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('base.verbs', 'Assign company for: ').h::userName();

?>
<h4><span class="fa fa-user"></span><span class="fa fa-building"></span><?= Html::encode($this->title) ?></h4>
   
<div class="box box-success">


     <?php
     
     $zonaAjax='cliprodsdspj';
     Pjax::begin(['id'=>$zonaAjax]); ?>
    <?php 
    
// echo $this->render('_search', ['model' => $searchModel]); ?>
    <div class="btn-group">  
        <?= Html::a('<span class="glyphicon glyphicon-ok-circle"></span>'.'  '.Yii::t('base.verbs', 'Make a God'),'#', ['id'=>'a_id_god','class' => 'btn btn-success']) ?>
         <?= Html::a('<span class="glyphicon glyphicon-remove-circle"></span>'.'  '.Yii::t('base.verbs', 'Revoke all'),'#', ['id'=>'a_id_revoke','class' => 'btn btn-danger']) ?>
    </div>
   
    <?php
   
 echo GridView::widget([
        'dataProvider' => new MyProvider([
            'query'=> common\models\masters\VwSociedades::find()
        ]),
       // 'filterModel' => $searchModel,
        // 'summary' => '',
        //'tableOptions'=>['class'=>".thead-dark table table-condensed table-hover table-bordered table-striped"],
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
                            return Html::a($model->despro,
                                    Url::to(['profile/set-company','codpro'=>$model->codpro]),
                                    []);
                                },
                ],
                    
            //'codsoc',
           
        ],
    ]); ?>
    
    
   <?php 
   echo linkAjaxGridWidget::widget([
           'id'=>'widgetgridBanggcos',
            'idGrilla'=>$zonaAjax,
            'family'=>'holas',
          'type'=>'GET',
           'evento'=>'click',
           'posicion'=>\yii\web\View::POS_END
            //'foreignskeys'=>[1,2,3],
        ]); 
    ?>
    <?php
     
     echo inputAjaxWidget::widget([
            //'isHtml'=>true,
             'id'=>'a_id_god',
            //'otherContainers'=>['pjax-monto','pjax-moneda'],
             'evento'=>'click',
            'tipo'=>'POST',
            'ruta'=>Url::to(['profile/ajax-assign-all','id'=>'']),
            'id_input'=>'a_id_god',
            'idGrilla'=>$zonaAjax
      ])  ?>  
    <?php
     echo inputAjaxWidget::widget([
            //'isHtml'=>true,
             'id'=>'a_id_revoke',
            //'otherContainers'=>['pjax-monto','pjax-moneda'],
             'evento'=>'click',
            'tipo'=>'POST',
            'ruta'=>Url::to(['profile/ajax-revoke-all','id'=>'$model->id']),
            'id_input'=>'a_id_revoke',
            'idGrilla'=>$zonaAjax
      ])  ?> 
    
    <?php Pjax::end(); ?>

  
</div>



