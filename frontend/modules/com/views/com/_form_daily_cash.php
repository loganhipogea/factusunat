<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use common\widgets\inputajaxwidget\inputAjaxWidget;
use frontend\modules\com\helpers\ComboHelper;
use common\helpers\h;
use kartik\grid\GridView as grid;
use kartik\date\DatePicker;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model frontend\modules\com\models\ComOv */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="com-ov-form">
 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
     <br>
     <br>
     <div class="box box-success">
    <?php
    $formato=h::formato();
    $grid_zone='grilla_general';
    $moneda=h::gsetting('general', 'moneda');
    $hasChilds=$model->hasDocuments();
    
    $form = ActiveForm::begin([
        'id'=>'Form_general',
        'enableAjaxValidation'=>true
        ]); ?>  
    
    <div class="form-group">
                <div class="btn-group">
         <?php  
                if($model->isCreated())
                echo  Html::submitButton(Yii::t('base.names', 'Save'), ['class' => 'btn btn-success']);
           ?>
             <?php  
                if($model->isPassed() && !$model->isNewRecord)
                 echo Html::button("<span class=\"fa fa-check\"></span>Cerrar", 
                          [
                              //'id'=>'btn_fct_enviar-sunat',
                              'class' => 'btn btn-info']
                          ); 
           ?> 
            <?php  
                if($model->isPassed() && !$model->isNewRecord)
                 echo Html::button("<span class=\"fa fa-check\"></span>Cerrar", 
                          [
                              //'id'=>'btn_fct_enviar-sunat',
                              'class' => 'btn btn-info']
                          ); 
           ?>   
            <?php if(!$model->isSendSuccessToSunat()){ 
                   echo Html::button("<span class=\"fa fa-paper-plane\"></span>Enviar Sunat", 
                          [
                              'id'=>'btn_fct_enviar-sunat',
                              'class' => 'btn btn-warning']
                          );
              }?> 
        
        
       
                </div>
     </div>
   <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
     <?= $form->field($model, 'caja_id')->
            dropDownList(ComboHelper::getCboCajas() ,
                    ['prompt'=>'--'.yii::t('base.verbs','Choose a Value')."--",
                    // 'class'=>'probandoSelect2',
                        'disabled'=>$hasChilds
                        ]
                    ) ?>
    </div>
     <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12"> 
      <?= $form->field($model, 'fecha')->widget(DatePicker::class, [
                            'language' => h::app()->language,
                           'pluginOptions'=>[
                                       'format' => h::getFormatShowDate(),
                                   'changeMonth'=>true,
                                  'changeYear'=>true,
                                 'yearRange'=>'2010:'.date('Y'),
                               ],
                          
                            //'dateFormat' => h::getFormatShowDate(),
                            'options'=>[
                                'class'=>'form-control',
                                'disabled'=>$hasChilds
                                ]
                            ]) ?>

   </div>
    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
     <?= $form->field($model, 'codcen')->
            dropDownList(ComboHelper::getCboCentros() ,
                    ['prompt'=>'--'.yii::t('base.verbs','Choose a Value')."--",
                    // 'class'=>'probandoSelect2',
                        'disabled'=>$hasChilds
                        ]
                    ) ?>
    </div>
   
   
    <?php  ActiveForm::end() ?>
     <?php 
     
     Pjax::begin(['id'=>$grid_zone]);
   if(false){
  $column=[
                    
                'class' => 'yii\grid\ActionColumn',
                //'template' => Helper::filterActionColumn(['view', 'activate', 'delete']),
            'template' => '{edit}{delete}',
               'buttons' => [  
                       'edit' => function ($url,$model) {
			    $url= Url::to(['/com/com/edit-detail-invoice','id'=>$model->id,'gridName'=>Json::encode(['grilla-contactos','zona-totales']),'idModal'=>'buscarvalor']);
                              return \yii\helpers\Html::a('<span class="btn btn-success glyphicon glyphicon-pencil"></span>', $url, ['data-pjax'=>'0','class'=>'botonAbre']);
                            },
                        'delete' => function ($url,$model) {                             
                                $url = \yii\helpers\Url::to([$this->context->id.'/ajax-delete-invoice-item','id'=>$model->id]);
                              return \yii\helpers\Html::a('<span class="btn btn-danger glyphicon glyphicon-trash"></span>', '#', ['title'=>$url,/*'id'=>$model->codparam,*/'family'=>'holas','id'=>\yii\helpers\Json::encode(['id'=>$model->id,'modelito'=> str_replace('@','\\',get_class($model))]),/*'title' => 'Borrar'*/]);
                             }
                        
                    ]
                ];
   }else{
      $column=[
                    
                'class' => 'yii\grid\ActionColumn',
                //'template' => Helper::filterActionColumn(['view', 'activate', 'delete']),
            'template' => '',
               
                ]; 
   }
   $gridColumns=[       
            $column,
        [
            'attribute' => 'numero',
           
         ],  
          
         [
            //'class' => 'kartik\grid\EditableColumn',
            'attribute' => 'femision',
           /* 'pageSummary' => 'Total',
            'vAlign' => 'middle',
            'width' => '210px',*/
            
         ],  
        'nombre_cliente',
                            
       [
            //'class' => 'kartik\grid\EditableColumn',
            'attribute' => 'total',
           /* 'pageSummary' => 'Total',
            'vAlign' => 'middle',
            'width' => '210px',*/
            
         ],
       [
            //'class' => 'kartik\grid\EditableColumn',
            'attribute' => 'sunat_tipodoc',
           /* 'pageSummary' => 'Total',
            'vAlign' => 'middle',
            'width' => '210px',*/
            
         ],
         [
                    'attribute'=>'flag_sunat',
                    'format'=>'raw',
                    'value'=>function($model){
                        return $model->iconStatusSunat();
                    }
                ],
   ];
   echo grid::widget([
    'dataProvider'=> new \yii\data\ActiveDataProvider([
        'query'=> frontend\modules\com\models\ComFactura::find()-> 
                andWhere(['caja_id'=>$model->id])
    ]),
   // 'filterModel' => $searchModel,
       'summary' => '',
    'columns' => $gridColumns,
    //'responsive'=>true,
    //'hover'=>true
       ]);
   ?> 
   
         
         
         
         
         
        <table class="table table-striped table-bordered"><thead>
        <tr>
            
            <th>Cant Facturas</th>
            <th>Monto Facturas</th>
            <th>Cant Boletas</th>
            <th>Monto Boletas</th>
            <th>Monto Total</th>
            
        </tr>
        </thead>
        <tbody>
                <tr>                   
                    <td><?php echo $model->getValidInvoices()->count();  ?></td>
                    <td><?php echo $moneda.' - '.$formato->asDecimal($model->summaryInvoices(),2);  ?></td>
                    <td><?php echo $model->getValidVouchers()->count();  ?></td>
                     <td><?php echo $moneda.' - '.$formato->asDecimal($model->summaryVouchers(),2);  ?></td>
                     <td ><p class="badge badge-danger"><?php echo $moneda.' - '. $formato->asDecimal($model->summarySell(),2);  ?></p></td>
                </tr>
                
        </tbody>
        </table>
         
      <?php  Pjax::end();  ?>   
         
       
         
      <?php 
      $send_zone='zona_errores_envio';
      echo inputAjaxWidget::widget([
            //'isHtml'=>true,
             'id'=>'btn_fct_aprobar',
            'otherContainers'=>[$send_zone],
             'evento'=>'click',
            'tipo'=>'POST',
            'ruta'=>Url::to(['/sunat/default/ajax-send-sum-vouchers','id'=>$model->id]),
            'id_input'=>'btn_fct_enviar-sunat',
            'idGrilla'=>$grid_zone
      ])  ?>  
    
  </div>
     <?php
        
         Pjax::begin(['id'=>$send_zone]);
     if($model->hasSends()){ 
         
         ?>
     <span id="boton_show" class=" btn btn-danger"><i class="glyphicon glyphicon-arrow-down"></i>Ver envíos</span>
     <div class="box box-success">
      <div id="div_resumen_envios" style="display:none;">
      <?php 
   $gridColumns=[
       
            [
                    
                'class' => 'yii\grid\ActionColumn',
                //'template' => Helper::filterActionColumn(['view', 'activate', 'delete']),
            'template' => '',
               
                ],
        [
                'class' => 'kartik\grid\ExpandRowColumn',
                'width' => '50px',
                'value' => function ($model, $key, $index, $column) {
                            return grid::ROW_COLLAPSED;
                                },
                 /*'detail'=> function($model)  {  
                          return  $this->render('_expand_sucursal',[
                               'model'=>$model,
                               //'key'=>$key,
                           ]);
                            },*/
                     'detailUrl' =>Url::toRoute(['/sunat/default/ajax-expand-summary-send']),
                    //'headerOptions' => ['class' => 'kartik-sheet-style'], 
                    'expandOneOnly' => true
                ],
                                        
                                     
                                        
         [
            //'class' => 'kartik\grid\EditableColumn',
            'attribute' => 'resultado',
            'format'=>'raw',
             'value'=>function($model){
                    if($model->resultado){
                        return '<i style="color:#40ab34;font-size:1.5em;"><span class="glyphicon glyphicon-ok"></span></i>';
                    } else{
                        return  '<i style="color:#f52d2d;font-size:1.5em;"><span class="glyphicon glyphicon-remove"></span></i>'; 
                    }               
             }
           /* 'pageSummary' => 'Total',
            'vAlign' => 'middle',
            'width' => '210px',*/
            
         ],  
        [
            //'class' => 'kartik\grid\EditableColumn',
            'attribute' => 'username',
           /* 'pageSummary' => 'Total',
            'vAlign' => 'middle',
            'width' => '210px',*/
            
         ],  
          
         [
            //'class' => 'kartik\grid\EditableColumn',
            'attribute' => 'cuando',
           /* 'pageSummary' => 'Total',
            'vAlign' => 'middle',
            'width' => '210px',*/
            
         ],  
         
       
   ];
   
   echo grid::widget([
    'dataProvider'=> new \yii\data\ActiveDataProvider([
            'query'=> frontend\modules\sunat\models\SunatSendSumary::find()->andWhere([
                'caja_id'=>$model->id,
               // 'tipodoc'=>$model->sunat_tipodoc,
                ])->orderBy(['id'=>SORT_DESC]),
            ]
            ),
   // 'filterModel' => $searchModel,
       'summary' => '',
    'columns' => $gridColumns,
    'responsive'=>true,
    'hover'=>true
       ]);
   ?> 
     </div>
     </div>
     <?php
      Pjax::end();      
          } ?>
</div>
    </div>
  <?php
  $cadena="$('#boton_show').click(function(){
        $('#div_resumen_envios').toggle('slow');
        });";
    $this->registerJs($cadena, \yii\web\View::POS_END);
  
  ?>