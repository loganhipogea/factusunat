<?php
  use yii\helpers\Url;
 use yii\widgets\Pjax;
 use yii\helpers\Html;
use yii\grid\GridView;
use common\helpers\h;
     
 
?>     

<div class="box-body">
    <?php 
    //(SDPSDSD
    Pjax::begin(['id'=>'pjax_repositorio']); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    
 
    <div style='overflow:auto;'>
    <?= GridView::widget([
        'id'=>'grilla-repositorio',
        'dataProvider' => $dataProviderDocs,
         'summary' => '',
         'tableOptions'=>['class'=>'table table-condensed table-hover table-bordered table-striped'],
        'filterModel' => $searchOsDocs,
        'columns' => [
         ['attribute' => 'os_id',
                'format'=>'raw',
                'filter'=> frontend\modules\op\helpers\ComboHelper::os(),
                'value'=>function($model){
                            if($model->hasAttachments())
                        return Html::a("<span class='glyphicon glyphicon-download-alt'></span>".$model->files[0]->name.'.'.$model->files[0]->type,$model->files[0]->url,['data-pjax'=>'0']);                        
                             } 
                
                ],
           ['attribute' => 'codocu',
                'format'=>'raw',
               'filter'=> \common\helpers\ComboHelper::getCboDocuments(),
                'value'=>function($model){
                        return $model->documento->desdocu;                        
                             } 
                
                ], 
            'descripcion',
            ['attribute' => 'detalles',
                //'format'=>'raw',
               //'filter'=> \common\helpers\ComboHelper::getCboDocuments(),
                'value'=>function($model){
                        return substr($model->detalles,0,10);                        
                             } 
                
                ],  
            'cuando', 
            ['attribute' => 'user',
                'format'=>'raw',
               //'filter'=> \common\helpers\ComboHelper::getCboDocuments(),
                'value'=>function($model){
                        return '<span class="fa fa-user"></span>'.h::userName();                        
                             } 
                
                ], 
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
    </div>
