<?php

use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\data\ActiveDataProvider;
use common\helpers\h;
use common\widgets\linkajaxgridwidget\linkAjaxGridWidget;
?>
<div class="mat-petoferta-detalle">
 
  <?php
  $formato=h::formato();
  $formato->thousandSeparator=',';
  ?>
    <?php Pjax::begin(['id'=>'pjax-detpet']); ?>
   

    
    <div style='overflow:auto;'>
    <?= GridView::widget([
        'dataProvider' => new ActiveDataProvider([
            'query'=> frontend\modules\mat\models\MatDetpetoferta::find()->andWhere(['petoferta_id'=>$model->id])
        ]),
        // 'summary' => '',
         'tableOptions'=>['class'=>'table table-condensed table-hover table-bordered table-striped'],
        //'filterModel' => $searchModel,
        'columns' => [
            
         
         [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{edit}{delete}',
                'buttons' => [
                    'edit' => function ($url,$model) {
                                if($model->isMaterial()){
                                   $url= Url::to(['/mat/petoferta/modal-edit-det','id'=>$model->id,'gridName'=>Json::encode(['pjax-detpet']),'idModal'=>'buscarvalor']);
                                  
                                }else{
                                    $url= Url::to(['/mat/petoferta/modal-edit-serv','id'=>$model->id,'gridName'=>Json::encode(['pjax-detpet']),'idModal'=>'buscarvalor']);
                                 
                                }
			       
                                return \yii\helpers\Html::a('<span class="btn btn-success glyphicon glyphicon-pencil"></span>', $url, ['data-pjax'=>'0','class'=>'botonAbre']);
                            },
                        'delete' => function ($url,$model) {                             
                                $url = \yii\helpers\Url::to([$this->context->id.'/deletemodel-for-ajax','id'=>$model->id]);
                              return \yii\helpers\Html::a('<span class="btn btn-danger glyphicon glyphicon-trash"></span>', '#', ['rel'=>$url,/*'id'=>$model->codparam,*/'family'=>'holas','id'=>\yii\helpers\Json::encode(['id'=>$model->id,'modelito'=> str_replace('@','\\',get_class($model))]),/*'title' => 'Borrar'*/]);
                             }
                    ]
                ],
         
         
         
         
         

           
            'item',
            'codart',
            'codum',
            [  
                'attribute' => 'cant', 
                     'headerOptions' => [
                        'class' => 'text-right',
                        
                            ],
                 'contentOptions'=>['style'=>'text-align:right; width: 10%; font-weight:900;'],
                 'value'=>function($model)use($formato){
                     return $formato->asDecimal($model->cant, 2);   
                 },
                 'footer'=>'HOLA',     
                ], 
            [  
                'attribute' => 'punit', 
                     'headerOptions' => [
                        'class' => 'text-right',
                        
                            ],
                 'contentOptions'=>['style'=>'text-align:right; width: 10%; font-weight:900;'],
                 'value'=>function($model)use($formato){
                     return $formato->asDecimal($model->punit, 2);   
                 },
               
                ],  
             'descripcion',
             [  
                'attribute' => 'pventa', 
                     'headerOptions' => [
                        'class' => 'text-right',
                         
                        
                            ],
                
                 'contentOptions'=>['style'=>'text-align:right; width: 10%; font-weight:900;'],
                 'value'=>function($model)use($formato){
                     return $formato->asDecimal($model->pventa, 2);   
                 },
                
                    
             ],
                       
            //'codtra',
            //'user_id',
            //'estado',
            //'descripcion',
            //'detalle:ntext',

          
        ],
    ]); ?>
     <?php 
    echo linkAjaxGridWidget::widget([
           'id'=>'widgetgruidBancos',
        'otherContainers'=>['pjax-resumen'],
            'idGrilla'=>'pjax-detpet',
            'family'=>'holas',
          'type'=>'POST',
           'evento'=>'click',
        'posicion'=>\yii\web\View::POS_END
       
            //'foreignskeys'=>[1,2,3],
        ]);
    ?>   
      <div class="col-lg-12 col-md-6 col-sm-6 col-xs-6">   
        
    </div> 
    <div class="col-lg-12 col-md-6 col-sm-6 col-xs-6">  
        
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">   
            <label class="control-label" for="buscador_id">Igv</label>
            <input  type="text" value="<?=$model->igv()?>" id="igv_id" class="form-control" disabled="disabled" class="text-right">
      
        </div> 
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">  
            
            <label class="control-label" for="buscador_id">Total</label>
            <input  type="text" value="<?=$model->total()?>" id="total_id" class="form-control" disabled="disabled" class="text-right">
      
        </div> 
      
    </div>   
    <?php Pjax::end(); ?>
    
</div>
    </div>

       