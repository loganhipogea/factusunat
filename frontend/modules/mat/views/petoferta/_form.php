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
            <div class="btn-group"> 
                    <?= Html::submitButton('<span class="fa fa-save"></span>   '.Yii::t('app', 'Grabar'), ['class' => 'btn btn-success']) ?>
                    <?php if($model->previous()>0){?>
                    <?php $url=Url::to(['/mat/petoferta/update-pet-oferta','id'=>$model->previous()]);?>
                    <?=Html::a('<span class="fa fa-angle-left" ></span>',$url,['target'=>'_blank','data-pjax'=>'0','class'=>"btn btn-danger"])?>
                    <?php }?>
                
                     <?php if($model->next()>0){?>
                    
                    <?php $url=Url::to(['/mat/petoferta/update-pet-oferta','id'=>$model->next()]);?>
                    <?=Html::a('<span class="fa fa-angle-right" ></span>',$url,['target'=>'_blank','data-pjax'=>'0','class'=>"btn btn-danger"])?>
                    <?php }?>
                
                    <?php if($model->isClonable()){?>
                    
                    <?php $url=Url::to(['/mat/petoferta/clone-pet-oferta','id'=>$model->id]);?>
                    <?=Html::a('<span class="fa fa-copy" ></span>'.Yii::t('app', 'Clonar'),$url,['target'=>'_blank','data-pjax'=>'0','class'=>"btn btn-danger"])?>
                    <?php }?>
                   <?php if(!$model->isNewRecord) {?>
                   <?= common\widgets\auditwidget\auditWidget::widget(['model'=>$model])?>
                   <?php }?>
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
 <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
     <?= $form->field($model, 'igv')->checkbox([]) ?>

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
     <?= $form->field($model, 'detalle')->textarea(['rows' => 2]) ?>

 </div>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <?php if(!$model->isNewRecord){  ?>
    <?= \common\widgets\imagewidget\ImageWidget::widget([
        'name'=>'imagenrep',
        'isImage'=>false,  
        'model'=>$model,
        'extensions'=>['pdf','doc','docx','png','jpg'],
            ]); ?>
   
    <?= \nemmo\attachments\components\AttachmentsTable::widget([
	'model' => $model,
	//'showDeleteButton' => false, // Optional. Default value is true
        ])?>
    <?php } ?> 
  </div> 
<?php /*if($model->isNewRecord) { */?>
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
            'data'=>['idpet'=>$model->id],
            'evento'=>'keypress',
            'ruta'=>Url::to(['/mat/mat/ajax-show-material']),
            'id_input'=>'buscador_id',
            'idGrilla'=>'zona_stock'
      ])  ?>
  </div>     
 <?php /*}*/ ?>   
 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">   
    <?php  
     if($model->isNewRecord){
       echo $this->render('_tabular_detalle',[
         'model'=>$model,
         'form'=>$form,
         'items'=>$items]);  
     }else{
        echo $this->render('_grid_detalle',[
         'model'=>$model,
         //'form'=>$form,
         //'items'=>$items
         ]);  
     }
    ?>
   </div>   
     <?php ActiveForm::end(); ?>
</div>
    </div>
</div>
