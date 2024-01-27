<?php
use yii\widgets\Pjax;
use yii\grid\GridView;    
use yii\helpers\Html;
use yii\helpers\Url;
USE common\helpers\h;
 use common\widgets\linkajaxgridwidget\linkAjaxGridWidget;
  use common\widgets\inputajaxwidget\inputAjaxWidget;  
  USE common\helpers\FileHelper as Fl;
 ?>         
    <?php Pjax::begin(['id'=>'grilla-materiales']);
    //$bloqueado=false;
   // $total=$model->total();
    $formato=h::formato();
    $bloqueado=false;
        $ext= json_encode(array_merge(Fl::extImages(),Fl::extDocs()));
    ?>
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">    
   <?php //var_dump((new SigiApoderadosSearch())->searchByEdificio($model->id)); die(); ?>
    <?= GridView::widget([
        'dataProvider' => new yii\data\ActiveDataProvider(
                [
                    'query'=> \frontend\modules\mat\models\MatDetNe::find()->andWhere(['guia_id'=>$model->id])
                ]),
         //'summary' => '',
        'footerRowOptions'=>['style'=>'text-align:right; font-weight:800;font-size:1.2em; color:#3A0A38'],
        
         'showFooter'=>true,
         'tableOptions'=>['class'=>'table table-condensed table-hover table-bordered table-striped'],
        'columns' => [
                 [
                'class' => 'yii\grid\ActionColumn',
                //'template' => Helper::filterActionColumn(['view', 'activate', 'delete']),
            'template' => '{edit}{delete}{attach}',
               'buttons' => [
                    
                                
                                'edit' => function ($url,$model) use($bloqueado)  {
			    $url= Url::to(['/mat/mov/mod-edit-det-ne','id'=>$model->id,'gridName'=>'grilla-materiales','idModal'=>'buscarvalor']);
                              if($bloqueado)return '';
                            return \yii\helpers\Html::a('<span class="btn btn-success glyphicon glyphicon-pencil"></span>', $url, ['data-pjax'=>'0','class'=>'botonAbre']);
                            },
                        'delete' => function ($url,$model) use($bloqueado){
                                 if($bloqueado)return '';
			   $url = \yii\helpers\Url::to([$this->context->id.'/ajax-anula-detalle-item','id'=>$model->id]);
                              return \yii\helpers\Html::a('<span class="btn btn-danger glyphicon glyphicon-trash"></span>', '#', ['rel'=>$url,/*'id'=>$model->codparam,*/'family'=>'holas','id'=>\yii\helpers\Json::encode(['id'=>$model->id,'modelito'=> str_replace('@','\\',get_class($model))]),/*'title' => 'Borrar'*/]);
                            },
                        
                         'attach' => function($url, $model) use($ext) {  
                          $url=\yii\helpers\Url::toRoute(['/finder/selectimage','isImage'=>true,
                             'idModal'=>'imagemodal',
                             'extension'=>$ext,
                             'grillas'=>'pjax-detserv',
                             'modelid'=>$model->id,
                             'nombreclase'=> str_replace('\\','_',get_class($model))]);
                       
                        return Html::button('<span class="glyphicon glyphicon-paperclip"></span>', ['href' => $url, 'title' => 'Editar Adjunto', 'class' => 'botonAbre btn btn-success']);
                        //return Html::a('<span class="btn btn-success glyphicon glyphicon-pencil"></span>', Url::toRoute(['view-profile','iduser'=>$model->id]), []/*$options*/);
                     
                        
                        },  
                    ]
                ],
            'item',
             ['attribute' => '.',
                'format'=>'raw',
                'value'=>function($model){
                         return ($model->rotativo)?'<i style="color:#ade000; font-size:2em;" ><span  class="fa fa-cog"></span></i>':
                        '';
                         
                              } 
                
                ], 
             'codum',
             
              'codart',              
           ['attribute' => 'descripcion',
                'format'=>'html',
                'value'=>function($model){
                         return ($model->isActivo())?$model->descripcion:
                        '<i style="color:red; text-decoration: line-through;">'.$model->descripcion."</i>";
                         
                              } 
                
                ], 
                        
                 'cant',  
                 'serie',
                        
              /*['attribute' => 'valor',
                'format'=>'raw',
               'footer' => $formato->asDecimal($total,2),
                'contentOptions'=>['style'=>'text-align:right; font-weight:800;'],
                'value'=>function($model) use($formato){
                        return $formato->asDecimal($model->valor,2);
                            } 
                
                ], */
             ['attribute' => 'imagen',
                'format'=>'raw',
                'value'=>function($model){
                            if(!is_null($model->getFirstImage()))
                            return \yii\helpers\Html::img ($model->files[0]->url,['width'=>100,'height'=>100]);
                                                 
                              } 
                
                ], 
             [
                'class'=>'\common\components\columnGridAudit'
                ], 
        ],
    ]); ?>
         <?php 
   echo linkAjaxGridWidget::widget([
           'id'=>'widgetgruidBancos',
            'idGrilla'=>'grilla-materiales',
            'family'=>'holas',
          'type'=>'POST',
           'evento'=>'click',
       'posicion'=>\yii\web\View::POS_END
            //'foreignskeys'=>[1,2,3],
        ]); 
   ?>
      <?php 
   echo inputAjaxWidget::widget([
           'id_input'=>'widgetgruixxdBancos',
            'idGrilla'=>'grilla-materiales',
            'id'=>'btn-add-material',
          'tipo'=>'POST',
           'evento'=>'click',
         'ruta'=> Url::to([$this->context->id.'/ajax-rellena-ids-from-req','id'=>$model->id]),
            //'foreignskeys'=>[1,2,3],
         'posicion'=>\yii\web\View::POS_END
        ]); 
   ?>
      
      <?php
 $url= Url::to(['mod-crea-det-ne','id'=>$model->id,'gridName'=>'grilla-materiales','idModal'=>'buscarvalor']);
  if(!$bloqueado)
   echo  Html::button(yii::t('base.verbs','Agregar material'), ['href' => $url, 'title' => yii::t('base.names','Agregar Material'),'id'=>'btn_cuentas_edi', 'class' => 'botonAbre btn btn-success']); 
       ?>   
  </div>
    <?php Pjax::end(); ?>
     