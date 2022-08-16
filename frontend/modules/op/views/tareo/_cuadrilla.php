<?php
use kartik\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;
use yii\helpers\Html;
use common\widgets\linkajaxgridwidget\linkAjaxGridWidget;
use common\widgets\inputajaxwidget\inputAjaxWidget;
?>
<div style='overflow:auto;'>
     <?php
     $zona_pjax_cuadrilla='pjax-cuadrilla';
     Pjax::begin(['id'=>$zona_pjax_cuadrilla,'timeout'=>false]); ?>
    <?= GridView::widget([
        'id'=>'grilla-os',
                'dataProvider' =>$dataProviderCuadrilla,
         'summary' => '',
         'tableOptions'=>['class'=>'table table-condensed table-hover table-bordered table-striped'],
        //'filterModel' => New \frontend\modules\op\models\OpOsSearch(),
        'columns' => [
            
          [                    
                'class' => 'yii\grid\ActionColumn',
                //'template' => Helper::filterActionColumn(['view', 'activate', 'delete']),
            'template' => '{edit}{delete}',
               'buttons' => [
                    'attach' => function($url, $model) {  
                         $url=\yii\helpers\Url::toRoute(['/finder/selectimage','isImage'=>false,'idModal'=>'imagemodal','modelid'=>$model->id,'nombreclase'=> str_replace('\\','_',get_class($model))]);
                        $options = [
                            'title' => Yii::t('base.names', 'Colocar en el maletín'),
                            //'aria-label' => Yii::t('rbac-admin', 'Activate'),
                            //'data-confirm' => Yii::t('rbac-admin', 'Are you sure you want to activate this user?'),
                            'data-method' => 'get',
                            //'data-pjax' => '0',
                        ];
                        return Html::button('<span class="glyphicon glyphicon-paperclip"></span>', ['href' => $url, 'title' => 'Editar Adjunto', 'class' => 'botonAbre btn btn-success']);
                        //return Html::a('<span class="btn btn-success glyphicon glyphicon-pencil"></span>', Url::toRoute(['view-profile','iduser'=>$model->id]), []/*$options*/);
                     
                        
                        },
                                
                                'edit' => function ($url,$model)  use($zona_pjax_cuadrilla) {
			    $url= Url::to(['/op/tareo/modal-edita-persona','id'=>$model->id,'gridName'=>$zona_pjax_cuadrilla,'idModal'=>'buscarvalor']);
                              return \yii\helpers\Html::a('<span class="btn btn-success glyphicon glyphicon-pencil"></span>', $url, ['data-pjax'=>'0','class'=>'botonAbre']);
                            },
                        'delete' => function ($url,$model) use($zona_pjax_cuadrilla) {
                              
                                $url = \yii\helpers\Url::to([$this->context->id.'/deletemodel-for-ajax','id'=>$model->id]);                              
                                    return \yii\helpers\Html::a('<span class="btn btn-primary glyphicon glyphicon-trash"></span>', '#', ['rel'=>$url,/*'id'=>$model->codparam,*/'family'=>'holas','id'=>\yii\helpers\Json::encode(['id'=>$model->id,'modelito'=> str_replace('@','\\',get_class($model))]),/*'title' => 'Borrar'*/]);
                             
                              
			    },
                        
                    ]
                ],
        [
                'class' => 'kartik\grid\ExpandRowColumn',
                'width' => '50px',
                'value' => function ($model, $key, $index, $column) {
                            return GridView::ROW_COLLAPSED;
                                },
                     'detailUrl' =>Url::toRoute(['/op/proc/ajax-expand-opera']),
                    //'headerOptions' => ['class' => 'kartik-sheet-style'], 
                    'expandOneOnly' => true
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
                'value'=>function($model){
                        return $model->htotales;                        
                             } 
                
                ],
                         ['attribute' => 'codtra',
                'format'=>'raw',
                'value'=>function($model){
                        return $model->codtra;                        
                             } 
                
                ],
                 ['attribute' => 'cog',
                'format'=>'raw',
                'value'=>function($model){
                       $url=Url::to(['/op/tareo/modal-view-tax','id'=>$model->id,'idModal'=>'buscarvalor']);
                       $options=['data-pjax'=>'0', 'class' => 'botonAbre'];
                        return Html::a("<span class='glyphicon glyphicon-cog'></span>",$url,$options);                        
                             } 
                
                ],
         
                 ['attribute' => 'codtra',
                'format'=>'raw',
                'value'=>function($model){
                        return $model->trabajador->fullName();                        
                             } 
                
                ],   
                ['attribute' => 'costo',
                'format'=>'raw',
                'value'=>function($model){
                        return $model->costo;                        
                             } 
                
                ],   
           
        ],
    ]); ?>
    
    <?php 
    echo linkAjaxGridWidget::widget([
           'id'=>'widgetgruidBancos',
           'idGrilla'=>$zona_pjax_cuadrilla,
            'family'=>'holas',
          'type'=>'POST',
           'evento'=>'click',
        'posicion'=>\yii\web\View::POS_END
        ]);
    ?>
    
    <?php
      $url= Url::to(['modal-agrega-persona','id'=>$model->id,'gridName'=>$zona_pjax_cuadrilla,'idModal'=>'buscarvalor']);
   echo  Html::button(yii::t('base.verbs','Agregar trabajador'), 
           ['href' => $url, 'title' => yii::t('base.names','Agregar trabajador'),
               'id'=>'btn_cuentas_edi_df',
               'class' => 'botonAbre btn btn-primary'
               ]); 
    ?>
    
    <?php echo Html::button("<span class=\"glyphicon glyphicon-copy\"></span>Clonar", 
                          [
                              'id'=>'btn_clonar_pe',
                              'class' => 'btn btn-warning']
                          ); 
    ?>
    
    
     <?php echo inputAjaxWidget::widget([
            //'isHtml'=>true,
             'id'=>'btn_clonar_pe',
            //'otherContainers'=>[$zona_pjax_cuadrilla],
             'evento'=>'click',
            'tipo'=>'POST',
            'ruta'=>Url::to(['/op/tareo/ajax-clone-worker','id'=>$model->id]),
            'id_input'=>'btn_clonar_pe',
            'idGrilla'=>$zona_pjax_cuadrilla
      ])  ?>  
    
   

   <?php Pjax::end(); ?>
    
</div>
