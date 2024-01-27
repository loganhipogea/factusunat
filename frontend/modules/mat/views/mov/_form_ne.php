<?php
 use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\helpers\Url;
USE common\helpers\h;
use yii\widgets\ActiveForm;
//use common\widgets\linkajaxgridwidget\linkAjaxGridWidget;
//use  common\widgets\selectwidget\selectWidget;
use frontend\modules\mat\helpers\comboHelper;
use yii\widgets\Pjax;
//use yii\grid\GridView;
use common\widgets\inputajaxwidget\inputAjaxWidget;
//use common\widgets\cbodepwidget\cboDepWidget as ComboDep;
  USE common\helpers\FileHelper as Fl;
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
    $bloqueado=false;
   
    ?>
     <?php Pjax::begin(['id'=>'cabecera']);?>
      <div class="box-header">
        <div class="col-md-12">
            <div class="form-group no-margin">
               <div class="btn-group">  
        <?= Html::submitButton('<span class="fa fa-save"></span>   '.Yii::t('app', 'Grabar'), ['class' => 'btn btn-success']) ?>
           <?php 
            $ext= json_encode(array_merge(Fl::extImages(),Fl::extDocs()));
                /*echo Html::button( '<span class="fa fa-check-circle"></span>   '.Yii::t('base.names', 'Aprobar'),
                  ['class' => 'btn btn-success','href' => '#','id'=>'btn-aprobar']
                 );
                echo Html::button( '<span class="fa fa-trash"></span>   '.Yii::t('base.names', 'Anular'),
                  ['class' => 'btn btn-danger','href' => '#','id'=>'btn-anular']
                 );
            
           */
           
                $url=Url::to(['/mat/mov/make-pdf-ne','id'=>$model->id]);
                 echo Html::a('<span class="fa fa-print" ></span> Imprimir',$url,['target'=>'_blank','data-pjax'=>'0','class'=>"btn btn-danger"]);
                
                  $url=\yii\helpers\Url::toRoute(['/finder/audit','isImage'=>false,'idModal'=>'imagemodal','modelid'=>$model->id,'nombreclase'=> str_replace('\\','_',$model::className())]);
                        $options = [
                            'title' => Yii::t('app', 'C. cambios'),
                            //'aria-label' => Yii::t('rbac-admin', 'Activate'),
                            //'data-confirm' => Yii::t('rbac-admin', 'Are you sure you want to activate this user?'),
                            'data-method' => 'get',
                            //'data-pjax' => '0',
                        ];
                        echo Html::button('<span class="fa fa-bars"></span>'.Yii::t('app', 'C. cambios'), ['href' => $url, 'title' => 'Auditoría', 'class' => 'botonAbre btn btn-warning']);
                        //return Html::a('<span class="btn btn-success glyphicon glyphicon-pencil"></span>', Url::toRoute(['view-profile','iduser'=>$model->id]), []/*$options*/);
                     
                  $url=\yii\helpers\Url::toRoute(['/finder/selectimage','isImage'=>true,
                             'idModal'=>'imagemodal',
                             'extension'=>$ext,
                             'grillas'=>'cabecera',
                             'modelid'=>$model->id,
                             'nombreclase'=> str_replace('\\','_',get_class($model))]);
                       
                        echo Html::button('<span class="glyphicon glyphicon-paperclip"></span>', ['href' => $url, 'title' => 'Editar Adjunto', 'class' => 'botonAbre btn btn-success']);
                       
               ?> 
                </div>
            </div>
        </div>
    </div>
      
    

  <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'numero')->textInput(['style'=>'color:#6B0755; font-weight:700; font-size:1.2em',  'maxlength' => true,'disabled'=>true]) ?>

 </div>
 <div class="col-lg-6 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true,'disabled'=>(!$bloqueado)?false:true  ]) ?>
     
 </div>
 <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12">
     <?= $form->field($model, 'codest')->textInput(['style'=>'color:#F84E35; font-weight:700; font-size:1.2em','value'=>$model->comboValueText('codest'),'maxlength' => true,'disabled'=>true  ]) ?>
     
 </div>
  
     <?php 
 
    /*echo selectWidget::widget([
           // 'id'=>'mipapa',
            'model'=>$model,
            'form'=>$form,
            'campo'=>'codpro',
         'ordenCampo'=>1,
         'addCampos'=>[2],
        ]); */ ?>


 
