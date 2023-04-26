<?php
use yii\widgets\Pjax;
use yii\grid\GridView;    
use yii\helpers\Html;
use yii\helpers\Url;
USE common\helpers\h;
 use common\widgets\linkajaxgridwidget\linkAjaxGridWidget;
  use common\widgets\inputajaxwidget\inputAjaxWidget; 
 use frontend\modules\mat\models\MatMatAlmacen;
 ?>   
<div class="box-body">
    <?php Pjax::begin(['id'=>'grilla-materiales']);
    $bloqueado=false;
    ?>
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">    
   <?php //var_dump((new SigiApoderadosSearch())->searchByEdificio($model->id)); die(); ?>
    <?= GridView::widget([
        'dataProvider' =>new yii\data\ActiveDataProvider([
            'query'=>MatMatAlmacen::find()->andWhere(['codal'=>$model->codal]),
                   
        ]),
         //'summary' => '',
         'tableOptions'=>['class'=>'table table-condensed table-hover table-bordered table-striped'],
        'columns' => [
                 [
                'class' => 'yii\grid\ActionColumn',
                //'template' => Helper::filterActionColumn(['view', 'activate', 'delete']),
            'template' => '{edit}{delete}',
               'buttons' => [
                    
                                
                                'edit' => function ($url,$model) use($bloqueado)  {
			    $url= Url::to(['/masters/centros/modal-edita-material-almacen','id'=>$model->id,'gridName'=>'grilla-materiales','idModal'=>'buscarvalor']);
                              if($bloqueado)return '';
                            return \yii\helpers\Html::a('<span class="btn btn-success glyphicon glyphicon-pencil"></span>', $url, ['data-pjax'=>'0','class'=>'botonAbre']);
                            },
                        'delete' => function ($url,$model) use($bloqueado){
                                 if($bloqueado)return '';
			   $url = \yii\helpers\Url::to([$this->context->id.'/deletemodel-for-ajax','id'=>$model->id]);
                              return \yii\helpers\Html::a('<span class="btn btn-danger glyphicon glyphicon-trash"></span>', '#', ['rel'=>$url,/*'id'=>$model->codparam,*/'family'=>'holas','id'=>\yii\helpers\Json::encode(['id'=>$model->id,'modelito'=> str_replace('@','\\',get_class($model))]),/*'title' => 'Borrar'*/]);
                            }
                        
                    ]
                ],
           
              'codart',              
           ['attribute' => 'descripcion',
                'format'=>'raw',
                'value'=>function($model){
                        return $model->material->descripcion;
                              } 
                
                ], 
                        ['attribute' => 'ceconomica',
                'format'=>'raw',
                'value'=>function($model){
                        return $model->ceconomica;
                              } 
                
                ], 
            'creorden',
            'crepo',
            'leadtime'
                       /* ['attribute' => 'V. Unit',
                'format'=>'raw',
                'value'=>function($model){
                        return h::formato()->asDecimal($model->valor/$model->cant,2);
                              } 
                
                ], */
             
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
         'ruta'=> Url::to([$this->context->id.'/ajax-rellena-ids-from-req','codal'=>$model->codal]),
            //'foreignskeys'=>[1,2,3],
         'posicion'=>\yii\web\View::POS_END
        ]); 
   ?>
      
      <?php
 $url= Url::to(['modal-crea-material-almacen','codal'=>$model->codal,'gridName'=>'grilla-materiales','idModal'=>'buscarvalor']);
  if(!$bloqueado)
   echo  Html::button(yii::t('base.verbs','Agregar material'), ['href' => $url, 'title' => yii::t('base.names','Agregar Material'),'id'=>'btn_cuentas_edi', 'class' => 'botonAbre btn btn-success']); 
       ?>   
  </div>
    <?php Pjax::end(); ?>
</div>   