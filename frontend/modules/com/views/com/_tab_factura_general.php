<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\Json;
use yii\widgets\ActiveForm;
use common\widgets\inputajaxwidget\inputAjaxWidget;
use common\helpers\ComboHelper;
use common\models\masters\Tipocambio;
use common\helpers\h;
use kartik\date\DatePicker;
use yii\widgets\Pjax;
use yii\grid\GridView as grid;

use common\widgets\linkajaxgridwidget\linkAjaxGridWidget;
/* @var $this yii\web\View */
/* @var $model frontend\modules\com\models\ComOv */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="com-ov-form">
 
    
  
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <?php 
       $deshabilitado=(
                $model->isPassed() ||
                $model->isRemoved()||
                $model->isPassedSunat()||
                 $model->isRejectedSunat()
               );
        
        $form = ActiveForm::begin([
        'id'=>'Form_general',
       'enableAjaxValidation'=>true
        ]); ?>  
        
      <div class="col-md-12">
            
                
                <?php Pjax::begin(['id'=>'zona_botones']); ?>
                <div class="btn-group">    
                <?php if( !$deshabilitado) {?>   
                 <?= Html::submitButton('<span class="fa fa-save"></span>- -'.Yii::t('base.names', 'Save'), ['class' => 'btn btn-primary']) ?>
                <?php } ?>   
                
               <?php 
                 
                 if(
                     !$model->isNewRecord && //Si es edicion
                     $model->isCreated()  //ademas esta creado
                             ){ 
                  echo Html::button("<span class=\"fa fa-check\"></span>Aprobar", 
                          [
                              'id'=>'btn_fct_aprobar',
                              'class' => 'btn btn-success']
                          );   
                  }  
                  
                  if(!$model->isNewRecord && 
                          $model->isCreated() //Si esta recien creado
                          ){ 
                  echo Html::button("<span class=\"fa fa-trash\"></span>Anular", 
                          [
                              'id'=>'btn_fct_anular',
                              'class' => 'btn btn-danger']
                          );   
                  }  
                  if($model->isPassed()  && (!$model->isPassedSunat() || $model->isRejectedSunat() ) //Si esta aprobada
                          ){ 
                  echo Html::button("<span class=\"fa fa-paper-plane\"></span>Enviar Sunat", 
                          [
                              'id'=>'btn_fct_enviar-sunat',
                              'class' => 'btn btn-warning']
                          );   
                  } 
                  if($model->isPassedSunat()){ 
                  echo Html::button("<span class=\"fa fa-paper-plane\"></span>Baja Sunat", 
                          [
                              'id'=>'btn_fct_anular-sunat',
                              'class' => 'btn btn-danger']
                          );   
                  } 
                
               ?>
              </div> 
               <?php Pjax::end(); ?>
              
           
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
             <?= $form->field($model, 'numero')->textInput(['disabled'=>true,'maxlength' => true]) ?>
        </div>
       <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
           <?php  Pjax::begin(['id'=>'zona_estados']); ?>
                     
             <?= $form->field($model, 'codestado')->textInput(['value'=>$model->statusText(),'disabled'=>true,'maxlength' => true]) ?>
           <?php Pjax::end(); ?>
                    
       </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <?= $form->field($model, 'sunat_tipodoc')->
            dropDownList(
                [
                 h::sunat()->graw('s.01.tdoc')->g('FACTURA')=>yii::t('base.names','Invoice'),
                 h::sunat()->graw('s.01.tdoc')->g('BOLETA')=>yii::t('base.names','Voucher')
                ]
            ,
                    ['prompt'=>'--'.yii::t('base.verbs','Choose a Value')."--",
                    // 'class'=>'probandoSelect2',
                        'disabled'=>true,
                        ]
                    ) ?>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <?php  //h::settings()->invalidateCache();  ?>
                       <?= $form->field($model, 'femision')->widget(DatePicker::class, [
                             'language' => h::app()->language,
                           // 'readonly'=>true,
                          // 'inline'=>true,
                           'pluginOptions'=>[
                                     'format' => h::gsetting('timeUser', 'date')  , 
                                  'changeMonth'=>true,
                                  'changeYear'=>true,
                                 'yearRange'=>"-99:+0",
                               ],
                           
                            //'dateFormat' => h::getFormatShowDate(),
                            'options'=>['class'=>'form-control','disabled'=>$deshabilitado]
                            ]) ?>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
          <?= $form->field($model, 'rucpro')->textInput(['maxlength' => true,
              'disabled'=>$deshabilitado
              ]) ?>
        </div>
   
        <div class="col-lg-8 col-md-8 col-sm-6 col-xs-12">
          <div class="form-group field-zona_pk">
                <label class="control-label" for="zona_pk">
                    Despro
                </label>
             
                <input type="text"  
                       id="zona_pk"
                       class="form-control" 
                       value="<?=($model->isNewRecord)?'':$model->clipro->despro?>"
                       name="ComFactudet[despro]"                       
                       disabled
                  >  
              
            </div>   
         
         
           <?php  /*= $form->field($model, 'despro')->textInput([
               'id'=>'zona_pk',
               'disabled'=>true,
               //'value'=>(empty($model->rucodni))?'':$model->clipro->despro,
               'maxlength' => true])*/ ?>   
         
         

        </div>
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <?= $form->field($model, 'codmon')->
            dropDownList([Tipocambio::COD_MONEDA_DOLAR=>Tipocambio::COD_MONEDA_DOLAR,
                Tipocambio::COD_MONEDA_BASE=>Tipocambio::COD_MONEDA_BASE] ,
                    ['prompt'=>'--'.yii::t('base.verbs','Choose a Value')."--",
                    // 'class'=>'probandoSelect2',
                         'disabled'=>$deshabilitado
                        ]
                    ) ?>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <?= $form->field($model, 'codsoc')->
            dropDownList(ComboHelper::getCboSociedades() ,
                    ['prompt'=>'--'.yii::t('base.verbs','Choose a Value')."--",
                    // 'class'=>'probandoSelect2',
                        
              'disabled'=>$deshabilitado
                        ]
                    ) ?>

        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <?= $form->field($model, 'tipopago')->
            dropDownList(ComboHelper::getTablesValues('com_factura.tipopago') ,
                    ['prompt'=>'--'.yii::t('base.verbs','Choose a Value')."--",
                    // 'class'=>'probandoSelect2',
                        
              'disabled'=>$deshabilitado
                        ]
                    ) ?>
        </div>
          <?php Pjax::begin(['id'=>'zona-totales']); ?>
         <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
             <?= $form->field($model, 'subtotal')->textInput(['disabled'=>true,'maxlength' => true]) ?>
        </div>
        
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
             <?= $form->field($model, 'sunat_totigv')->textInput(['disabled'=>true,'maxlength' => true]) ?>
        </div>
      <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
             <?= $form->field($model, 'sunat_totimpuestos')->textInput(['disabled'=>true,'maxlength' => true]) ?>
        </div>
           <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
             <?= $form->field($model, 'total')->textInput(['disabled'=>true,'maxlength' => true]) ?>
        </div>
             <?php Pjax::end(); ?>
            <?php ActiveForm::end(); ?>
            <?php echo inputAjaxWidget::widget([
            'isHtml'=>true,
            'tipo'=>'POST',
            'ruta'=>Url::to(['/masters/clipro/crea-from-api']),
            'id_input'=>'comfactura-rucpro',
            'idGrilla'=>'zona_pk'
            ])  ?>
   </div> 
    
    <?php Pjax::begin(['id'=>'grilla-contactos']); ?>
    <?php echo inputAjaxWidget::widget([
            //'isHtml'=>true,
             'id'=>'btn_fct_aprobar',
            'otherContainers'=>['zona_botones','zona_estados'],
             'evento'=>'click',
            'tipo'=>'POST',
            'ruta'=>Url::to(['/com/com/ajax-pass-invoice','id'=>$model->id]),
            'id_input'=>'btn_fct_aprobar',
            'idGrilla'=>'zona-pjax-socio'
      ])  ?>  
    
    
     <?php echo inputAjaxWidget::widget([
            //'isHtml'=>true,
             'id'=>'btn_fct_anular',
            'otherContainers'=>['zona_botones','zona_estados'],
             'evento'=>'click',
            'tipo'=>'POST',
            'ruta'=>Url::to(['/com/com/ajax-remove-invoice','id'=>$model->id]),
            'id_input'=>'btn_fct_anular',
            'idGrilla'=>'zona-pjax-socio'
      ])  ?>  
    
     <?php 
     $docu=($model->isInvoice())?'invoice':'voucher';
     echo inputAjaxWidget::widget([
            //'isHtml'=>true,
             'id'=>'btn_fct_enviar-sunat',
           'otherContainers'=>['zona_botones','zona_estados'],
             'evento'=>'click',
            'tipo'=>'POST',
            'ruta'=>Url::to(['/sunat/default/ajax-send-'.$docu.'-std','id'=>$model->id]),
            'id_input'=>'btn_fct_enviar-sunat',
            'idGrilla'=>'pjax-sends-grilla'
      ])  ?>  
    <?php 
    if($model->isInvoice()){
        $ruta='/sunat/default/ajax-down-invoice-sunat';
    }elseif($model->isBoleta()){
        $ruta='/sunat/default/ajax-down-voucher-sunat';
    }else{
       $ruta=''; 
    }
     //$docu=($model->isInvoice())?'invoice':'voucher';
     echo inputAjaxWidget::widget([
            //'isHtml'=>true,
             'id'=>'btn_fct_anular-sunat',
                      'otherContainers'=>['zona_botones','zona_estados'],
             'evento'=>'click',
            'tipo'=>'POST',
            'ruta'=>Url::to([$ruta,'id'=>$model->id]),
            'id_input'=>'btn_fct_anular-sunat',
            'idGrilla'=>'pjax-sends-grilla'
      ])  ?> 

    
   <?php 
   if(!$deshabilitado){
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
            'attribute' => 'item',
           
         ],  
          
         [
            //'class' => 'kartik\grid\EditableColumn',
            'attribute' => 'cant',
           /* 'pageSummary' => 'Total',
            'vAlign' => 'middle',
            'width' => '210px',*/
            
         ],  
        'codart',
                            
       [
            //'class' => 'kartik\grid\EditableColumn',
            'attribute' => 'codum',
           /* 'pageSummary' => 'Total',
            'vAlign' => 'middle',
            'width' => '210px',*/
            
         ],
       [
            //'class' => 'kartik\grid\EditableColumn',
            'attribute' => 'descripcion',
           /* 'pageSummary' => 'Total',
            'vAlign' => 'middle',
            'width' => '210px',*/
            
         ],
         [           
            'attribute' => 'punit', 
             
         ],
          
       [           
            'attribute' => 'punitgravado',          
         ], 
       [
                       'attribute' => 'pventa',          
         ],
                            [  
            'headerOptions' => [
                        'class' => 'text-right',
                        'style' => 'text-align: right;',
                            ],                    
            'attribute' => 'igv',          
         ],
   ];
   echo grid::widget([
    'dataProvider'=> new \yii\data\ActiveDataProvider([
        'query'=> frontend\modules\com\models\ComFactudet::find()-> 
                andWhere(['factu_id'=>$model->id])
    ]),
   // 'filterModel' => $searchModel,
       'summary' => '',
    'columns' => $gridColumns,
    //'responsive'=>true,
    //'hover'=>true
       ]);
   ?> 
   
