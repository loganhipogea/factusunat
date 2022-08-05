<?php
use common\helpers\h;
 use yii\helpers\Url;
use kartik\grid\GridView;
use yii\helpers\Html;
 use yii\widgets\ActiveForm;
?>

<div class="op-tareo-form">
    <br>
    <?php $form = ActiveForm::begin([
    //'fieldClass'=>'\common\components\MyActiveField'
    ]); ?>
 
    <div class="box-header">
        <div class="col-md-12">
            <div class="form-group">
               <div class="btn-group">  
       
                       <?php 
                       $first=$model->firstRecord();
                       $last=$model->lastRecord();
                       $previous=$model->previousRecord();
                       $next=$model->nextRecord();
                       $url='/op/tareo/view-summary-week-person';
                       
                       
                       if(!is_null($first)){
                        echo Html::a("<span class=\"glyphicon glyphicon-fast-backward\"></span>", 
                            Url::toRoute([
                            '/op/tareo/view-summary-week-person',        
                            'proc_id'=>$first->proc_id,
                            'codtra'=>$first->codtra,
                            'semana'=>$first->semana,
                               'anio'=>$first->anio, 
                            ]),
                                    [
                              'data-pjax'=>'0',
                              'class' => 'btn btn-success']
                                    );
                                }
                        ?>
                        <?php 
                         if(!is_null($previous)){
                        echo Html::a("<span class=\"glyphicon glyphicon-fast-backward\"></span>", 
                            Url::to([
                            $url,
                            'proc_id'=>$previous->proc_id,
                            'codtra'=>$previous->codtra,
                            'semana'=>$previous->semana,
                               'anio'=>$previous->anio, 
                            ]),
                          [
                              'data-pjax'=>'0',
                              'class' => 'btn btn-success']
                          ); 
                         }
                        ?>
                   <?php  
                   if(!is_null($next)){
                   echo Html::a("<span class=\"glyphicon glyphicon-arrow-left\"></span>", 
                            Url::to([
                            $url,
                            'proc_id'=>$next->proc_id,
                            'codtra'=>$next->codtra,
                            'semana'=>$next->semana,
                            'anio'=>$next->anio                                
                            ]),
                          [
                              'data-pjax'=>'0',
                              'class' => 'btn btn-success']
                          ); 
                   }
                        ?>
                   <?php 
                    if(!is_null($last)){
                   echo Html::a("<span class=\"glyphicon glyphicon-arrow-right\"></span>", 
                            Url::to([
                            $url,
                            'proc_id'=>$last->proc_id,
                            'codtra'=>$last->codtra,
                            'semana'=>$last->semana,
                            'anio'=>$last->anio 
                            ]),
                          [
                              'data-pjax'=>'0',
                              'class' => 'btn btn-success']
                          ); 
                    }
                        ?>
                  <?php 
                    
                   echo Html::a("<span class=\"glyphicon glyphicon-cog\"></span>", 
                            Url::to([
                            '/op/tareo/pdf-worker-week',
                            'proc_id'=>$last->proc_id,
                            'codtra'=>$last->codtra,
                            'semana'=>$last->semana,
                            'anio'=>$last->anio 
                            ]),
                          [
                              'data-pjax'=>'0',
                              'class' => 'btn btn-danger']
                          ); 
                  
                        ?>
            </div>
             </div>
        </div>
    </div>

 
  <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
     <?= $form->field($model, 'codtra')->textInput(['disabled' => true]) ?>

 </div>
 
 <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
     <?= $form->field($model, 'codtra')->textInput([
         'disabled' => true,
         'value'=>$model->ap.'-'.$model->nombres
         ])
         ->label('Nombres')                      
                                ?>

 </div>
 <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
     <?= $form->field($model, 'numero')->textInput(['disabled' => true]) ?>

 </div>
 <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
     <?= $form->field($model, 'descripcion')->textInput(['disabled' => true]) ?>

 </div>
 <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'semana')->textInput(['disabled' => true]) ?>

 </div> 
    
 <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'codigo')->
            textInput(['disabled' => true])-> 
            label('Regimen')
            ?>

 </div> 
    
 <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'costohora')->
            textInput(['disabled' => true])-> 
            label('Tarifa/hora')
            ?>

 </div> 
    <hr>
