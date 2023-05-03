<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use kartik\export\ExportMenu;
use common\helpers\h;
/* @var $this yii\web\View */
/* @var $searchModel common\models\masters\MaestrocompoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('base.names', 'Materials');
$this->params['breadcrumbs'][] = $this->title;
?>





   <h4><?=h::awe('dropbox')?><?= Html::encode($this->title) ?></h4>
  
    <div class="box box-success">
       <?php   
  $gridColumns= [
          
           
            'codart',
             ['attribute' => 'descripcion',
                'headerOptions' => ['style' => 'width:40%'],
                'format'=>'raw',
                'value'=>function($model){                            
                            return $model->descripcion;
                            }                
                ],
            'marca',
            'modelo',
            'um.codum',
             ['attribute' => 'codtipo',
                'headerOptions' => ['style' => 'width:20%'],
                'format'=>'raw',
                'value'=>function($model){                            
                            return $model->comboValueText('codtipo');
                            }                
                ],  
                        
            ['attribute' => 'imagen',
                'format'=>'raw',
                'value'=>function($model){
                            if($model->hasAttachments())
                            return \yii\helpers\Html::img ($model->files[0]->url,['width'=>50,'height'=>50]);
                            } 
                
                ],
            //'numeroparte',
            //'codum',
            //'peso',
            //'codtipo',
            //'esrotativo',

            ['class' => 'yii\grid\ActionColumn'],
        ];

  ?> 
       <?php Pjax::begin(['id'=>'grilla-materiales']); ?>
        
            <div class="btn-group">
                 <?= Html::a(Yii::t('base.verbs', 'Create').' '.Yii::t('base.names', 'Material'), ['create'], ['class' => 'btn btn-success']) ?>
     
     <?=ExportMenu::widget([
    'dataProvider' => $dataProvider,
          
    'columns' => $gridColumns,
    'dropdownOptions' => [
        'label' => yii::t('base.names','Exportar'),
        'class' => 'btn btn-success'
    ]
]) . "<br><hr>\n".GridView::widget([
        'dataProvider' => $dataProvider,
      
    
         'tableOptions'=>['class'=>'table table-condensed table-hover table-bordered table-striped'],
        'filterModel' => $searchModel,
        'columns' => $gridColumns,
    ]); ?>
    
   
    <?php Pjax::end(); ?>
  </div>
</div>
