<?php
use yii\helpers\Html;
use common\helpers\h;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\grid\GridView;
use frontend\modules\op\helpers\ComboHelper;
use common\widgets\linkajaxgridwidget\linkAjaxGridWidget;
?>
<div class="box-body">
    <br>
   
 
        
    <?php Pjax::begin(['id'=>'pjax-detservicios','timeout'=>false]); ?>
    <?php 
    $formato=h::formato();
// echo $this->render('_search', ['model' => $searchModel]);
    ?>

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
    <div style='overflow:auto;'>
    <?php 
   echo GridView::widget([
        'id'=>'grilla-serviciosx',
         'dataProvider' =>$dataProviderServicios,
        
         'filterModel' => $searchModelServ,
         'summary' => '',
         'tableOptions'=>['class'=>'table table-condensed table-hover table-bordered table-striped'],
        //'filterModel' => New \frontend\modules\op\models\OpOsSearch(),
        'columns' => [
            
          [
                    
                'class' => 'yii\grid\ActionColumn',
               'contentOptions'=>['style'=>'width:15%;'],
                //'template' => Helper::filterActionColumn(['view', 'activate', 'delete']),
            'template' => '{edit}{delete}{change}',
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
                                
                                'edit' => function ($url,$model) {
			    $url= Url::to(['/op/proc/modal-edit-det-req-serv','id'=>$model->iddet,'gridName'=>'pjax-detservicios','idModal'=>'buscarvalor']);
                              return \yii\helpers\Html::a('<span class="btn btn-success glyphicon glyphicon-pencil"></span>', $url, ['data-pjax'=>'0','class'=>'botonAbre']);
                            },
                        'delete' => function ($url,$model) {
                              
                                $url = \yii\helpers\Url::to([$this->context->id.'/deletemodel-for-ajax','id'=>$model->id]);                              
                                    return \yii\helpers\Html::a('<span class="btn btn-danger glyphicon glyphicon-trash"></span>', '#', ['rel'=>$url,/*'id'=>$model->codparam,*/'family'=>'pigmalion2','id'=>\yii\helpers\Json::encode(['id'=>$model->iddet,'modelito'=> str_replace('@','\\',\frontend\modules\mat\models\MatDetreq::className())]),/*'title' => 'Borrar'*/]);
                             
                              
			    },
                       
                        
                    ]
                ],
                            
                            ['attribute' => 'detos_id',
                                'format'=>'raw',
               'filter'=> ComboHelper::actividadesOs($model->id),
                'value'=>function($model){
                        return '<span class="fa fa-list" ></span>';                        
                             } 
                
                ],
        
         ['attribute' => 'item',
                'format'=>'raw',
                'value'=>function($model){
                        return $model->item;                        
                             } 
                
                ],
          ['attribute' => 'cant',
                'format'=>'raw',
                'value'=>function($model)use($formato){
                        return $formato->asDecimal($model->cant,0);                        
                             } 
                
                ],
             ['attribute' => 'descridetalle',
                'format'=>'raw',
                'contentOptions'=>['style'=>'width:40%;'],
                'value'=>function($model){
                        return $model->descridetalle;                        
                             } 
                
                ],
              ['attribute' => 'despro',
                'format'=>'raw',
                'contentOptions'=>['style'=>'width:40%;'],
                'value'=>function($model){
                        return $model->despro;                        
                             } 
                
                ],
         ['attribute' => 'numero',
                'format'=>'raw',
                'contentOptions'=>['style'=>'width:10%;'],
                'value'=>function($model){
                        return Html::a($model->numero,Url::to(['/mat/mat/update/','id'=>$model->req_id]),['data-pjax'=>'0']);                        
                             } 
                
                ],
                /*['attribute' => 'codtra',
                'format'=>'raw',
                'value'=>function($model){
                    
                        //return 'hola';
                        return (is_null($model->codtra))?'':$model->trabajador->fullName();                        
                             } 
                
                ],*/
                
          
        ],
    ]); ?>
    <?php
      $url= Url::to(['modal-agrega-det-req-serv','id'=>$model->id,'gridName'=>'pjax-detservicios','idModal'=>'buscarvalor']);
   echo  Html::button('<span class="fa fa-plus"></span>'.yii::t('base.verbs','Solicitar servicio'), 
           ['href' => $url, 'title' => yii::t('base.names','Agregar Op'),
               'id'=>'btn_cuentrras_edi',
               'class' => 'botonAbre btn btn-primary'
               ]); 
    ?>
   
    
</div>
    
  </div>        
     
    
    <?php 
   echo linkAjaxGridWidget::widget([
           'id'=>'widgetgruidWEWBancosss',
            'idGrilla'=>'pjax-detservicios',
            'family'=>'pigmalion2',
          'type'=>'POST',
           'evento'=>'click',
           //'refrescar'=>false,
        'posicion'=>\yii\web\View::POS_END
       
            //'foreignskeys'=>[1,2,3],
        ]); 
   ?>
    <?php Pjax::end(); ?>

</div>
    