<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
     <?= $form->field($model, 'porc_hextras')->
            textInput(['disabled' => true])
            ?>

 </div> 
    
<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
     <?= $form->field($model, 'porc_dominical')->
            textInput(['disabled' => true])
            ?>

 </div>
 <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
     <?= $form->field($model, 'porc_refrigerio')->
            textInput(['disabled' => true])
            ?>

 </div> 
    
<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
     <?= $form->field($model, 'porc_nocturno')->
            textInput(['disabled' => true])
            ?>

 </div>   
    
 
    
    
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
    <div style='overflow:auto;'>
    <?= GridView::widget([
        'id'=>'grilla-resumen',
        'showFooter'=>true,
         'dataProvider' =>new \yii\data\ActiveDataProvider([
                                    'query'=> frontend\modules\op\models\OpTareodet::find()
                            ->andWhere(['codtra'=>$model->codtra,'proc_id'=>$model->proc_id])
                            ->orderBy(['id'=>SORT_ASC])
                                ]),
         'summary' => '',
         'tableOptions'=>['class'=>'table table-condensed table-hover table-bordered table-striped'],
        //'filterModel' => New \frontend\modules\op\models\OpOsSearch(),
        'columns' => [
            
          [                    
                'class' => 'yii\grid\ActionColumn',
                //'template' => Helper::filterActionColumn(['view', 'activate', 'delete']),
            'template' => '',
               'buttons' => [
                    
                                
                                'edit' => function ($url,$model) {
			    $url= Url::to(['/op/tareo/modal-edita-libro','id'=>$model->id,'gridName'=>'pjax-det','idModal'=>'buscarvalor']);
                              return \yii\helpers\Html::a('<span class="btn btn-success glyphicon glyphicon-pencil"></span>', $url, ['data-pjax'=>'0','class'=>'botonAbre']);
                            },
                       
                       
                    ]
                ],
        
              ['attribute' => 'fecha',
                'format'=>'raw',
                'value'=>function($model){
                        return $model->tareo->fecha;                        
                             } 
                
                ],
              ['attribute' => 'dia',
                'format'=>'raw',
                'value'=>function($model){
                        return common\helpers\timeHelper::daysOfWeek()[$model->tareo->toCarbon('fecha')->weekDay()];                        
                             } 
                
                ],
         ['attribute' => 'hinicio',
                'format'=>'raw',
                'value'=>function($model){
                        return $model->hinicio;                        
                             } 
                
                ],
           ['attribute' => 'hfin',
                'format'=>'raw',
                'value'=>function($model){
                        return $model->hfin;                        
                             } 
                
                ],
             
             ['attribute' => 'htotales',
                'format'=>'raw',
                 'footer'=>$model->htotales, 
                'value'=>function($model){
                        return $model->htotales;                        
                             } 
                
                ],
             ['attribute' => 'hextras',
                'format'=>'raw',
                  'footer'=>$model->hextras,
                'value'=>function($model){
                        return $model->hextras;                        
                             } 
                
                ], 
             ['attribute' => 'basico',
                'format'=>'raw',
                  'footer'=>$model->basico,
                'value'=>function($model){
                        return $model->basico;                        
                             } 
                
                ], 
             ['attribute' => 'dominical',
                'format'=>'raw',
                  'footer'=>$model->dominical,
                'value'=>function($model){
                        return $model->dominical;                        
                             } 
                
                ], 
            ['attribute' => 'adicional',
                'format'=>'raw',
                'footer'=>$model->adicional,
                'value'=>function($model){
                        return $model->adicional;                        
                             } 
                
                ], 
            ['attribute' => 'costo',
                'format'=>'raw',
                'footer'=>$model->costo,
                'value'=>function($model){
                        return $model->costo;                        
                             } 
                
                ],   
        ],
    ]); ?>
   
    
</div>
    
  </div>        
    
          
          
          
</div>
    <?php ActiveForm::end()  ?>

 