<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">    
 <?= $form->field($model, 'codcencli')->
            dropDownList(comboHelper::getCboSucursales(),
                  ['prompt'=>'--'.yii::t('base.verbs','Choose a Value')."--",
                    // 'class'=>'probandoSelect2',
                      'disabled'=>$bloqueado,
                        ]
                    ) ?>
 </div> 
 

 <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">    
 <?= $form->field($model, 'codcen')->
            dropDownList(comboHelper::getCboCentros(),
                  ['prompt'=>'--'.yii::t('base.verbs','Choose a Value')."--",
                    // 'class'=>'probandoSelect2',
                      'disabled'=>$bloqueado,
                        ]
                    ) ?>
 </div> 
  
                  
 <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
     <?= $form->field($model, 'placa')->textInput(['maxlength' => true,'disabled'=>(!$bloqueado)?false:true  ]) ?>
 
 </div>   
         
      
  <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
     
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
<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
     <?= $form->field($model, 'numdocref')->textInput(['maxlength' => true,]) ?>
 
 </div>  
 <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">    
 <?= $form->field($model, 'codocuref')->
            dropDownList(comboHelper::getCboDocuments(),
                  ['prompt'=>'--'.yii::t('base.verbs','Choose a Value')."--",
                    // 'class'=>'probandoSelect2',
                      //'disabled'=>$bloqueado,
                        ]
                    ) ?>
 </div> 

      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <?= $form->field($model, 'detalle')->textArea(['disabled'=>(!$bloqueado)?false:true  ]) ?>
    
      
      </div>  

   <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">   
    <?php  
     if($model->isNewRecord){
       echo $this->render('_ne_tabular_detalle',[
         'model'=>$model,
         'bloqueado'=>$bloqueado,
         'form'=>$form,
         'items'=>$items]);  
     }else{
        echo $this->render('_vale_ne_detalle',[
         'model'=>$model,
         'bloqueado'=>$bloqueado,
         //'form'=>$form,
         //'items'=>$items
         ]);  
     }
    ?>
   </div>        
     <?php Pjax::end();?>        
  <?php ActiveForm::end(); ?>      
   </div>     
    <?php 
       
      // var_dump(h::sunat()->gRaw('s.01.tdoc')->data,h::sunat()->gRaw('s.01.tdoc')->g('FAC'));
       echo inputAjaxWidget::widget([
           // 'isHtml'=>true,//Devuelve datos Html
            //'isDivReceptor'=>true,//Es un diov que recibe Html
            'tipo'=>'POST', 
           // 'data'=>['idpet'=>$model->id],
            'evento'=>'click',
            'ruta'=>Url::to(['/mat/mat/ajax-aprobar-vale','id'=>$model->id]),
            'id_input'=>'btn-aprobar',
            'idGrilla'=>'cabecera'
      ])  ?>  
          
         
<?php 
       
      // var_dump(h::sunat()->gRaw('s.01.tdoc')->data,h::sunat()->gRaw('s.01.tdoc')->g('FAC'));
       echo inputAjaxWidget::widget([
           // 'isHtml'=>true,//Devuelve datos Html
            //'isDivReceptor'=>true,//Es un diov que recibe Html
            'tipo'=>'POST', 
           // 'data'=>['idpet'=>$model->id],
            'evento'=>'click',
            'ruta'=>Url::to(['/mat/mat/ajax-anular-vale','id'=>$model->id]),
            'id_input'=>'btn-anular',
            'idGrilla'=>'cabecera'
      ])  ?>  
          

 </div>