<?php 
    echo linkAjaxGridWidget::widget([
           'id'=>'widgetgruidBancos',
       // 'otherContainers'=>['pjax-monto','pjax-moneda'],
            'idGrilla'=>'grilla-contactos',
            'family'=>'holas',
          'type'=>'POST',
           'evento'=>'click',
        'posicion'=>\yii\web\View::POS_END
       
            //'foreignskeys'=>[1,2,3],
        ]);
    ?>



    <?php Pjax::end(); ?>    
   
<?php
   if(!$deshabilitado){
      $url= Url::to(['/com/com/new-detail-invoice','id'=>$model->id,'gridName'=>Json::encode(['grilla-contactos','zona-totales']),'idModal'=>'buscarvalor']);
      echo  Html::button('<span class="fa fa-plus"></span>'.yii::t('base.verbs','Add Detail'), ['href' => $url, 'title' => 'Nuevo item de '.$model->numero,'id'=>'btn_contacts','idGrilla'=>Json::encode(['grilla-contactos','zona-totales']),  'class' => 'botonAbre btn btn-success']); 
 
   }
   
  
 /* use lo\widgets\modal\ModalAjax;

echo ModalAjax::widget([
    'id' => 'createCompany',
    'header' => 'Create Company',
    'toggleButton' => [
        'label' => 'New Company',
        'class' => 'btn btn-primary pull-right',
        'id'=>'mibotonmodal'
       // 'style'=>'visibility:hidden',
        
    ],
    'url' => $url, // Ajax view with form to load
    'ajaxSubmit' => true, // Submit the contained form as ajax, true by default
    //para que no se esconda la ventana cuando presionas una tecla fuera del marco
    'clientOptions' => ['tabindex'=>'','backdrop' => 'static', 'keyboard' => FALSE]
    // ... any other yii2 bootstrap modal option you need
]);*/
 ?>  
</div>
  

