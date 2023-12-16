<?php
use yii\helpers\Url;
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use kartik\export\ExportMenu;
USE common\helpers\FileHelper as Fl;
use common\helpers\h;
/* @var $this yii\web\View */
/* @var $searchModel frontend\modules\mat\models\MatReqSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Ingresos');
$this->params['breadcrumbs'][] = $this->title;
ECHO \common\widgets\spinnerWidget\spinnerWidget::widget();
?>
<div class="mat-req-index">

    <h4><?= Html::encode($this->title) ?></h4>
    <div class="box box-success">
     <div class="box-body">
    <?php Pjax::begin(); ?>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <?php  
    echo $this->render('_ne_search', ['model' => $searchModel]); 

    $gridColumns=[
            
         
         /*[
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}{attach}',
                'buttons' => [
                    'update' => function($url,$model) {   
                       
                        $options = [
                            'title' => Yii::t('base.verbs', 'Update'),                            
                        ];
                        $url= \yii\helpers\Url::to(['/mat/mat/update','id'=>$model->id]);
                        return Html::a('<span class="btn btn-info btn-sm glyphicon glyphicon-pencil"></span>', $url, $options);
                         },
                     
                    ]
                ],*/
         
         
         
         
         

            
            ['attribute'=>'numero',
                'group'=>true,
                'format'=>'raw',
               // 'headerOptions' => ['style' => 'width:50%'],
               // 'filter'=> frontend\modules\mat\helpers\comboHelper::getCboAlmacenes(),
                  'value'=>function ($model){
                    return Html::a($model->numero,Url::to(['editar-ne','id'=>$model->id]),['target'=>'_blank','data-pjax'=>0]);
                  }
                ],
             'item',
            'cant',
                        ['attribute' => '.',
                'format'=>'raw',
                'value'=>function($model){
                         return ($model->rotativo)?'<i style="color:#ade000; font-size:2em;" ><span  class="fa fa-cog"></span></i>':
                        '';
                         
                              } 
                
                ], 
            'codart',
           
              ['attribute'=>'descri',
                  'format'=>'html',
                'value'=>function ($model){
                            return ($model->activo)?$model->descri:
                        '<i style="text-decoration: line-through;">'.$model->descripcion."</i>"; 
                       }
                ],           
                        
                        
                     
                        
           ['attribute'=>'codcen',
               'group'=>true,
               // 'headerOptions' => ['style' => 'width:50%'],
               // 'filter'=> frontend\modules\mat\helpers\comboHelper::getCboAlmacenes(),
                  'value'=>function ($model){
                    return $model->codcen;
                  }
                ],
           ['attribute'=>'fecha',
               'group'=>true,
               // 'headerOptions' => ['style' => 'width:50%'],
               // 'filter'=> frontend\modules\mat\helpers\comboHelper::getCboAlmacenes(),
                  'value'=>function ($model){
                    return $model->fecha;
                  }
                ],
                        
               ['attribute'=>'Img',
               
               // 'headerOptions' => ['style' => 'width:50%'],
               // 'filter'=> frontend\modules\mat\helpers\comboHelper::getCboAlmacenes(),
                   'format'=>'html',
                  'value'=>function ($model){
                    $detalle=$model->detalleItem;
                    if(!is_null($detalle->getFirstImage()))
                            return \yii\helpers\Html::img ($detalle->files[0]->url,['width'=>100,'height'=>100]);
                    return '';
                  }
                ],
                            
            //'descripcion',
            //'texto:ntext',
            //'codest',

          
        ];
    
    ?>
    </DIV> 
    <?php  echo '.';  ?>
   <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <?=ExportMenu::widget([
    'dataProvider' => $dataProvider,
          
    'columns' => $gridColumns,
    'dropdownOptions' => [
        'label' => yii::t('base.names','Exportar'),
        'class' => 'btn btn-success'
    ]
]) . "<br><hr>\n".GridView::widget([
        'dataProvider' => $dataProvider,
         //'summary' => '',
         'tableOptions'=>['class'=>'table table-condensed table-hover table-bordered table-striped'],
        //'filterModel' => $searchModel,
        'columns' => $gridColumns,
    ]); ?>
    <?php Pjax::end(); ?>
</div>
    </div>
</div>
    </div>
       