<?php
use yii\helpers\Html;
use common\helpers\h;
 use yii\helpers\Url;
 use yii\widgets\Pjax;
use yii\grid\GridView;
use frontend\modules\op\helpers\ComboHelper;
use common\widgets\linkajaxgridwidget\linkAjaxGridWidget;
use common\widgets\inputajaxwidget\inputAjaxWidget;
use common\helpers\FileHelper as Fl;
?>
<div class="box-body">
    <br>
   
 
     <?php $zonaAjax='pjax-expand'.$model->id;   ?>   
    <?php Pjax::begin(['id'=>$zonaAjax,'timeout'=>false]); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?php $form = \yii\widgets\ActiveForm::begin([
        'id'=>'myformulario',
    'fieldClass'=>'\common\components\MyActiveField'
    ]); ?>
        <?= $form->field($model, 'detalle')->textArea(['disabled'=>true,'value'=> html_entity_decode(strip_tags($model->detalle))]) ?> 
        
        <?php \yii\widgets\ActiveForm::end();
     ?> 
        
    </div>

   
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
    <div style='overflow:auto;'>
    <?= GridView::widget([
        'id'=>'grilla-documentos',
                'dataProvider' =>$dataProvider,
         //'filterModel' => $searchModel,
         'summary' => '',
         'tableOptions'=>['class'=>'table table-condensed table-hover table-bordered table-striped'],
        //'filterModel' => New \frontend\modules\op\models\OpOsSearch(),
        'columns' => [
            
          [
                    
                'class' => 'yii\grid\ActionColumn',
                //'template' => Helper::filterActionColumn(['view', 'activate', 'delete']),
            'template' => '{edit}',
               'buttons' => [
                    'attach' => function($url, $model) {  
                        $ext= json_encode(Fl::extEngineers()+Fl::extDocs());
                        //$ext=['doc','docx','xls','xlsx','ppt','ppt'];
                         $url=\yii\helpers\Url::toRoute(['/finder/selectimage','isImage'=>false,'extension'=>$ext,'idModal'=>'imagemodal','modelid'=>$model->id,'nombreclase'=> str_replace('\\','_',get_class($model))]);
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
			    $url=\yii\helpers\Url::toRoute(['/finder/editattach','idModal'=>'imagemodal','id'=>$model->id,]);
                              return \yii\helpers\Html::a('<span class="btn btn-success glyphicon glyphicon-pencil"></span>', $url, ['data-pjax'=>'0','class'=>'botonAbre']);
                            },
                        'delete' => function ($url,$model) {
                              
                                $url = \yii\helpers\Url::to([$this->context->id.'/deletemodel-for-ajax','id'=>$model->id]);                              
                                    return \yii\helpers\Html::a('<span class="btn btn-primary glyphicon glyphicon-trash"></span>', 'javascript:void(0)', ['rel'=>$url,/*'id'=>$model->codparam,*/'family'=>'pigmalion','id'=>\yii\helpers\Json::encode(['id'=>$model->id,'modelito'=> str_replace('@','\\',get_class($model))]),/*'title' => 'Borrar'*/]);
                             
                              
			    }
                        
                    ]
                ],
                            
                           
        
         ['attribute' => 'type',
                'format'=>'raw',
                'value'=>function($model){
                        return $model->type;                        
                             } 
                
                ],
         
           
             ['attribute' => 'codocu',
                'format'=>'raw',
                'value'=>function($model){
                       if(!empty($model->codocu))
                        return \common\models\masters\Documentos::findOne($model->codocu)->desdocu;                        
                             } 
                
                ],
               ['attribute' => 'titulo',
                'format'=>'raw',
                'value'=>function($model){
                        
                            return Html::a($model->titulo,$model->url,['data-pjax'=>'0']);
                                         
                             } 
                
                ],  
               ['attribute' => 'preview',
                'format'=>'raw',
                'value'=>function($model){
                            if($model->isImage())
                             return \yii\helpers\Html::img ($model->url,['width'=>100,'height'=>90,'class'=>"img-thumbnail"]);
                                         
                             } 
                
                ],  
                
          
        ],
    ]); ?>
    <?php
     /* $url= Url::to(['modal-agrega-det-req-libre','id'=>$model->id,'gridName'=>'pjax-detmat','idModal'=>'buscarvalor']);
   echo  Html::button(yii::t('base.verbs','Agregar operación'), 
           ['href' => $url, 'title' => yii::t('base.names','Agregar Op'),
               'id'=>'btn_cuentas_edi',
               'class' => 'botonAbre btn btn-primary'
               ]); */
    ?>
    <?php 
   echo linkAjaxGridWidget::widget([
           'id'=>'widgetgruidBancosss',
            'idGrilla'=>$zonaAjax,
            'family'=>'pigmalion',
          'type'=>'POST',
           'evento'=>'click',
           //'refrescar'=>false,
        'posicion'=>\yii\web\View::POS_END
       
            //'foreignskeys'=>[1,2,3],
        ]); 
   ?>
    <?php Pjax::end(); ?>
  
</div>
    
  </div>        
    
    <?php
      $this->registerJs("$(document).ready(function() { 

  $('#btn_images_x".$model->id."').on('click',function() {
    alert('hola');
      });
});",\yii\web\View::POS_END);
    ?>

   
        
        
    </div>   
</div>

