<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use common\helpers\h;
use common\widgets\selectwidget\selectWidget;
use kartik\date\DatePicker;
use common\widgets\inputajaxwidget\inputAjaxWidget;
?>

<div class="mat-petoferta-form">
    
    
    
    <br>
   
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">  
    
    
    
    
    
    <?php $form = ActiveForm::begin([
    //'fieldClass'=>'\common\components\MyActiveField',
      'id'=>'myform',
        'enableAjaxValidation'=>true,
       //'enableClientValidation'=>true
    ]); ?>
      <div class="box-header">
        <div class="col-md-12">
            <div class="form-group no-margin">
                
        <?= Html::submitButton('<span class="fa fa-save"></span>   '.Yii::t('app', 'Grabar'), ['class' => 'btn btn-success']) ?>
            

            </div>
        </div>
    </div>
      <div class="box-body">
    
  <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'numero')->textInput(['maxlength' => true,'disabled'=>true]) ?>

 </div>
  <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
    <?= $form->field($model, 'codmon')->
            dropDownList(\common\helpers\ComboHelper::getCboMonedas() ,
                    ['prompt'=>'--'.yii::t('base.verbs','Choose a Value')."--",                    
                        ]
                    ) ?>

 </div>
  <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
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
                            //   'disabled'=>(!$aprobado)?false:true  
                                ]
                            ]) ?>

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
         'addCampos'=>[2],
        ]);  ?>

 </div>
  <div class="col-lg-1 col-md-1 col-sm-1 col-xs-1">
      <br>
      <div style="margin-top:10px;margin-left:0px;padding-left:0px;">
       <?php
         $url= Url::to(['/masters/clipro/modal-crea-rapido']);
        echo  Html::button('<span class="fa fa-plus"></span>', ['href' => $url, 'title' => 'Crea un nuevo proveedor ','id'=>'btn_add_prove','idGrilla'=>'zona-pjax',  'class' => 'botonAbre btn btn-success']); 
       ?>
        </div>
       
   </div>       
  <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
     <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true]) ?>

 </div>        
  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
       <?php 
  // $necesi=new Parametros;
    echo selectWidget::widget([
           // 'id'=>'mipapa',
            'model'=>$model,
            'form'=>$form,
            'campo'=>'codtra',
         'ordenCampo'=>1,
         'addCampos'=>[2,3],
        ]);  ?>

 </div>         
   
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
     <?= $form->field($model, 'detalle')->textarea(['rows' => 6]) ?>

 </div>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
          <label class="control-label" for="buscador_id">Explorar</label>
          <input  type="text" id="buscador_id" class="form-control">
      </div>
      <div id="zona_stock" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
          
      </div>
       <?php 
       
      // var_dump(h::sunat()->gRaw('s.01.tdoc')->data,h::sunat()->gRaw('s.01.tdoc')->g('FAC'));
       echo inputAjaxWidget::widget([
            'isHtml'=>true,//Devuelve datos Html
            'isDivReceptor'=>true,//Es un diov que recibe Html
            'tipo'=>'POST',            
            'evento'=>'keypress',
            'ruta'=>Url::to(['/mat/mat/ajax-show-material']),
            'id_input'=>'buscador_id',
            'idGrilla'=>'zona_stock'
      ])  ?>
  </div>     
    
    
    <?php  
    
     echo $this->render('_tabular_detalle',[
         'model'=>$model,
         'form'=>$form,
         'items'=>$items]);
    
    
    ?>
     <?php ActiveForm::end(); ?>
</div>
    </div>
</div>
