<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use common\widgets\cbodepwidget\cboDepWidget as ComboDep;
use frontend\modules\op\helpers\ComboHelper;
use common\widgets\selectwidget\selectWidget;
use common\widgets\inputajaxwidget\inputAjaxWidget;

/* @var $this yii\web\View */
/* @var $model frontend\modules\sigi\models\Edificios */
/* @var $form yii\widgets\ActiveForm */
?>

<?php
  $bloqueado=($model->isBloqueado() || $model->isCreatedFromOrder());
  //var_dump($model->isBloqueado(),$model->isCreatedFromOrder(),$bloqueado);die();
?>


<div class="edificios-form">
    <br>
    <?php $form = ActiveForm::begin([
        'id'=>'myformulario',
    'fieldClass'=>'\common\components\MyActiveField'
    ]); ?>
      <div class="box-header">
        <div class="col-md-12">
            <div class="form-group no-margin">
           <?PHP 
           $operacion=($model->isNewRecord)?'mod-agrega-mat':'mod-edit-mat';
             IF($model->isNewRecord){
               
                 $url=\yii\helpers\Url::to(['/mat/mat/'.$operacion,'id'=>$id,]);  
               
               
             }else{
                
                 $url=\yii\helpers\Url::to(['/mat/mat/'.$operacion,'id'=>$id]);    
               
             }
           ?>
           <?= \common\widgets\buttonsubmitwidget\buttonSubmitWidget::widget(
                  ['idModal'=>$idModal,
                    'idForm'=>'myformulario',
                      'url'=> $url,
                     'idGrilla'=>$gridName, 
                      ]
                  )?>
            </div>
        </div>
    </div>
      <div class="box-body">
     <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <?= $form->field($model, 'cant')->textInput([
                
                'maxlength' => true,'disabled'=>$bloqueado,
                ]) ?>

    </div>
    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
     <?= 
            $form->field($model, 'um')->
            dropDownList(ComboHelper::getCboUms(),
                    ['prompt'=>'--'.yii::t('base.verbs','Seleccione un valor')."--",
                    // 'class'=>'probandoSelect2',
                      'disabled'=>$bloqueado,
                        ]
                    )  ?>
     </div>
 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
     <?php 
  // $necesi=new Parametros;
    echo selectWidget::widget([
           // 'id'=>'mipapa',
            'model'=>$model,
            'form'=>$form,
            'campo'=>'codart',
         'ordenCampo'=>2,
         'addCampos'=>[2,],
        'options'=>['disabled'=>$bloqueado,]
        ]);  ?>

 </div> 
 
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
     <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true,'disabled'=>$bloqueado,]) ?>

 </div>

  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
     <?= $form->field($model, 'texto')->textArea(['maxlength' => true,'disabled'=>$bloqueado,]) ?>
 </div>        
          
          
   <?php if($model->isCreatedFromOrder()){   ?>       
            
              <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
    <?= ComboDep::widget([
               'model'=>$model,               
               'form'=>$form,
               'data'=> comboHelper::procesos() ,
               'campo'=>'proc_id',
               'idcombodep'=>'matdetreq-os_id',
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
                   'source'=>[\frontend\modules\op\models\OpOs::className()=>
                                [
                                  'campoclave'=>'id' , //columna clave del modelo ; se almacena en el value del option del select 
                                        'camporef'=>'descripcion',//columna a mostrar 
                                        'campofiltro'=>'proc_id'  
                                ]
                                ],
                    'inputOptions'=>['disabled'=>$bloqueado,]
                            ],
               
               
        )  ?>
 </div>       
          
          
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
    <?= ComboDep::widget([
               'model'=>$model,               
               'form'=>$form,
               'data'=> ($model->isNewRecord)?[]:ComboHelper::Os(),
               'campo'=>'os_id',
               'idcombodep'=>'matdetreq-detos_id',
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
                    'source'=>[\frontend\modules\op\models\OpOsdet::className()=> 
                                [
                                  'campoclave'=>'id' , //columna clave del modelo ; se almacena en el value del option del select 
                                        'camporef'=>'descripcion',//columna a mostrar 
                                        'campofiltro'=>'os_id'  
                                ]
                                ],
                    'inputOptions'=>['disabled'=>$bloqueado,]
                            ]
                
               
        )  ?>
 </div> 
 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
     
     
 <?= $form->field($model, 'detos_id')->
            dropDownList(($model->isNewRecord)?[]:ComboHelper::actividadesOs($model->os_id),
                  ['prompt'=>'--'.yii::t('base.verbs','Choose a Value')."--",
                    // 'class'=>'probandoSelect2',
                     'disabled'=>$bloqueado,
                        ]
                    ) ?>
 </div> 
  
   <?php }  ?>  
          
 <?php if($model->isCreatedFromCeco()){   ?>          
       <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <?php 
  // $necesi=new Parametros;
    echo selectWidget::widget([
           // 'id'=>'mipapa',
            'model'=>$model,
            'form'=>$form,
            'campo'=>'ceco_id',
         'ordenCampo'=>1,
         'addCampos'=>[3,],
        'options'=>['disabled'=>$bloqueado,]
        ]);  ?>

        </div>   
 <?php }  ?>   
          
    <?php ActiveForm::end(); ?>
     <?php 
       
      // var_dump(h::sunat()->gRaw('s.01.tdoc')->data,h::sunat()->gRaw('s.01.tdoc')->g('FAC'));
       echo inputAjaxWidget::widget([
            'isHtml'=>true,//Devuelve datos Html
            'isDivReceptor'=>true,//Es un diov que recibe Html
            'tipo'=>'POST', 
            ///'data'=>['codart'=>$model->id],
            'evento'=>'change',
            'ruta'=>Url::to(['/masters/materials/ajax-html-ums']),
            'id_input'=>'matdetreq-codart',
            'idGrilla'=>'matdetreq-um'
      ])  ?>        
          

</div>
    </div>
 

