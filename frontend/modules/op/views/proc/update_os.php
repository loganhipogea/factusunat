<?php


use kartik\tabs\TabsX;
use kartik\date\DatePicker;
use yii\helpers\Html;
use dosamigos\ckeditor\CKEditor;
use common\widgets\selectwidget\selectWidget;
use common\helpers\h;
 use yii\helpers\Url;
use kartik\slider\Slider;

use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model frontend\modules\sta\models\Talleres */
ECHO \common\widgets\spinnerWidget\spinnerWidget::widget();
/* @var $this yii\web\View */
/* @var $model frontend\modules\op\models\OpProcesos */

$this->title = Yii::t('app', 'Editar OS: {name}', [
    'name' => $model->numero,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Proceso ').$model->proceso->numero, 'url' => ['update','id'=>$model->proc_id]];

$this->params['breadcrumbs'][] = Yii::t('app', 'Volver a Proceso');
?>
<h4><i class="fa fa-edit"></i><?= Html::encode($this->title) ?></h4>

    <div class="box box-success">

   
    
     <?php
    $aprobado=false;
    $form = ActiveForm::begin([
    'fieldClass'=>'\common\components\MyActiveField'
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
     <?= $form->field($model, 'numero')->textInput(['disabled'=>true,'maxlength' => true]) ?>

 </div>
   <div class="col-lg-8 col-md-8 col-sm-6 col-xs-12">
     <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true]) ?>

   </div>
   <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
      <?= $form->field($model, 'fechaprog')->widget(DatePicker::class, [
                            'language' => h::app()->language,
                           'pluginOptions'=>[
                                     'format' => h::gsetting('timeUser', 'date')  , 
                                   'changeMonth'=>true,
                                  'changeYear'=>true,
                                 'yearRange'=>'2014:'.date('Y'),
                               ],
                          
                            //'dateFormat' => h::getFormatShowDate(),
                            'options'=>['class'=>'form-control',
                               //'disabled'=>(!$aprobado)?false:true  
                                ]
                            ]) ?>
 </div>
   <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
      <?= $form->field($model, 'fechaini')->widget(DatePicker::class, [
                            'language' => h::app()->language,
                           'pluginOptions'=>[
                                     'format' => h::gsetting('timeUser', 'date')  , 
                                   'changeMonth'=>true,
                                  'changeYear'=>true,
                                 'yearRange'=>'2014:'.date('Y'),
                               ],
                          
                            //'dateFormat' => h::getFormatShowDate(),
                            'options'=>['class'=>'form-control',
                              // 'disabled'=>(!$aprobado)?false:true  
                                ]
                            ]) ?>
 </div>
   <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
      <?= $form->field($model, 'finprog')->widget(DatePicker::class, [
                            'language' => h::app()->language,
                           'pluginOptions'=>[
                                     'format' => h::gsetting('timeUser', 'date')  , 
                                   'changeMonth'=>true,
                                  'changeYear'=>true,
                                 'yearRange'=>'2014:'.date('Y'),
                               ],
                          
                            //'dateFormat' => h::getFormatShowDate(),
                            'options'=>['class'=>'form-control',
                               //'disabled'=>(!$aprobado)?false:true  
                                ]
                            ]) ?>
 </div>
   <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
      <?= $form->field($model, 'fin')->widget(DatePicker::class, [
                            'language' => h::app()->language,
                           'pluginOptions'=>[
                                     'format' => h::gsetting('timeUser', 'date')  , 
                                   'changeMonth'=>true,
                                  'changeYear'=>true,
                                 'yearRange'=>'2014:'.date('Y'),
                               ],
                          
                            //'dateFormat' => h::getFormatShowDate(),
                            'options'=>['class'=>'form-control',
                              // 'disabled'=>(!$aprobado)?false:true  
                                ]
                            ]) ?>
 </div>
 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"> 
     <?php 
  // $necesi=new Parametros;
    /*echo selectWidget::widget([
           // 'id'=>'mipapa',
            'model'=>$model,
            'form'=>$form,
            'campo'=>'codtra',
         'ordenCampo'=>1,
         'addCampos'=>[2,3],
        ]);  */ ?>

 </div> 
 
  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
     <?= $form->field($model, 'codpro')->textInput(['maxlength' => true,'value'=>$model->cliente->despro]) ?>

 </div>
   <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
     <?= $form->field($model, 'orden')->textInput(['maxlength' => true]) ?>

 </div>
   <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
     <?= $form->field($model, 'ot')->textInput(['maxlength' => true]) ?>

       
     
 </div> 
 
  
  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">        
   <?php  echo Slider::widget([
    'sliderColor' => Slider::TYPE_DANGER,
    'handleColor' => Slider::TYPE_DANGER,
    'model'=>$model,
       'attribute'=>'avance',
    'pluginOptions' => [
        'orientation' => 'horizontal',
        'handle' => 'round',
        'min' => 0,
        'max' => 100,
        'step' => 1
    ],
]);
   ?>
   </div>         
 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <?PHP
     echo $form->field($model, 'textointerno')
             ->widget(\dosamigos\ckeditor\CKEditor::className(), [
        'options' => [
            'rows' => 2,
               ],
            'preset' => 'basic',
            //'toolbWar'=>[ 'undo', 'redo', 'bold', 'italic', 'numberedList', 'bulletedList' ]
    
            
         'clientOptions'=>['language'=>'es',
             ],
        ]);
      ?>

 </div>
 
      
<?php
   ActiveForm::end();
 
 ?>
      </DIV><!-- comment -->
  <div class="box-body">
    <?php echo TabsX::widget([
    'position' => TabsX::POS_ABOVE,
     'bordered'=>true,
    'align' => TabsX::ALIGN_LEFT,
      'encodeLabels'=>false,
    'items' => [
        
       
        [
          'label'=>'<i class="fa fa-puzzle-piece"></i> '.yii::t('base.names','Actividades'), //$this->context->countDetail() obtiene el contador del detalle
            'content'=> $this->render('_form_os',[
                'model' => $model,
                'form'=>$form,
                'aprobado'=>$aprobado,
                //'dataProviderMateriales' =>$dataProviderMateriales,
               // 'dataProviderServicios' =>$dataProviderServicios,
                    ]),
            'active' => true,
             'options' => ['id' => 'myveryownID3'],
        ],
        [
          'label'=>'<i class="fa fa-cube"></i> '.yii::t('base.names','Materiales'), //$this->context->countDetail() obtiene el contador del detalle
            'content'=> $this->render('_materiales_os',
                    [ 
                'model' => $model,
                 'searchModel' => $searchModel,
                 'dataProviderMateriales' =>$dataProviderMateriales,
                'aprobado'=>$aprobado
                    ]),
            'active' => false,
             'options' => ['id' => 'myveryownID4'],
        ],
       [
          'label'=>'<i class="fa fa-wrench"></i> '.yii::t('base.names','Servicios'), //$this->context->countDetail() obtiene el contador del detalle
            'content'=> $this->render('_servicios_os',
                    [ 
                'model' => $model,
                 'searchModelServ' => $searchModelServ,
                'dataProviderServicios' =>$dataProviderServicios,
                'aprobado'=>$aprobado
                    ]),
            'active' => false,
             'options' => ['id' => 'myveryfsffownID4'],
        ], 
       
        
       
    ],
]);  
?>
 
  </DIV>
     </DIV>