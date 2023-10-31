<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

use frontend\modules\op\helpers\ComboHelper;

 //use kartik\date\DatePicker;
use kartik\datetime\DateTimePicker;
use common\widgets\selectwidget\selectWidget;
use common\helpers\h;
use common\widgets\inputajaxwidget\inputAjaxWidget;
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
           $operacion=($model->isNewRecord)?'modal-agrega-det-req-libre':'modal-edita-det-req';
             IF($model->isNewRecord){
               $url=\yii\helpers\Url::to(['/op/proc/'.$operacion,'id'=>$id]);  
                 
             }else{
                $url=\yii\helpers\Url::to(['/op/proc/'.$operacion,'id'=>$id]);  
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
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <?= 
                   //$model->activo=false;
            $form->field($model, 'detos_id')->
            dropDownList(comboHelper::actividadesOs($model->os_id) ,
                    ['prompt'=>'--'.yii::t('base.verbs','Seleccione un valor')."--",
                    // 'class'=>'probandoSelect2',
                     'disabled'=>$bloqueado,
                        ]
                    )  ?>

        </div>   
         
         
         
     <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <?= $form->field($model, 'cant')->textInput(['maxlength' => true,'disabled'=>$bloqueado,]) ?>

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
      <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
     <?= 
            $form->field($model, 'codal')->
            dropDownList(ComboHelper::getCboAlmacenes(),
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
        'options'=>[ 'disabled'=>$bloqueado,]
        ]);  ?>

 </div> 
 
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
     <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true, 'disabled'=>$bloqueado,]) ?>

 </div>

  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
     <?= $form->field($model, 'texto')->textArea(['maxlength' => true, 'disabled'=>$bloqueado,]) ?>
 </div>        
          
  
  
      
          
     
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

