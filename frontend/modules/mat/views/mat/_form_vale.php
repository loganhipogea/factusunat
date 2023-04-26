<?php
 use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\helpers\Url;
USE common\helpers\h;
use yii\widgets\ActiveForm;
use common\widgets\linkajaxgridwidget\linkAjaxGridWidget;
use  common\widgets\selectwidget\selectWidget;
use frontend\modules\mat\helpers\ComboHelper;
use yii\widgets\Pjax;
use yii\grid\GridView;
use common\widgets\inputajaxwidget\inputAjaxWidget;
use common\widgets\cbodepwidget\cboDepWidget as ComboDep;
/* @var $this yii\web\View */
/* @var $model frontend\modules\mat\models\MatReq */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="mat-req-form">
    <br>
  <div class="box-body">
    <?php $form = ActiveForm::begin([
    'fieldClass'=>'\common\components\MyActiveField',
        'enableAjaxValidation'=>true,
    ]); 
    $bloqueado=$model->isBloqueado();
   
    ?>
      <div class="box-header">
        <div class="col-md-12">
            <div class="form-group no-margin">
               <div class="btn-group">  
        <?= Html::submitButton('<span class="fa fa-save"></span>   '.Yii::t('app', 'Grabar'), ['class' => 'btn btn-success']) ?>
           <?php 
            if($model->isCreado())
           echo Html::button( '<span class="fa fa-chek"></span>   '.Yii::t('base.names', 'Aprobar'),
                  ['class' => 'btn btn-success','href' => '#','id'=>'btn-aprobar']
                 );
            if($model->isCreado())
           echo Html::button( '<span class="fa fa-chek"></span>   '.Yii::t('base.names', 'Aprobar'),
                  ['class' => 'btn btn-success','href' => '#','id'=>'btn-aprobar']
                 );
            
               ?> 
                </div>
            </div>
        </div>
    </div>
      
    

  <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'numero')->textInput(['maxlength' => true,'disabled'=>true]) ?>

 </div>
 <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true,'disabled'=>(!$bloqueado)?false:true  ]) ?>
     
 </div>
 <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'codest')->textInput(['maxlength' => true,'disabled'=>true  ]) ?>
     
 </div>
  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12"> 
     <?php 
  // $necesi=new Parametros;
    echo selectWidget::widget([
           // 'id'=>'mipapa',
            'model'=>$model,
            'form'=>$form,
            'campo'=>'codpro',
         'ordenCampo'=>1,
         'addCampos'=>[2,3],
        ]);  ?>

 </div> 
 <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">    
 <?= $form->field($model, 'codal')->
            dropDownList(ComboHelper::getCboAlmacenes(null),
                  ['prompt'=>'--'.yii::t('base.verbs','Choose a Value')."--",
                    // 'class'=>'probandoSelect2',
                     'disabled'=>($model->hasChilds())?'disabled':null,
                        ]
                    ) ?>
 </div> 
 
 <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">   
    <?= ComboDep::widget([
               'model'=>$model,               
               'form'=>$form,
               'data'=> ComboHelper::getCboTransaccionesAlmacen(),
               'campo'=>'codmov',
               'idcombodep'=>'matvale-codocu',
               /* 'source'=>[ //fuente de donde se sacarn lso datos 
                    /*Si quiere colocar los datos directamente 
                     * para llenar el combo aqui , hagalo coloque la matriz de los datos
                     * aqui:  'id1'=>'valor1', 
                     *        'id2'=>'valor2,
                     *         'id3'=>'valor3,
                     *        ...
                     * En otro caso 
                     * de la BD mediante un modelo  
                     */
                        /*Docbotellas::className()=>[ //NOmbre del modelo fuente de datos
                                        'campoclave'=>'id' , //columna clave del modelo ; se almacena en el value del option del select 
                                        'camporef'=>'descripcion',//columna a mostrar 
                                        'campofiltro'=>'codenvio'/* //cpolumna 
                                         * columna que sirve como criterio para filtrar los datos 
                                         * si no quiere filtrar nada colocwue : false | '' | null
                                         *
                        
                         ]*/
                   'source'=>[frontend\modules\com\models\MatVwTransadocs::className()=>
                                [
                                  'campoclave'=>'codocu' , //columna clave del modelo ; se almacena en el value del option del select 
                                        'camporef'=>'desdocu',//columna a mostrar 
                                        'campofiltro'=>'codtrans'  
                                ]
                                ],
                            ]
               
               
        )  ?>
 </div> 
 <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">    
 <?= $form->field($model, 'codocu')->
            dropDownList(($model->isNewRecord)?[]:ComboHelper::getCboTransaccionesDocus($model->codmov),
                  ['prompt'=>'--'.yii::t('base.verbs','Choose a Value')."--",
                    // 'class'=>'probandoSelect2',
                      //'disabled'=>($model->isBlockedField('codpuesto'))?'disabled':null,
                        ]
                    ) ?>
 </div> 
          
  
                  
 <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'numerodoc')->textInput(['maxlength' => true,'disabled'=>(!$bloqueado)?false:true  ]) ?>
     
 </div>   
         
      
  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
     
 <?= $form->field($model, 'fecha')->widget(DatePicker::class, [
                            'language' => h::app()->language,
                           'pluginOptions'=>[
                                     'format' => h::gsetting('timeUser', 'date')  , 
                                   'changeMonth'=>true,
                                  'changeYear'=>true,
                                 'yearRange'=>'2014:'.date('Y'),
                               ],
                          
                            //'dateFormat' => h::getFormatShowDate(),
                            'options'=>['class'=>'form-control',
                               'disabled'=>(!$bloqueado)?false:true  
                                ]
                            ]) ?>
 </div>
 <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
     
 <?= $form->field($model, 'fechacon')->widget(DatePicker::class, [
                            'language' => h::app()->language,
                           'pluginOptions'=>[
                                     'format' => h::gsetting('timeUser', 'date')  , 
                                   'changeMonth'=>true,
                                  'changeYear'=>true,
                                 'yearRange'=>'2014:'.date('Y'),
                               ],
                          
                            //'dateFormat' => h::getFormatShowDate(),
                            'options'=>['class'=>'form-control',
                               'disabled'=>(!$bloqueado)?false:true  
                                ]
                            ]) ?>
 </div>
   

   <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">   
    <?php  
     if($model->isNewRecord){
       echo $this->render('_vale_tabular_detalle',[
         'model'=>$model,
         'form'=>$form,
         'items'=>$items]);  
     }else{
        echo $this->render('_vale_grid_detalle',[
         'model'=>$model,
         //'form'=>$form,
         //'items'=>$items
         ]);  
     }
    ?>
   </div>        
           
  <?php ActiveForm::end(); ?>      
   </div>     
     
          
 <?php 
 if(!$model->isNewRecord){
  $string="$('#btn-aprobar').on( 'click', function(){ 
     
       $.ajax({
              url: '".Url::to(['/mat/mat/ajax-aprobar-vale','id'=>$model->id])."', 
              type: 'get',
              data:{id:".$model->id."  },
              dataType: 'json', 
              error:  function(xhr, textStatus, error){               
                            var n = Noty('id');                      
                              $.noty.setText(n.options.id, error);
                              $.noty.setType(n.options.id, 'error');       
                                }, 
              success: function(json) {
              var n = Noty('id');
                      
                       if ( !(typeof json['error']==='undefined') ) {
                        $.noty.setText(n.options.id,'<span class=\'glyphicon glyphicon-trash\'></span>      '+ json['error']);
                              $.noty.setType(n.options.id, 'error');  
                          }    

                             if ( !(typeof json['warning']==='undefined' )) {
                        $.noty.setText(n.options.id,'<span class=\'glyphicon glyphicon-trash\'></span>      '+ json['warning']);
                              $.noty.setType(n.options.id, 'warning');  
                             } 
                          if ( !(typeof json['success']==='undefined' )) {
                        $.noty.setText(n.options.id,'<span class=\'glyphicon glyphicon-trash\'></span>      '+ json['success']);
                              $.noty.setType(n.options.id, 'success');  
                             }      
                   
                        }
                        });


             })";
  
   $this->registerJs($string, \yii\web\View::POS_END);
 }
  ?>          

    </div>
